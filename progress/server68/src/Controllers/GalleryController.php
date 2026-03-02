<?php

declare(strict_types=1);

namespace Scanbox\Controllers;

use Scanbox\Core\Auth;
use Scanbox\Core\Database;
use Scanbox\Core\ImageHandler;
use Scanbox\Models\Gallery;
use Scanbox\Models\GalleryItem;

class GalleryController
{
    private Gallery $galleryModel;
    private GalleryItem $galleryItemModel;

    public function __construct()
    {
        if (!Auth::check()) {
            header('Location: /admin/login');
            exit;
        }

        $this->galleryModel = new Gallery();
        $this->galleryItemModel = new GalleryItem();
    }

    /**
     * Lista toate galeriile
     */
    public function index(): void
    {
        $galleries = $this->galleryModel->getAll();
        $galleriesWithItems = [];

        foreach ($galleries as $gallery) {
            $items = $this->galleryItemModel->getByGalleryId((int) $gallery['id']);
            $galleriesWithItems[] = [
                'gallery' => $gallery,
                'items' => $items,
                'itemCount' => count($items),
            ];
        }

        $csrfToken = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrfToken;

        view('admin/gallery/list', [
            'title' => 'Galerii - Admin Scanbox.ro',
            'galleries' => $galleriesWithItems,
            'csrfToken' => $csrfToken,
        ]);
    }

    /**
     * Creare galerie noua (POST)
     */
    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/gallery');
            exit;
        }

        $this->validateCsrf();

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $type = $_POST['type'] ?? 'general';
        $serviceId = !empty($_POST['service_id']) ? (int) $_POST['service_id'] : null;

        if (empty($name)) {
            $_SESSION['flash_error'] = 'Numele galeriei este obligatoriu.';
            header('Location: /admin/gallery');
            exit;
        }

        $data = [
            'name' => $name,
            'slug' => $this->generateSlug($name),
            'description' => $description,
            'type' => $type,
            'service_id' => $serviceId,
            'is_active' => 1,
        ];

        $galleryId = $this->galleryModel->create($data);
        $this->logActivity('gallery_create', "Galerie creată: {$name} (ID: {$galleryId})");

        $_SESSION['flash_success'] = 'Galeria a fost creată cu succes.';
        header('Location: /admin/gallery');
        exit;
    }

    /**
     * Upload imagini in galerie (POST)
     */
    public function upload(int $galleryId): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/gallery');
            exit;
        }

        $this->validateCsrf();

        $gallery = $this->galleryModel->getById($galleryId);
        if ($gallery === null) {
            $_SESSION['flash_error'] = 'Galeria nu a fost găsită.';
            header('Location: /admin/gallery');
            exit;
        }

        if (empty($_FILES['images']['name'][0])) {
            $_SESSION['flash_error'] = 'Nu ați selectat nicio imagine.';
            header('Location: /admin/gallery');
            exit;
        }

        $imageHandler = new ImageHandler();
        $uploadCount = 0;
        $errors = [];

        $fileCount = count($_FILES['images']['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            $file = [
                'name' => $_FILES['images']['name'][$i],
                'type' => $_FILES['images']['type'][$i],
                'tmp_name' => $_FILES['images']['tmp_name'][$i],
                'error' => $_FILES['images']['error'][$i],
                'size' => $_FILES['images']['size'][$i],
            ];

            if ($file['error'] !== UPLOAD_ERR_OK) {
                $errors[] = "Eroare la încărcarea fișierului: {$file['name']}";
                continue;
            }

            $uploadPath = $imageHandler->upload($file, 'gallery/' . $galleryId);
            if ($uploadPath !== null) {
                $currentMaxOrder = $this->galleryItemModel->getMaxSortOrder($galleryId);

                $this->galleryItemModel->create([
                    'gallery_id' => $galleryId,
                    'image_path' => $uploadPath,
                    'thumbnail_path' => $imageHandler->createThumbnail($uploadPath, 300, 300),
                    'alt_text' => pathinfo($file['name'], PATHINFO_FILENAME),
                    'sort_order' => $currentMaxOrder + 1,
                    'is_active' => 1,
                ]);
                $uploadCount++;
            } else {
                $errors[] = "Nu s-a putut încărca: {$file['name']}";
            }
        }

        $this->logActivity('gallery_upload', "Încărcate {$uploadCount} imagini în galeria: {$gallery['name']} (ID: {$galleryId})");

        if ($uploadCount > 0) {
            $_SESSION['flash_success'] = "{$uploadCount} imagine/imagini încărcate cu succes.";
        }
        if (!empty($errors)) {
            $_SESSION['flash_error'] = implode(' ', $errors);
        }

        header('Location: /admin/gallery');
        exit;
    }

    /**
     * Stergere element din galerie (POST)
     */
    public function deleteItem(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/gallery');
            exit;
        }

        $this->validateCsrf();

        $item = $this->galleryItemModel->getById($id);
        if ($item === null) {
            $_SESSION['flash_error'] = 'Imaginea nu a fost găsită.';
            header('Location: /admin/gallery');
            exit;
        }

        // Stergere fisier fizic
        $fullPath = UPLOADS_PATH . $item['image_path'];
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        // Stergere thumbnail daca exista
        if (!empty($item['thumbnail_path'])) {
            $thumbnailPath = UPLOADS_PATH . $item['thumbnail_path'];
            if (file_exists($thumbnailPath)) {
                unlink($thumbnailPath);
            }
        }

        $this->galleryItemModel->delete($id);
        $this->logActivity('gallery_item_delete', "Imagine ștearsă din galerie (ID: {$id})");

        $_SESSION['flash_success'] = 'Imaginea a fost ștearsă.';
        header('Location: /admin/gallery');
        exit;
    }

    /**
     * Reordonare elemente galerie (POST - JSON)
     */
    public function reorder(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'message' => 'Metoda nu este permisă.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $this->validateCsrfJson();

        $input = json_decode(file_get_contents('php://input'), true);
        $items = $input['items'] ?? [];

        if (empty($items) || !is_array($items)) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'success' => false,
                'message' => 'Nu au fost furnizate date de reordonare.',
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        foreach ($items as $sortOrder => $itemId) {
            $this->galleryItemModel->updateSortOrder((int) $itemId, (int) $sortOrder + 1);
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => true,
            'message' => 'Ordinea a fost actualizată cu succes.',
        ], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Validare CSRF din POST
     */
    private function validateCsrf(): void
    {
        $token = $_POST['csrf_token'] ?? '';
        if (empty($token) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            http_response_code(403);
            $_SESSION['flash_error'] = 'Token de securitate invalid.';
            header('Location: /admin/gallery');
            exit;
        }
    }

    /**
     * Validare CSRF din JSON body
     */
    private function validateCsrfJson(): void
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $token = $input['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

        if (empty($token) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            http_response_code(403);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'success' => false,
                'message' => 'Token de securitate invalid.',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    /**
     * Generare slug
     */
    private function generateSlug(string $title): string
    {
        $slug = mb_strtolower($title, 'UTF-8');
        $diacritice = [
            'ă' => 'a', 'â' => 'a', 'î' => 'i', 'ș' => 's', 'ț' => 't',
            'Ă' => 'a', 'Â' => 'a', 'Î' => 'i', 'Ș' => 's', 'Ț' => 't',
        ];
        $slug = strtr($slug, $diacritice);
        $slug = preg_replace('/[^a-z0-9\-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-');
    }

    /**
     * Inregistrare activitate
     */
    private function logActivity(string $action, string $description): void
    {
        try {
            $db = Database::getInstance();
            $db->insert('activity_log', [
                'user_id' => $_SESSION['user_id'],
                'action' => $action,
                'description' => $description,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            error_log('Eroare logare activitate: ' . $e->getMessage());
        }
    }
}
