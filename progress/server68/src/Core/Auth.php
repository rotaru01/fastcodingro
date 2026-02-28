<?php
/**
 * Scanbox.ro - Sistem de autentificare
 *
 * Gestioneaza autentificarea administratorilor cu verificare parola Argon2id,
 * rate limiting pentru prevenirea atacurilor brute force si verificarea rolurilor.
 *
 * @package Scanbox\Core
 * @version 1.0.0
 */

declare(strict_types=1);

namespace Scanbox\Core;

class Auth
{
    /** @var Database Instanta bazei de date */
    private Database $db;

    /**
     * Constructor - initializeaza conexiunea la baza de date
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Autentifica un administrator
     *
     * Verifica credentialele, aplica rate limiting si logheaza activitatea.
     * Foloseste password_verify cu hash Argon2id. La autentificare reusita,
     * regenereaza ID-ul sesiunii si stocheaza datele utilizatorului.
     *
     * @param string $username Numele de utilizator
     * @param string $password Parola in text clar
     * @return array Rezultatul autentificarii ['success' => bool, 'message' => string]
     */
    public function login(string $username, string $password): array
    {
        /** Verificam rate limiting */
        if ($this->isLockedOut()) {
            $remainingTime = $this->getLockoutRemainingTime();
            $minutes = (int) ceil($remainingTime / 60);
            return [
                'success' => false,
                'message' => sprintf(
                    'Prea multe incercari de autentificare. Reincercati in %d %s.',
                    $minutes,
                    $minutes === 1 ? 'minut' : 'minute'
                ),
            ];
        }

        /** Sanitizam username-ul */
        $username = trim($username);
        if (empty($username) || empty($password)) {
            return [
                'success' => false,
                'message' => 'Numele de utilizator si parola sunt obligatorii.',
            ];
        }

        /** Cautam utilizatorul in baza de date */
        $admin = $this->db->fetch(
            'SELECT id, username, email, password_hash, name, role, is_active FROM admins WHERE username = :username LIMIT 1',
            [':username' => $username]
        );

        /** Utilizator inexistent */
        if ($admin === null) {
            $this->recordFailedAttempt();
            return [
                'success' => false,
                'message' => 'Nume de utilizator sau parola incorecta.',
            ];
        }

        /** Verificam daca contul este activ */
        if (!(bool) $admin['is_active']) {
            return [
                'success' => false,
                'message' => 'Contul este dezactivat. Contactati administratorul.',
            ];
        }

        /** Verificam parola cu password_verify (suporta Argon2id) */
        if (!password_verify($password, $admin['password_hash'])) {
            $this->recordFailedAttempt();
            return [
                'success' => false,
                'message' => 'Nume de utilizator sau parola incorecta.',
            ];
        }

        /** Autentificare reusita - resetam incercarile esuate */
        $this->clearFailedAttempts();

        /** Regeneram ID-ul sesiunii pentru securitate */
        Session::regenerate();

        /** Stocam datele utilizatorului in sesiune */
        Session::set('admin_id', (int) $admin['id']);
        Session::set('admin_username', $admin['username']);
        Session::set('admin_name', $admin['name']);
        Session::set('admin_email', $admin['email']);
        Session::set('admin_role', $admin['role']);
        Session::set('admin_logged_in', true);
        Session::set('login_time', time());

        /** Actualizam ultima autentificare in baza de date */
        $this->db->update(
            'admins',
            ['last_login' => date('Y-m-d H:i:s')],
            'id = :id',
            [':id' => $admin['id']]
        );

        /** Logam activitatea */
        $this->logActivity((int) $admin['id'], 'login', 'admin', (int) $admin['id'], 'Autentificare reusita');

        return [
            'success' => true,
            'message' => 'Autentificare reusita. Bine ati venit, ' . Security::escapeOutput($admin['name']) . '!',
        ];
    }

    /**
     * Delogheaza utilizatorul curent
     *
     * Logheaza activitatea de delogare si distruge sesiunea.
     *
     * @return void
     */
    public function logout(): void
    {
        $adminId = Session::get('admin_id');

        if ($adminId !== null) {
            $this->logActivity((int) $adminId, 'logout', 'admin', (int) $adminId, 'Delogare');
        }

        Session::destroy();
    }

    /**
     * Verifica daca utilizatorul este autentificat
     *
     * Verifica atat flag-ul de autentificare cat si existenta ID-ului admin.
     *
     * @return bool True daca utilizatorul este autentificat
     */
    public static function check(): bool
    {
        return Session::has('admin_logged_in')
            && Session::get('admin_logged_in') === true
            && Session::has('admin_id');
    }

    /**
     * Verifica daca utilizatorul are rol de administrator
     *
     * Accepta rolurile super_admin si admin.
     *
     * @return bool True daca utilizatorul este administrator
     */
    public static function isAdmin(): bool
    {
        if (!self::check()) {
            return false;
        }

        $role = Session::get('admin_role', '');
        return in_array($role, [ROLE_SUPER_ADMIN, ROLE_ADMIN], true);
    }

    /**
     * Verifica daca utilizatorul are rol de super administrator
     *
     * @return bool True daca utilizatorul este super administrator
     */
    public static function isSuperAdmin(): bool
    {
        if (!self::check()) {
            return false;
        }

        return Session::get('admin_role') === ROLE_SUPER_ADMIN;
    }

    /**
     * Returneaza ID-ul administratorului autentificat
     *
     * @return int|null ID-ul administratorului sau null daca nu este autentificat
     */
    public static function getAdminId(): ?int
    {
        return self::check() ? (int) Session::get('admin_id') : null;
    }

    /**
     * Returneaza numele administratorului autentificat
     *
     * @return string|null Numele administratorului sau null
     */
    public static function getAdminName(): ?string
    {
        return self::check() ? Session::get('admin_name') : null;
    }

    /**
     * Redirecteaza la login daca utilizatorul nu este autentificat
     *
     * Metoda utilitara pentru protejarea paginilor de administrare.
     *
     * @return void
     */
    public static function requireLogin(): void
    {
        if (!self::check()) {
            Session::setFlash('error', 'Trebuie sa fiti autentificat pentru a accesa aceasta pagina.');
            header('Location: /admin/login');
            exit;
        }
    }

    /**
     * Redirecteaza la dashboard daca utilizatorul nu este admin
     *
     * @return void
     */
    public static function requireAdmin(): void
    {
        self::requireLogin();

        if (!self::isAdmin()) {
            Session::setFlash('error', 'Nu aveti permisiunea de a accesa aceasta sectiune.');
            header('Location: /admin');
            exit;
        }
    }

    /**
     * Verifica daca IP-ul curent este blocat (rate limiting)
     *
     * Numara incercarile esuate de autentificare din sesiune.
     * Daca numarul depaseste MAX_LOGIN_ATTEMPTS in ultimele
     * LOGIN_LOCKOUT_TIME secunde, IP-ul este blocat temporar.
     *
     * @return bool True daca IP-ul este blocat
     */
    private function isLockedOut(): bool
    {
        $attempts = Session::get('login_attempts', []);
        $maxAttempts = defined('MAX_LOGIN_ATTEMPTS') ? MAX_LOGIN_ATTEMPTS : 5;
        $lockoutTime = defined('LOGIN_LOCKOUT_TIME') ? LOGIN_LOCKOUT_TIME : 900;

        /** Filtram incercarile din perioada de lockout */
        $recentAttempts = array_filter(
            $attempts,
            fn(int $timestamp): bool => $timestamp > (time() - $lockoutTime)
        );

        /** Actualizam lista filtrata */
        Session::set('login_attempts', array_values($recentAttempts));

        return count($recentAttempts) >= $maxAttempts;
    }

    /**
     * Calculeaza timpul ramas pana la deblocare
     *
     * @return int Secunde ramase pana la deblocare
     */
    private function getLockoutRemainingTime(): int
    {
        $attempts = Session::get('login_attempts', []);
        $lockoutTime = defined('LOGIN_LOCKOUT_TIME') ? LOGIN_LOCKOUT_TIME : 900;

        if (empty($attempts)) {
            return 0;
        }

        $oldestRelevant = min($attempts);
        $unlockTime = $oldestRelevant + $lockoutTime;

        return max(0, $unlockTime - time());
    }

    /**
     * Inregistreaza o incercare esuata de autentificare
     *
     * @return void
     */
    private function recordFailedAttempt(): void
    {
        $attempts = Session::get('login_attempts', []);
        $attempts[] = time();
        Session::set('login_attempts', $attempts);
    }

    /**
     * Sterge toate incercarile esuate de autentificare
     *
     * Apelata dupa o autentificare reusita.
     *
     * @return void
     */
    private function clearFailedAttempts(): void
    {
        Session::remove('login_attempts');
    }

    /**
     * Logheaza o activitate in tabelul activity_log
     *
     * @param int $adminId ID-ul administratorului
     * @param string $action Actiunea efectuata
     * @param string $entityType Tipul entitatii
     * @param int $entityId ID-ul entitatii
     * @param string $details Detalii suplimentare
     * @return void
     */
    private function logActivity(int $adminId, string $action, string $entityType, int $entityId, string $details): void
    {
        $this->db->insert('activity_log', [
            'admin_id'    => $adminId,
            'action'      => $action,
            'entity_type' => $entityType,
            'entity_id'   => $entityId,
            'details'     => $details,
            'ip_address'  => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
            'created_at'  => date('Y-m-d H:i:s'),
        ]);
    }
}
