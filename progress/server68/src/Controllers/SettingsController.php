<?php

declare(strict_types=1);

namespace Scanbox\Controllers;

use Scanbox\Core\Auth;
use Scanbox\Core\Database;
use Scanbox\Models\Setting;

class SettingsController
{
    private Setting $settingModel;

    public function __construct()
    {
        if (!Auth::check()) {
            header('Location: /admin/login');
            exit;
        }

        $this->settingModel = new Setting();
    }

    /**
     * Afisare toate setarile grupate
     */
    public function index(): void
    {
        $settings = $this->settingModel->getAllGrouped();

        $csrfToken = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrfToken;

        view('admin/settings/index', [
            'title' => 'Setări Site - Admin Scanbox.ro',
            'settings' => $settings,
            'csrfToken' => $csrfToken,
            'userRole' => $_SESSION['user_role'] ?? 'admin',
        ]);
    }

    /**
     * Actualizare setari (POST)
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/settings');
            exit;
        }

        $this->validateCsrf();

        $settings = $_POST['settings'] ?? [];
        $userRole = $_SESSION['user_role'] ?? 'admin';

        if (empty($settings) || !is_array($settings)) {
            $_SESSION['flash_error'] = 'Nu au fost furnizate setări de actualizat.';
            header('Location: /admin/settings');
            exit;
        }

        // Setari care necesita rol super_admin
        $protectedSettings = [
            'site_url',
            'admin_email',
            'smtp_host',
            'smtp_port',
            'smtp_username',
            'smtp_password',
            'google_analytics_id',
            'maintenance_mode',
            'allowed_file_types',
            'max_upload_size',
        ];

        $updatedCount = 0;
        $skippedCount = 0;

        foreach ($settings as $key => $value) {
            // Sanitizare cheie
            $key = preg_replace('/[^a-zA-Z0-9_]/', '', $key);
            if (empty($key)) {
                continue;
            }

            // Verificare permisiuni pentru setari protejate
            if (in_array($key, $protectedSettings, true) && $userRole !== 'super_admin') {
                $skippedCount++;
                continue;
            }

            // Sanitizare valoare
            $value = trim($value);

            // Validari specifice pe tip de setare
            if ($key === 'admin_email' && !empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['flash_error'] = 'Adresa de email administrator nu este validă.';
                header('Location: /admin/settings');
                exit;
            }

            if ($key === 'site_url' && !empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
                $_SESSION['flash_error'] = 'URL-ul site-ului nu este valid.';
                header('Location: /admin/settings');
                exit;
            }

            $this->settingModel->set($key, $value);
            $updatedCount++;
        }

        $this->logActivity('settings_update', "Actualizate {$updatedCount} setări");

        $message = "{$updatedCount} setare/setări au fost actualizate cu succes.";
        if ($skippedCount > 0) {
            $message .= " {$skippedCount} setare/setări protejate au fost ignorate (necesită rol super admin).";
        }

        $_SESSION['flash_success'] = $message;
        header('Location: /admin/settings');
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
            header('Location: /admin/settings');
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
