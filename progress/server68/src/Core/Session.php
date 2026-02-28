<?php
/**
 * Scanbox.ro - Gestionarea sesiunilor
 *
 * Ofera metode pentru pornirea, oprirea si manipularea sesiunilor PHP.
 * Include verificarea timeout-ului, regenerarea ID-ului la autentificare
 * si suport pentru mesaje flash (afisate o singura data).
 *
 * @package Scanbox\Core
 * @version 1.0.0
 */

declare(strict_types=1);

namespace Scanbox\Core;

class Session
{
    /**
     * Porneste sesiunea cu configurari de securitate
     *
     * Configureaza cookie-urile de sesiune cu flag-uri httponly, secure si samesite.
     * Verifica daca sesiunea nu este deja pornita inainte de a o initializa.
     * Dupa pornire, verifica timeout-ul sesiunii.
     *
     * @return void
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        /** Configurari securitate cookie sesiune */
        $cookieParams = [
            'lifetime' => 0,
            'path'     => '/',
            'domain'   => '',
            'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'httponly'  => true,
            'samesite' => 'Lax',
        ];

        session_set_cookie_params($cookieParams);
        session_name('SCANBOX_SESSID');

        session_start();

        /** Verificam timeout-ul sesiunii */
        self::checkTimeout();
    }

    /**
     * Distruge sesiunea complet
     *
     * Sterge toate datele sesiunii, cookie-ul de sesiune
     * si distruge sesiunea de pe server.
     *
     * @return void
     */
    public static function destroy(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            return;
        }

        /** Golim array-ul sesiunii */
        $_SESSION = [];

        /** Stergem cookie-ul de sesiune */
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                [
                    'expires'  => time() - 42000,
                    'path'     => $params['path'],
                    'domain'   => $params['domain'],
                    'secure'   => $params['secure'],
                    'httponly'  => $params['httponly'],
                    'samesite' => $params['samesite'] ?? 'Lax',
                ]
            );
        }

        session_destroy();
    }

    /**
     * Obtine o valoare din sesiune
     *
     * @param string $key Cheia valorii
     * @param mixed $default Valoarea implicita daca cheia nu exista
     * @return mixed Valoarea din sesiune sau valoarea implicita
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Seteaza o valoare in sesiune
     *
     * @param string $key Cheia valorii
     * @param mixed $value Valoarea de setat
     * @return void
     */
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Verifica daca o cheie exista in sesiune
     *
     * @param string $key Cheia de verificat
     * @return bool True daca cheia exista
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Sterge o valoare din sesiune
     *
     * @param string $key Cheia de sters
     * @return void
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Verifica si gestioneaza timeout-ul sesiunii
     *
     * Daca au trecut mai mult de SESSION_TIMEOUT secunde de la
     * ultima activitate, sesiunea este distrusa si utilizatorul
     * este delogat. Altfel, actualizeaza timestamp-ul activitatii.
     *
     * @return void
     */
    private static function checkTimeout(): void
    {
        $timeout = defined('SESSION_TIMEOUT') ? SESSION_TIMEOUT : 1800;

        if (isset($_SESSION['last_activity'])) {
            $elapsed = time() - (int) $_SESSION['last_activity'];

            if ($elapsed > $timeout) {
                /** Sesiunea a expirat */
                self::destroy();
                self::start();
                self::setFlash('warning', 'Sesiunea a expirat. Va rugam sa va autentificati din nou.');
                return;
            }
        }

        /** Actualizam timpul ultimei activitati */
        $_SESSION['last_activity'] = time();
    }

    /**
     * Regenereaza ID-ul sesiunii
     *
     * Folosit la autentificare pentru a preveni atacurile de fixare a sesiunii.
     * Sterge sesiunea veche de pe server.
     *
     * @return void
     */
    public static function regenerate(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }

    /**
     * Seteaza un mesaj flash
     *
     * Mesajele flash sunt stocate in sesiune si sunt disponibile
     * doar la urmatoarea cerere. Dupa afisare, sunt sterse automat.
     *
     * @param string $type Tipul mesajului (success, error, warning, info)
     * @param string $message Textul mesajului
     * @return void
     */
    public static function setFlash(string $type, string $message): void
    {
        $_SESSION['flash_messages'][$type][] = $message;
    }

    /**
     * Obtine si sterge toate mesajele flash
     *
     * Returneaza mesajele grupate pe tip si le sterge din sesiune.
     * La urmatoarea apelare, va returna un array gol.
     *
     * @return array Mesajele flash grupate pe tip
     */
    public static function getFlash(): array
    {
        $messages = $_SESSION['flash_messages'] ?? [];
        unset($_SESSION['flash_messages']);
        return $messages;
    }

    /**
     * Obtine mesajele flash pentru un anumit tip
     *
     * @param string $type Tipul mesajelor (success, error, warning, info)
     * @return array Lista mesajelor de tipul specificat
     */
    public static function getFlashByType(string $type): array
    {
        $messages = $_SESSION['flash_messages'][$type] ?? [];
        unset($_SESSION['flash_messages'][$type]);
        return $messages;
    }

    /**
     * Verifica daca exista mesaje flash
     *
     * @return bool True daca exista mesaje flash
     */
    public static function hasFlash(): bool
    {
        return !empty($_SESSION['flash_messages']);
    }
}
