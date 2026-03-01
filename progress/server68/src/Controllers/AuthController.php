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
            header('Location: /admin/dashboard');
            exit;
        }

        $csrfToken = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrfToken;

        view('admin/login', [
            'title' => 'Autentificare - Admin Scanbox.ro',
            'csrfToken' => $csrfToken,
            'error' => $_SESSION['login_error'] ?? null,
        ]);

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
        session_regenerate_id(true);

        // Setare date sesiune
        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'] ?? 'admin';
        $_SESSION['logged_in_at'] = time();

        // Inregistrare activitate
        $this->logActivity((int) $user['id'], 'login', 'Autentificare reușită');

        header('Location: /admin/dashboard');
        exit;
    }

    /**
     * Deconectare utilizator
     */
    public function logout(): void
    {
        if (isset($_SESSION['user_id'])) {
            $this->logActivity((int) $_SESSION['user_id'], 'logout', 'Deconectare');
        }

        // Distrugere sesiune
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        header('Location: /admin/login');
        exit;
    }

    /**
     * Verificare daca IP-ul este blocat din cauza incercarilor esuate
     */
    private function isRateLimited(string $ipAddress): bool
    {
        $cutoffTime = date('Y-m-d H:i:s', time() - LOGIN_LOCKOUT_TIME);

        $result = $this->db->fetch(
            "SELECT COUNT(*) as attempts FROM login_attempts
             WHERE ip_address = ? AND attempted_at > ? AND success = 0",
            [$ipAddress, $cutoffTime]
        );

        return ($result['attempts'] ?? 0) >= MAX_LOGIN_ATTEMPTS;
    }

    /**
     * Inregistrare incercare esuata de autentificare
     */
    private function recordFailedAttempt(string $ipAddress, string $email): void
    {
        $this->db->insert('login_attempts', [
            'ip_address' => $ipAddress,
            'email' => $email,
            'success' => 0,
            'attempted_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Stergere incercari esuate pentru un IP
     */
    private function clearFailedAttempts(string $ipAddress): void
    {
        $this->db->delete('login_attempts', 'ip_address = ?', [$ipAddress]);
    }

    /**
     * Inregistrare activitate in log
     */
    private function logActivity(int $userId, string $action, string $description): void
    {
        try {
            $this->db->insert('activity_log', [
                'user_id' => $userId,
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
