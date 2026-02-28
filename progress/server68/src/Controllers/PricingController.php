<?php

declare(strict_types=1);

namespace Scanbox\Controllers;

use Scanbox\Core\Auth;
use Scanbox\Core\Database;
use Scanbox\Models\PricingPackage;
use Scanbox\Models\Service;

class PricingController
{
    private PricingPackage $pricingModel;
    private Service $serviceModel;

    public function __construct()
    {
        if (!Auth::check()) {
            header('Location: /admin/login');
            exit;
        }

        $this->pricingModel = new PricingPackage();
        $this->serviceModel = new Service();
    }

    /**
     * Lista toate pachetele de preturi grupate pe serviciu
     */
    public function index(): void
    {
        $packages = $this->pricingModel->getAllGrouped();
        $services = $this->serviceModel->getAll();

        $csrfToken = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrfToken;

        view('admin/pricing/index', [
            'title' => 'Pachete de Prețuri - Admin Scanbox.ro',
            'packages' => $packages,
            'services' => $services,
            'csrfToken' => $csrfToken,
        ]);
    }

    /**
     * Creare pachet nou de preturi (POST)
     */
    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/pricing');
            exit;
        }

        $this->validateCsrf();

        $data = [
            'service_id' => !empty($_POST['service_id']) ? (int) $_POST['service_id'] : null,
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'price' => !empty($_POST['price']) ? (float) $_POST['price'] : 0.00,
            'price_type' => $_POST['price_type'] ?? 'fixed',
            'currency' => $_POST['currency'] ?? 'RON',
            'features' => trim($_POST['features'] ?? ''),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
        ];

        // Validare
        if (empty($data['name'])) {
            $_SESSION['flash_error'] = 'Numele pachetului este obligatoriu.';
            header('Location: /admin/pricing');
            exit;
        }

        if ($data['service_id'] === null) {
            $_SESSION['flash_error'] = 'Serviciul este obligatoriu.';
            header('Location: /admin/pricing');
            exit;
        }

        // Verificare ca serviciul exista
        $service = $this->serviceModel->getById($data['service_id']);
        if ($service === null) {
            $_SESSION['flash_error'] = 'Serviciul selectat nu există.';
            header('Location: /admin/pricing');
            exit;
        }

        $packageId = $this->pricingModel->create($data);
        $this->logActivity('pricing_create', "Pachet de preț creat: {$data['name']} (ID: {$packageId})");

        $_SESSION['flash_success'] = 'Pachetul de preț a fost creat cu succes.';
        header('Location: /admin/pricing');
        exit;
    }

    /**
     * Actualizare pachet de preturi (POST)
     */
    public function update(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/pricing');
            exit;
        }

        $this->validateCsrf();

        $existing = $this->pricingModel->getById($id);
        if ($existing === null) {
            $_SESSION['flash_error'] = 'Pachetul nu a fost găsit.';
            header('Location: /admin/pricing');
            exit;
        }

        $data = [
            'service_id' => !empty($_POST['service_id']) ? (int) $_POST['service_id'] : $existing['service_id'],
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'price' => !empty($_POST['price']) ? (float) $_POST['price'] : 0.00,
            'price_type' => $_POST['price_type'] ?? $existing['price_type'],
            'currency' => $_POST['currency'] ?? $existing['currency'] ?? 'RON',
            'features' => trim($_POST['features'] ?? ''),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'sort_order' => (int) ($_POST['sort_order'] ?? $existing['sort_order'] ?? 0),
        ];

        if (empty($data['name'])) {
            $_SESSION['flash_error'] = 'Numele pachetului este obligatoriu.';
            header('Location: /admin/pricing');
            exit;
        }

        $this->pricingModel->update($id, $data);
        $this->logActivity('pricing_update', "Pachet de preț actualizat: {$data['name']} (ID: {$id})");

        $_SESSION['flash_success'] = 'Pachetul a fost actualizat cu succes.';
        header('Location: /admin/pricing');
        exit;
    }

    /**
     * Stergere pachet de preturi (POST)
     */
    public function delete(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/pricing');
            exit;
        }

        $this->validateCsrf();

        $package = $this->pricingModel->getById($id);
        if ($package === null) {
            $_SESSION['flash_error'] = 'Pachetul nu a fost găsit.';
            header('Location: /admin/pricing');
            exit;
        }

        $this->pricingModel->delete($id);
        $this->logActivity('pricing_delete', "Pachet de preț șters: {$package['name']} (ID: {$id})");

        $_SESSION['flash_success'] = 'Pachetul a fost șters.';
        header('Location: /admin/pricing');
        exit;
    }

    /**
     * Comutare stare activ/inactiv (POST)
     */
    public function toggle(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/pricing');
            exit;
        }

        $this->validateCsrf();

        $package = $this->pricingModel->getById($id);
        if ($package === null) {
            $_SESSION['flash_error'] = 'Pachetul nu a fost găsit.';
            header('Location: /admin/pricing');
            exit;
        }

        $newStatus = $package['is_active'] ? 0 : 1;
        $this->pricingModel->update($id, ['is_active' => $newStatus]);

        $statusText = $newStatus ? 'activat' : 'dezactivat';
        $this->logActivity('pricing_toggle', "Pachet {$statusText}: {$package['name']} (ID: {$id})");

        $_SESSION['flash_success'] = "Pachetul a fost {$statusText}.";
        header('Location: /admin/pricing');
        exit;
    }

    /**
     * Comutare stare recomandat/nerecomandat (POST)
     */
    public function toggleFeatured(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/pricing');
            exit;
        }

        $this->validateCsrf();

        $package = $this->pricingModel->getById($id);
        if ($package === null) {
            $_SESSION['flash_error'] = 'Pachetul nu a fost găsit.';
            header('Location: /admin/pricing');
            exit;
        }

        $newFeatured = $package['is_featured'] ? 0 : 1;
        $this->pricingModel->update($id, ['is_featured' => $newFeatured]);

        $featuredText = $newFeatured ? 'marcat ca recomandat' : 'scos din recomandate';
        $this->logActivity('pricing_toggle_featured', "Pachet {$featuredText}: {$package['name']} (ID: {$id})");

        $_SESSION['flash_success'] = "Pachetul a fost {$featuredText}.";
        header('Location: /admin/pricing');
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
            header('Location: /admin/pricing');
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
