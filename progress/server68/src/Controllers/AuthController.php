<?php

declare(strict_types=1);

namespace Scanbox\Controllers;

use Scanbox\Core\Auth;
use Scanbox\Core\Database;

class AuthController
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Afisare formular de autentificare (GET)
     */
    public function loginForm(): void
    {
        // Daca este deja autentificat, redirectioneaza la dashboard
        if (Auth::check()) {
            header('Location: /admin');
            exit;
        }

        $csrfToken = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrfToken;

        view('admin/login', [
            'title' => 'Autentificare - Admin Scanbox.ro',
            'csrfToken' => $csrfToken,
            'error' => $_SESSION['login_error'] ?? null,
        ], null);

        // Stergere mesaj de eroare dupa afisare
        unset($_SESSION['login_error']);
    }

    /**
     * Procesare autentificare (POST)
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/login');
            exit;
        }

        // Validare token CSRF
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (empty($csrfToken) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrfToken)) {
            $_SESSION['login_error'] = 'Token de securitate invalid. Vă rugăm să încercați din nou.';
            header('Location: /admin/login');
            exit;
        }

        unset($_SESSION['csrf_token']);

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validare campuri
        if (empty($email) || empty($password)) {
            $_SESSION['login_error'] = 'Completați toate câmpurile.';
            header('Location: /admin/login');
            exit;
        }

        // Verificare limitare incercari de autentificare
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        if ($this->isRateLimited($ipAddress)) {
            $_SESSION['login_error'] = 'Prea multe încercări de autentificare. Vă rugăm să așteptați ' . (int)(LOGIN_LOCKOUT_TIME / 60) . ' minute.';
            header('Location: /admin/login');
            exit;
        }

        // Cautare utilizator in tabelul admins
        $user = $this->db->fetch(
            "SELECT * FROM admins WHERE email = ? AND is_active = 1 LIMIT 1",
            [$email]
        );

        if ($user === null || !password_verify($password, $user['password_hash'])) {
            // Inregistrare incercare esuata
            $this->recordFailedAttempt($ipAddress, $email);

            $_SESSION['login_error'] = 'Email sau parolă incorectă.';
            header('Location: /admin/login');
            exit;
        }

        // Resetare incercari esuate la autentificare reusita
        $this->clearFailedAttempts($ipAddress);

        // Actualizare ultima autentificare
        $this->db->update('admins', [
            'last_login' => date('Y-m-d H:i:s'),
        ], 'id = ?', [(int) $user['id']]);

        // Regenerare ID sesiune pentru prevenirea fixarii sesiunii
        \Scanbox\Core\Session::regenerate();

        // Setare date sesiune (cheile admin_* sunt necesare pentru Auth::check())
        \Scanbox\Core\Session::set('admin_id', (int) $user['id']);
        \Scanbox\Core\Session::set('admin_username', $user['username'] ?? '');
        \Scanbox\Core\Session::set('admin_name', $user['name']);
        \Scanbox\Core\Session::set('admin_email', $user['email']);
        \Scanbox\Core\Session::set('admin_role', $user['role'] ?? 'admin');
        \Scanbox\Core\Session::set('admin_logged_in', true);
        \Scanbox\Core\Session::set('login_time', time());

        // Compatibilitate cu controllere care folosesc user_id/user_name
        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'] ?? 'admin';

        // Inregistrare activitate
        $this->logActivity((int) $user['id'], 'login', 'Autentificare reușită');

        header('Location: /admin');
        exit;
    }

    /**
     * Deconectare utilizator
     */
    public function logout(): void
    {
        $adminId = \Scanbox\Core\Session::get('admin_id');
        if ($adminId !== null) {
            $this->logActivity((int) $adminId, 'logout', 'Deconectare');
        }

        \Scanbox\Core\Session::destroy();

        header('Location: /admin/login');
        exit;
    }

    /**
     * Verificare daca IP-ul este blocat din cauza incercarilor esuate
     */
    private function isRateLimited(string $ipAddress): bool
    {
        try {
            $cutoffTime = date('Y-m-d H:i:s', time() - LOGIN_LOCKOUT_TIME);

            $result = $this->db->fetch(
                "SELECT COUNT(*) as attempts FROM login_attempts
                 WHERE ip_address = ? AND attempted_at > ? AND success = 0",
                [$ipAddress, $cutoffTime]
            );

            return ($result['attempts'] ?? 0) >= MAX_LOGIN_ATTEMPTS;
        } catch (\Exception $e) {
            // Tabela login_attempts nu exista inca - skip rate limiting
            error_log('Rate limiting skip: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Inregistrare incercare esuata de autentificare
     */
    private function recordFailedAttempt(string $ipAddress, string $email): void
    {
        try {
            $this->db->insert('login_attempts', [
                'ip_address' => $ipAddress,
                'email' => $email,
                'success' => 0,
                'attempted_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            error_log('Record failed attempt skip: ' . $e->getMessage());
        }
    }

    /**
     * Stergere incercari esuate pentru un IP
     */
    private function clearFailedAttempts(string $ipAddress): void
    {
        try {
            $this->db->delete('login_attempts', 'ip_address = ?', [$ipAddress]);
        } catch (\Exception $e) {
            error_log('Clear failed attempts skip: ' . $e->getMessage());
        }
    }

    /**
     * Inregistrare activitate in log
     */
    private function logActivity(int $userId, string $action, string $description): void
    {
        try {
            $this->db->insert('activity_log', [
                'admin_id' => $userId,
                'action' => $action,
                'entity_type' => 'auth',
                'details' => $description,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            error_log('Eroare logare activitate: ' . $e->getMessage());
        }
    }
}
