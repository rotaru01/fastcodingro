<?php

declare(strict_types=1);

namespace Scanbox\Controllers;

use Scanbox\Core\Auth;
use Scanbox\Core\Database;
use Scanbox\Core\ImageHandler;
use Scanbox\Models\Testimonial;

class TestimonialController
{
    private Testimonial $testimonialModel;

    public function __construct()
    {
        if (!Auth::check()) {
            header('Location: /admin/login');
            exit;
        }

        $this->testimonialModel = new Testimonial();
    }

    /**
     * Lista toate testimonialele
     */
    public function index(): void
    {
        $testimonials = $this->testimonialModel->getAll();

        $csrfToken = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrfToken;

        view('admin/testimonials/manage', [
            'title' => 'Testimoniale - Admin Scanbox.ro',
            'testimonials' => $testimonials,
            'csrfToken' => $csrfToken,
        ]);
    }

    /**
     * Adaugare testimonial nou (POST)
     */
    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/testimonials');
            exit;
        }

        $this->validateCsrf();

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'position' => trim($_POST['position'] ?? ''),
            'company' => trim($_POST['company'] ?? ''),
            'content' => trim($_POST['content'] ?? ''),
            'rating' => max(1, min(5, (int) ($_POST['rating'] ?? 5))),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
        ];

        // Validare
        if (empty($data['name'])) {
            $_SESSION['flash_error'] = 'Numele este obligatoriu.';
            header('Location: /admin/testimonials');
            exit;
        }

        if (empty($data['content'])) {
            $_SESSION['flash_error'] = 'Conținutul testimonialului este obligatoriu.';
            header('Location: /admin/testimonials');
            exit;
        }

        // Upload avatar
        if (!empty($_FILES['avatar']['name'])) {
            $imageHandler = new ImageHandler();
            $uploadResult = $imageHandler->upload($_FILES['avatar'], 'testimonials');
            if ($uploadResult !== null) {
                $data['avatar'] = $uploadResult;
            }
        }

        $testimonialId = $this->testimonialModel->create($data);
        $this->logActivity('testimonial_create', "Testimonial creat: {$data['name']} (ID: {$testimonialId})");

        $_SESSION['flash_success'] = 'Testimonialul a fost adăugat cu succes.';
        header('Location: /admin/testimonials');
        exit;
    }

    /**
     * Actualizare testimonial (POST)
     */
    public function update(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/testimonials');
            exit;
        }

        $this->validateCsrf();

        $existing = $this->testimonialModel->getById($id);
        if ($existing === null) {
            $_SESSION['flash_error'] = 'Testimonialul nu a fost găsit.';
            header('Location: /admin/testimonials');
            exit;
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'position' => trim($_POST['position'] ?? ''),
            'company' => trim($_POST['company'] ?? ''),
            'content' => trim($_POST['content'] ?? ''),
            'rating' => max(1, min(5, (int) ($_POST['rating'] ?? 5))),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'sort_order' => (int) ($_POST['sort_order'] ?? $existing['sort_order'] ?? 0),
        ];

        if (empty($data['name']) || empty($data['content'])) {
            $_SESSION['flash_error'] = 'Numele și conținutul sunt obligatorii.';
            header('Location: /admin/testimonials');
            exit;
        }

        // Upload avatar nou
        if (!empty($_FILES['avatar']['name'])) {
            $imageHandler = new ImageHandler();
            $uploadResult = $imageHandler->upload($_FILES['avatar'], 'testimonials');
            if ($uploadResult !== null) {
                $data['avatar'] = $uploadResult;
            }
        }

        $this->testimonialModel->update($id, $data);
        $this->logActivity('testimonial_update', "Testimonial actualizat: {$data['name']} (ID: {$id})");

        $_SESSION['flash_success'] = 'Testimonialul a fost actualizat.';
        header('Location: /admin/testimonials');
        exit;
    }

    /**
     * Stergere testimonial (POST)
     */
    public function delete(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/testimonials');
            exit;
        }

        $this->validateCsrf();

        $testimonial = $this->testimonialModel->getById($id);
        if ($testimonial === null) {
            $_SESSION['flash_error'] = 'Testimonialul nu a fost găsit.';
            header('Location: /admin/testimonials');
            exit;
        }

        // Stergere avatar daca exista
        if (!empty($testimonial['avatar'])) {
            $avatarPath = UPLOADS_PATH . $testimonial['avatar'];
            if (file_exists($avatarPath)) {
                unlink($avatarPath);
            }
        }

        $this->testimonialModel->delete($id);
        $this->logActivity('testimonial_delete', "Testimonial șters: {$testimonial['name']} (ID: {$id})");

        $_SESSION['flash_success'] = 'Testimonialul a fost șters.';
        header('Location: /admin/testimonials');
        exit;
    }

    /**
     * Comutare stare activ/inactiv (POST)
     */
    public function toggle(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/testimonials');
            exit;
        }

        $this->validateCsrf();

        $testimonial = $this->testimonialModel->getById($id);
        if ($testimonial === null) {
            $_SESSION['flash_error'] = 'Testimonialul nu a fost găsit.';
            header('Location: /admin/testimonials');
            exit;
        }

        $newStatus = $testimonial['is_active'] ? 0 : 1;
        $this->testimonialModel->update($id, ['is_active' => $newStatus]);

        $statusText = $newStatus ? 'activat' : 'dezactivat';
        $this->logActivity('testimonial_toggle', "Testimonial {$statusText}: {$testimonial['name']} (ID: {$id})");

        $_SESSION['flash_success'] = "Testimonialul a fost {$statusText}.";
        header('Location: /admin/testimonials');
        exit;
    }

    /**
     * Reordonare testimoniale (POST)
     */
    public function reorder(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'message' => 'Metoda nu este permisă.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        // Validare CSRF din header sau JSON body
        $input = json_decode(file_get_contents('php://input'), true);
        $token = $input['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

        if (empty($token) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            http_response_code(403);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'message' => 'Token de securitate invalid.'], JSON_UNESCAPED_UNICODE);
            return;
        }

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
            $this->testimonialModel->update((int) $itemId, [
                'sort_order' => (int) $sortOrder + 1,
            ]);
        }

        $this->logActivity('testimonial_reorder', 'Testimoniale reordonate');

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => true,
            'message' => 'Ordinea a fost actualizată cu succes.',
        ], JSON_UNESCAPED_UNICODE);
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
            header('Location: /admin/testimonials');
            exit;
        }
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
