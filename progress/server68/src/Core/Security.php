<?php
/**
 * Scanbox.ro - Utilitare de securitate
 *
 * Gestioneaza token-uri CSRF, sanitizarea inputurilor, validarea datelor
 * si escaparea outputului. Toate metodele sunt statice pentru acces usor.
 *
 * @package Scanbox\Core
 * @version 1.0.0
 */

declare(strict_types=1);

namespace Scanbox\Core;

class Security
{
    /**
     * Genereaza un token CSRF si il stocheaza in sesiune
     *
     * Foloseste random_bytes() pentru generarea criptografica sigura.
     * Token-ul este stocat in sesiune si poate fi verificat ulterior.
     *
     * @return string Token-ul CSRF generat
     */
    public static function generateCsrfToken(): string
    {
        $token = bin2hex(random_bytes(32));
        Session::set('csrf_token', $token);
        Session::set('csrf_token_time', time());
        return $token;
    }

    /**
     * Verifica validitatea token-ului CSRF
     *
     * Compara token-ul trimis cu cel din sesiune folosind hash_equals
     * pentru a preveni atacurile timing. Token-ul expira dupa 1 ora.
     *
     * @param string $token Token-ul CSRF de verificat
     * @return bool True daca token-ul este valid
     */
    public static function verifyCsrfToken(string $token): bool
    {
        $storedToken = Session::get('csrf_token', '');
        $tokenTime = Session::get('csrf_token_time', 0);

        /** Verificam daca token-ul exista */
        if (empty($storedToken) || empty($token)) {
            return false;
        }

        /** Verificam daca token-ul nu a expirat (1 ora) */
        if ((time() - (int) $tokenTime) > 3600) {
            Session::remove('csrf_token');
            Session::remove('csrf_token_time');
            return false;
        }

        /** Comparare sigura impotriva atacurilor timing */
        return hash_equals($storedToken, $token);
    }

    /**
     * Genereaza campul HTML ascuns pentru token-ul CSRF
     *
     * Returneaza un element input hidden cu token-ul CSRF,
     * gata de inclus in formulare.
     *
     * @return string Elementul HTML input cu token-ul CSRF
     */
    public static function csrfField(): string
    {
        $token = self::generateCsrfToken();
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }

    /**
     * Sanitizeaza un string - elimina tag-urile HTML si trimmeaza spatiile
     *
     * Foloseste strip_tags() pentru a elimina toate tag-urile HTML/PHP
     * si trim() pentru a curata spatiile de la inceput si sfarsit.
     *
     * @param string $input String-ul de sanitizat
     * @return string String-ul sanitizat
     */
    public static function sanitize(string $input): string
    {
        $input = trim($input);
        $input = strip_tags($input);
        $input = htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        return $input;
    }

    /**
     * Sanitizeaza HTML - permite doar tag-urile sigure
     *
     * Elimina tag-urile periculoase (script, iframe, etc.) dar pastreaza
     * tag-urile de formatare de baza (p, br, strong, em, ul, ol, li, a, h2-h6, img, blockquote).
     *
     * @param string $html Codul HTML de sanitizat
     * @return string HTML sanitizat cu tag-uri sigure
     */
    public static function sanitizeHtml(string $html): string
    {
        $html = trim($html);

        /** Tag-uri HTML permise */
        $allowedTags = '<p><br><strong><b><em><i><u><ul><ol><li><a><h2><h3><h4><h5><h6>'
            . '<img><blockquote><pre><code><table><thead><tbody><tr><th><td><hr><span><div><figure><figcaption>';

        $html = strip_tags($html, $allowedTags);

        /** Eliminam atribute periculoase (on*, javascript:, data:) */
        $html = preg_replace('/\s+on\w+\s*=\s*["\'][^"\']*["\']/i', '', $html);
        $html = preg_replace('/\s+on\w+\s*=\s*\S+/i', '', $html);
        $html = preg_replace('/javascript\s*:/i', '', $html);
        $html = preg_replace('/vbscript\s*:/i', '', $html);
        $html = preg_replace('/data\s*:[^,]*,/i', '', $html);

        return $html;
    }

    /**
     * Valideaza o adresa de email
     *
     * Foloseste FILTER_VALIDATE_EMAIL si verifica lungimea maxima.
     *
     * @param string $email Adresa de email de validat
     * @return bool True daca adresa este valida
     */
    public static function validateEmail(string $email): bool
    {
        $email = trim($email);

        if (strlen($email) > 254) {
            return false;
        }

        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Valideaza un numar de telefon romanesc
     *
     * Accepta formatele: +40XXXXXXXXX, 07XXXXXXXX, 0XXXXXXXXX
     * Cu sau fara spatii, cratime sau puncte ca separatori.
     *
     * @param string $phone Numarul de telefon de validat
     * @return bool True daca numarul este valid
     */
    public static function validatePhone(string $phone): bool
    {
        /** Eliminam separatorii */
        $phone = preg_replace('/[\s\-\.\(\)]/', '', $phone);

        /** Formatele acceptate pentru numere romanesti */
        $patterns = [
            '/^\+40[0-9]{9}$/',      // +40XXXXXXXXX
            '/^0040[0-9]{9}$/',      // 0040XXXXXXXXX
            '/^0[0-9]{9}$/',         // 0XXXXXXXXX
            '/^[0-9]{10}$/',         // XXXXXXXXXX (cu 0 la inceput)
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $phone)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Escapeaza outputul pentru afisare sigura in HTML
     *
     * Converteste caracterele speciale HTML in entitati pentru a preveni
     * atacurile XSS (Cross-Site Scripting).
     *
     * @param string|null $output Textul de escapeat
     * @return string Textul escapeat sigur pentru HTML
     */
    public static function escapeOutput(?string $output): string
    {
        if ($output === null) {
            return '';
        }

        return htmlspecialchars($output, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Valideaza un slug URL
     *
     * Verifica ca slug-ul contine doar caractere permise:
     * litere mici, cifre si cratime.
     *
     * @param string $slug Slug-ul de validat
     * @return bool True daca slug-ul este valid
     */
    public static function validateSlug(string $slug): bool
    {
        return (bool) preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug);
    }

    /**
     * Valideaza un URL complet
     *
     * @param string $url URL-ul de validat
     * @return bool True daca URL-ul este valid
     */
    public static function validateUrl(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Genereaza un string aleator sigur criptografic
     *
     * @param int $length Lungimea string-ului (default 32)
     * @return string String-ul aleator in format hexazecimal
     */
    public static function generateRandomString(int $length = 32): string
    {
        return bin2hex(random_bytes((int) ceil($length / 2)));
    }

    /**
     * Hash-uieste o parola cu Argon2id
     *
     * Foloseste algoritmul Argon2id daca este disponibil,
     * altfel foloseste BCRYPT ca fallback.
     *
     * @param string $password Parola in text clar
     * @return string Hash-ul parolei
     */
    public static function hashPassword(string $password): string
    {
        if (defined('PASSWORD_ARGON2ID')) {
            return password_hash($password, PASSWORD_ARGON2ID, [
                'memory_cost' => 65536,
                'time_cost'   => 4,
                'threads'     => 3,
            ]);
        }

        /** Fallback la BCRYPT daca Argon2id nu este disponibil */
        return password_hash($password, PASSWORD_BCRYPT, [
            'cost' => 12,
        ]);
    }

    /**
     * Verifica daca o cerere vine de la un referrer valid
     *
     * @return bool True daca referrer-ul este din acelasi domeniu
     */
    public static function isValidReferrer(): bool
    {
        if (!isset($_SERVER['HTTP_REFERER'])) {
            return false;
        }

        $referrerHost = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
        $siteHost = parse_url(SITE_URL, PHP_URL_HOST);

        return $referrerHost === $siteHost;
    }

    /**
     * Obtine adresa IP reala a clientului
     *
     * Verifica headerele proxy (X-Forwarded-For, X-Real-IP)
     * si returneaza adresa IP cea mai probabila.
     *
     * @return string Adresa IP a clientului
     */
    public static function getClientIp(): string
    {
        $headers = [
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_REAL_IP',
            'HTTP_CLIENT_IP',
            'REMOTE_ADDR',
        ];

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ips = explode(',', $_SERVER[$header]);
                $ip = trim($ips[0]);

                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }

        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
}
