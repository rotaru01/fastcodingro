<?php

declare(strict_types=1);

namespace Scanbox\Controllers;

use Scanbox\Core\Auth;
use Scanbox\Core\Database;
use Scanbox\Core\ImageHandler;
use Scanbox\Models\Project;
use Scanbox\Models\Category;

class ProjectController
{
    private Project $projectModel;
    private Category $categoryModel;

    public function __construct()
    {
        if (!Auth::check()) {
            header('Location: /admin/login');
            exit;
        }

        $this->projectModel = new Project();
        $this->categoryModel = new Category();
    }

    /**
     * Lista toate proiectele cu filtrare pe categorie
     */
    public function index(): void
    {
        $categoryFilter = $_GET['category'] ?? null;

        if ($categoryFilter !== null && $categoryFilter !== '') {
            $projects = $this->projectModel->getByCategoryId((int) $categoryFilter);
        } else {
            $projects = $this->projectModel->getAll();
            $categoryFilter = null;
        }

        $categories = $this->categoryModel->getAll();

        view('admin/portfolio/list', [
            'title' => 'Proiecte Portofoliu - Admin Scanbox.ro',
            'projects' => $projects,
            'categories' => $categories,
            'currentCategory' => $categoryFilter,
        ]);
    }

    /**
     * Creare proiect nou (GET - formular / POST - salvare)
     */
    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();

            $data = $this->extractProjectData();

            if (empty($data['title'])) {
                $_SESSION['flash_error'] = 'Titlul proiectului este obligatoriu.';
                header('Location: /admin/portfolio/new');
                exit;
            }

            $data['slug'] = $this->generateSlug($data['title']);

            // Upload thumbnail
            if (!empty($_FILES['thumbnail']['name'])) {
                $imageHandler = new ImageHandler();
                $uploadResult = $imageHandler->upload($_FILES['thumbnail'], 'portfolio');
                if ($uploadResult !== null) {
                    $data['thumbnail'] = $uploadResult;
                }
            }

            // Upload imagini galerie proiect
            $projectId = $this->projectModel->create($data);
            $this->handleProjectGalleryUpload($projectId);

            $this->logActivity('project_create', "Proiect creat: {$data['title']} (ID: {$projectId})");

            $_SESSION['flash_success'] = 'Proiectul a fost creat cu succes.';
            header('Location: /admin/portfolio');
            exit;
        }

        $categories = $this->categoryModel->getAll();
        $csrfToken = $this->generateCsrf();

        view('admin/portfolio/edit', [
            'title' => 'Proiect Nou - Admin Scanbox.ro',
            'project' => null,
            'categories' => $categories,
            'csrfToken' => $csrfToken,
            'formAction' => '/admin/portfolio/new',
        ]);
    }

    /**
     * Editare proiect (GET - formular / POST - actualizare)
     */
    public function edit(int $id): void
    {
        $project = $this->projectModel->getById($id);
        if ($project === null) {
            $_SESSION['flash_error'] = 'Proiectul nu a fost găsit.';
            header('Location: /admin/portfolio');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();

            $data = $this->extractProjectData();

            if (empty($data['title'])) {
                $_SESSION['flash_error'] = 'Titlul proiectului este obligatoriu.';
                header("Location: /admin/portfolio/edit/{$id}");
                exit;
            }

            // Pastrare slug existent sau generare nou
            $data['slug'] = !empty($_POST['slug'])
                ? $this->generateSlug($_POST['slug'])
                : $this->generateSlug($data['title']);

            // Upload thumbnail daca exista fisier nou
            if (!empty($_FILES['thumbnail']['name'])) {
                $imageHandler = new ImageHandler();
                $uploadResult = $imageHandler->upload($_FILES['thumbnail'], 'portfolio');
                if ($uploadResult !== null) {
                    $data['thumbnail'] = $uploadResult;
                }
            }

            $this->projectModel->update($id, $data);
            $this->handleProjectGalleryUpload($id);

            $this->logActivity('project_update', "Proiect actualizat: {$data['title']} (ID: {$id})");

            $_SESSION['flash_success'] = 'Proiectul a fost actualizat cu succes.';
            header('Location: /admin/portfolio');
            exit;
        }

        $categories = $this->categoryModel->getAll();
        $csrfToken = $this->generateCsrf();

        view('admin/portfolio/edit', [
            'title' => 'Editare Proiect - Admin Scanbox.ro',
            'project' => $project,
            'categories' => $categories,
            'csrfToken' => $csrfToken,
            'formAction' => "/admin/portfolio/edit/{$id}",
        ]);
    }

    /**
     * Stergere proiect (POST)
     */
    public function delete(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/portfolio');
            exit;
        }

        $this->validateCsrf();

        $project = $this->projectModel->getById($id);
        if ($project === null) {
            $_SESSION['flash_error'] = 'Proiectul nu a fost găsit.';
            header('Location: /admin/portfolio');
            exit;
        }

        // Stergere thumbnail daca exista
        if (!empty($project['thumbnail'])) {
            $thumbnailPath = UPLOADS_PATH . $project['thumbnail'];
            if (file_exists($thumbnailPath)) {
                unlink($thumbnailPath);
            }
        }

        $this->projectModel->delete($id);
        $this->logActivity('project_delete', "Proiect șters: {$project['title']} (ID: {$id})");

        $_SESSION['flash_success'] = 'Proiectul a fost șters definitiv.';
        header('Location: /admin/portfolio');
        exit;
    }

    /**
     * Extragere date proiect din POST
     */
    private function extractProjectData(): array
    {
        return [
            'title' => trim($_POST['title'] ?? ''),
            'description' => $_POST['description'] ?? '',
            'short_description' => trim($_POST['short_description'] ?? ''),
            'category_id' => !empty($_POST['category_id']) ? (int) $_POST['category_id'] : null,
            'client_name' => trim($_POST['client_name'] ?? ''),
            'project_date' => !empty($_POST['project_date']) ? $_POST['project_date'] : null,
            'project_url' => trim($_POST['project_url'] ?? ''),
            'video_url' => trim($_POST['video_url'] ?? ''),
            'latitude' => !empty($_POST['latitude']) ? (float) $_POST['latitude'] : null,
            'longitude' => !empty($_POST['longitude']) ? (float) $_POST['longitude'] : null,
            'location_name' => trim($_POST['location_name'] ?? ''),
            'type' => $_POST['type'] ?? 'standard',
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
    }

    /**
     * Upload imagini galerie pentru proiect
     */
    private function handleProjectGalleryUpload(int $projectId): void
    {
        if (empty($_FILES['gallery_images']['name'][0])) {
            return;
        }

        $imageHandler = new ImageHandler();
        $db = Database::getInstance();

        $fileCount = count($_FILES['gallery_images']['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            $file = [
                'name' => $_FILES['gallery_images']['name'][$i],
                'type' => $_FILES['gallery_images']['type'][$i],
                'tmp_name' => $_FILES['gallery_images']['tmp_name'][$i],
                'error' => $_FILES['gallery_images']['error'][$i],
                'size' => $_FILES['gallery_images']['size'][$i],
            ];

            if ($file['error'] !== UPLOAD_ERR_OK) {
                continue;
            }

            $uploadPath = $imageHandler->upload($file, 'portfolio/' . $projectId);
            if ($uploadPath !== null) {
                $db->insert('project_images', [
                    'project_id' => $projectId,
                    'image_path' => $uploadPath,
                    'alt_text' => pathinfo($file['name'], PATHINFO_FILENAME),
                    'sort_order' => $i + 1,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    /**
     * Validare token CSRF
     */
    private function validateCsrf(): void
    {
        $token = $_POST['csrf_token'] ?? '';
        if (empty($token) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            http_response_code(403);
            $_SESSION['flash_error'] = 'Token de securitate invalid.';
            header('Location: /admin/portfolio');
            exit;
        }
    }

    /**
     * Generare token CSRF
     */
    private function generateCsrf(): string
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

    /**
     * Generare slug din text
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
