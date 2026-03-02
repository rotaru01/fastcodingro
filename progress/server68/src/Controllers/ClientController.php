<?php

declare(strict_types=1);

namespace Scanbox\Controllers;

use Scanbox\Core\Auth;
use Scanbox\Core\Database;
use Scanbox\Core\ImageHandler;
use Scanbox\Models\ClientLogo;

class ClientController
{
    private ClientLogo $clientLogoModel;

    public function __construct()
    {
        if (!Auth::check()) {
            header('Location: /admin/login');
            exit;
        }

        $this->clientLogoModel = new ClientLogo();
    }

    /**
     * Lista toate logo-urile clientilor
     */
    public function index(): void
    {
        $clients = $this->clientLogoModel->getAll();

        $csrfToken = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrfToken;

        view('admin/clients/manage', [
            'title' => 'Clienți - Admin Scanbox.ro',
            'clients' => $clients,
            'csrfToken' => $csrfToken,
        ]);
    }

    /**
     * Adaugare client nou (POST cu upload imagine)
     */
    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/clients');
            exit;
        }

        $this->validateCsrf();

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'website_url' => trim($_POST['website_url'] ?? ''),
            'alt_text' => trim($_POST['alt_text'] ?? ''),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
        ];

        // Validare
        if (empty($data['name'])) {
            $_SESSION['flash_error'] = 'Numele clientului este obligatoriu.';
            header('Location: /admin/clients');
            exit;
        }

        // Upload logo (obligatoriu la creare)
        if (empty($_FILES['logo']['name'])) {
            $_SESSION['flash_error'] = 'Logo-ul clientului este obligatoriu.';
            header('Location: /admin/clients');
            exit;
        }

        $imageHandler = new ImageHandler();
        $uploadResult = $imageHandler->upload($_FILES['logo'], 'clients');

        if ($uploadResult === null) {
            $_SESSION['flash_error'] = 'Eroare la încărcarea logo-ului. Verificați formatul și dimensiunea fișierului.';
            header('Location: /admin/clients');
            exit;
        }

        $data['logo_path'] = $uploadResult;

        if (empty($data['alt_text'])) {
            $data['alt_text'] = 'Logo ' . $data['name'];
        }

        $clientId = $this->clientLogoModel->create($data);
        $this->logActivity('client_create', "Client adăugat: {$data['name']} (ID: {$clientId})");

        $_SESSION['flash_success'] = 'Clientul a fost adăugat cu succes.';
        header('Location: /admin/clients');
        exit;
    }

    /**
     * Actualizare client (POST)
     */
    public function update(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/clients');
            exit;
        }

        $this->validateCsrf();

        $existing = $this->clientLogoModel->getById($id);
        if ($existing === null) {
            $_SESSION['flash_error'] = 'Clientul nu a fost găsit.';
            header('Location: /admin/clients');
            exit;
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'website_url' => trim($_POST['website_url'] ?? ''),
            'alt_text' => trim($_POST['alt_text'] ?? ''),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'sort_order' => (int) ($_POST['sort_order'] ?? $existing['sort_order'] ?? 0),
        ];

        if (empty($data['name'])) {
            $_SESSION['flash_error'] = 'Numele clientului este obligatoriu.';
            header('Location: /admin/clients');
            exit;
        }

        // Upload logo nou (optional la actualizare)
        if (!empty($_FILES['logo']['name'])) {
            $imageHandler = new ImageHandler();
            $uploadResult = $imageHandler->upload($_FILES['logo'], 'clients');
            if ($uploadResult !== null) {
                // Stergere logo vechi
                if (!empty($existing['logo_path'])) {
                    $oldLogoPath = UPLOADS_PATH . $existing['logo_path'];
                    if (file_exists($oldLogoPath)) {
                        unlink($oldLogoPath);
                    }
                }
                $data['logo_path'] = $uploadResult;
            }
        }

        if (empty($data['alt_text'])) {
            $data['alt_text'] = 'Logo ' . $data['name'];
        }

        $this->clientLogoModel->update($id, $data);
        $this->logActivity('client_update', "Client actualizat: {$data['name']} (ID: {$id})");

        $_SESSION['flash_success'] = 'Datele clientului au fost actualizate.';
        header('Location: /admin/clients');
        exit;
    }

    /**
     * Stergere client (POST)
     */
    public function delete(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/clients');
            exit;
        }

        $this->validateCsrf();

        $client = $this->clientLogoModel->getById($id);
        if ($client === null) {
            $_SESSION['flash_error'] = 'Clientul nu a fost găsit.';
            header('Location: /admin/clients');
            exit;
        }

        // Stergere logo fizic
        if (!empty($client['logo_path'])) {
            $logoPath = UPLOADS_PATH . $client['logo_path'];
            if (file_exists($logoPath)) {
                unlink($logoPath);
            }
        }

        $this->clientLogoModel->delete($id);
        $this->logActivity('client_delete', "Client șters: {$client['name']} (ID: {$id})");

        $_SESSION['flash_success'] = 'Clientul a fost șters.';
        header('Location: /admin/clients');
        exit;
    }

    /**
     * Comutare stare activ/inactiv (POST)
     */
    public function toggle(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/clients');
            exit;
        }

        $this->validateCsrf();

        $client = $this->clientLogoModel->getById($id);
        if ($client === null) {
            $_SESSION['flash_error'] = 'Clientul nu a fost găsit.';
            header('Location: /admin/clients');
            exit;
        }

        $newStatus = $client['is_active'] ? 0 : 1;
        $this->clientLogoModel->update($id, ['is_active' => $newStatus]);

        $statusText = $newStatus ? 'activat' : 'dezactivat';
        $this->logActivity('client_toggle', "Client {$statusText}: {$client['name']} (ID: {$id})");

        $_SESSION['flash_success'] = "Clientul a fost {$statusText}.";
        header('Location: /admin/clients');
        exit;
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
            header('Location: /admin/clients');
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
