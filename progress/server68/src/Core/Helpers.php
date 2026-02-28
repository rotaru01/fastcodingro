<?php
/**
 * Scanbox.ro - Functii utilitare globale
 *
 * Colectie de functii helper folosite in toata aplicatia:
 * generare slug-uri, formatare date, redirectari, cai catre
 * resurse, raspunsuri JSON si altele.
 *
 * @package Scanbox\Core
 * @version 1.0.0
 */

declare(strict_types=1);

namespace Scanbox\Core;

class Helpers
{
    /**
     * Genereaza un slug URL-friendly dintr-un text
     *
     * Converteste textul in litere mici, inlocuieste diacriticele romanesti,
     * elimina caracterele speciale si inlocuieste spatiile cu cratime.
     *
     * Exemplu: "Tur Virtual 3D - Prezentare!" => "tur-virtual-3d-prezentare"
     *
     * @param string $text Textul de convertit in slug
     * @return string Slug-ul URL-friendly
     */
    public static function slugify(string $text): string
    {
        /** Inlocuim diacriticele romanesti */
        $replacements = [
            'ă' => 'a', 'â' => 'a', 'î' => 'i', 'ș' => 's', 'ț' => 't',
            'Ă' => 'a', 'Â' => 'a', 'Î' => 'i', 'Ș' => 's', 'Ț' => 't',
            'ş' => 's', 'ţ' => 't', 'Ş' => 's', 'Ţ' => 't',
        ];

        $text = strtr($text, $replacements);

        /** Convertim la litere mici */
        $text = mb_strtolower($text, 'UTF-8');

        /** Transliteram alte caractere speciale */
        if (function_exists('transliterator_transliterate')) {
            $text = transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $text);
        }

        /** Inlocuim orice nu este litera, cifra sau cratima cu cratima */
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);

        /** Eliminam cratimele de la inceput si sfarsit */
        $text = trim($text, '-');

        /** Eliminam cratimele duble */
        $text = preg_replace('/-+/', '-', $text);

        return $text;
    }

    /**
     * Trunchiaza un text la o lungime maxima
     *
     * Taie textul la cel mai apropiat cuvant complet si adauga
     * un sufix (implicit "...") daca textul a fost trunchiat.
     *
     * @param string $text Textul de trunchiat
     * @param int $length Lungimea maxima (default 160)
     * @param string $suffix Sufixul de adaugat (default "...")
     * @return string Textul trunchiat
     */
    public static function truncate(string $text, int $length = 160, string $suffix = '...'): string
    {
        $text = strip_tags($text);

        if (mb_strlen($text, 'UTF-8') <= $length) {
            return $text;
        }

        /** Taiem la cea mai apropiata granita de cuvant */
        $truncated = mb_substr($text, 0, $length, 'UTF-8');
        $lastSpace = mb_strrpos($truncated, ' ', 0, 'UTF-8');

        if ($lastSpace !== false && $lastSpace > $length * 0.75) {
            $truncated = mb_substr($truncated, 0, $lastSpace, 'UTF-8');
        }

        return rtrim($truncated) . $suffix;
    }

    /**
     * Formateaza o data in format romanesc
     *
     * @param string|null $dateString Data in format MySQL (Y-m-d H:i:s)
     * @param string $format Formatul dorit (default: 'd MMMM Y')
     * @return string Data formatata in limba romana
     */
    public static function formatDate(?string $dateString, string $format = 'full'): string
    {
        if (empty($dateString)) {
            return '';
        }

        $timestamp = strtotime($dateString);
        if ($timestamp === false) {
            return '';
        }

        $months = [
            1  => 'ianuarie',
            2  => 'februarie',
            3  => 'martie',
            4  => 'aprilie',
            5  => 'mai',
            6  => 'iunie',
            7  => 'iulie',
            8  => 'august',
            9  => 'septembrie',
            10 => 'octombrie',
            11 => 'noiembrie',
            12 => 'decembrie',
        ];

        $day = (int) date('j', $timestamp);
        $month = $months[(int) date('n', $timestamp)];
        $year = date('Y', $timestamp);
        $time = date('H:i', $timestamp);

        return match ($format) {
            'full'      => sprintf('%d %s %s', $day, $month, $year),
            'short'     => sprintf('%02d.%02d.%s', $day, (int) date('n', $timestamp), $year),
            'datetime'  => sprintf('%d %s %s, %s', $day, $month, $year, $time),
            'month'     => sprintf('%s %s', $month, $year),
            'relative'  => self::timeAgo($dateString),
            default     => date($format, $timestamp),
        };
    }

    /**
     * Calculeaza timpul scurs in format "acum X" (time ago)
     *
     * Returneaza un text relativ in limba romana:
     * "acum cateva secunde", "acum 5 minute", "acum 2 ore", etc.
     *
     * @param string $dateString Data in format MySQL
     * @return string Timpul relativ in limba romana
     */
    public static function timeAgo(string $dateString): string
    {
        $timestamp = strtotime($dateString);
        if ($timestamp === false) {
            return '';
        }

        $diff = time() - $timestamp;

        if ($diff < 0) {
            return 'in viitor';
        }

        if ($diff < 60) {
            return 'acum cateva secunde';
        }

        if ($diff < 3600) {
            $minutes = (int) floor($diff / 60);
            return sprintf('acum %d %s', $minutes, $minutes === 1 ? 'minut' : 'minute');
        }

        if ($diff < 86400) {
            $hours = (int) floor($diff / 3600);
            return sprintf('acum %d %s', $hours, $hours === 1 ? 'ora' : 'ore');
        }

        if ($diff < 2592000) {
            $days = (int) floor($diff / 86400);
            if ($days === 1) {
                return 'ieri';
            }
            return sprintf('acum %d zile', $days);
        }

        if ($diff < 31536000) {
            $months = (int) floor($diff / 2592000);
            return sprintf('acum %d %s', $months, $months === 1 ? 'luna' : 'luni');
        }

        $years = (int) floor($diff / 31536000);
        return sprintf('acum %d %s', $years, $years === 1 ? 'an' : 'ani');
    }

    /**
     * Redirecteaza catre un URL
     *
     * Seteaza headerul Location si opreste executia scriptului.
     * Suporta atat cai relative (prefixate cu SITE_URL) cat si URL-uri absolute.
     *
     * @param string $url URL-ul sau calea de redirectare
     * @param int $statusCode Codul HTTP de redirectare (default 302)
     * @return never
     */
    public static function redirect(string $url, int $statusCode = 302): never
    {
        /** Daca URL-ul este relativ, il prefixam cu baza site-ului */
        if (str_starts_with($url, '/')) {
            $url = SITE_URL . $url;
        }

        http_response_code($statusCode);
        header('Location: ' . $url);
        exit;
    }

    /**
     * Genereaza URL-ul complet catre o resursa statica
     *
     * @param string $path Calea relativa a resursei (ex: 'css/style.css')
     * @return string URL-ul complet catre resursa
     */
    public static function asset(string $path): string
    {
        $path = ltrim($path, '/');
        $version = defined('APP_VERSION') ? APP_VERSION : '1.0.0';
        return SITE_URL . '/assets/' . $path . '?v=' . $version;
    }

    /**
     * Genereaza URL-ul catre un fisier incarcat
     *
     * @param string|null $path Calea relativa a fisierului din uploads/
     * @param string $default Imaginea implicita daca path-ul este gol
     * @return string URL-ul catre fisierul incarcat
     */
    public static function uploadUrl(?string $path, string $default = ''): string
    {
        if (empty($path)) {
            return !empty($default) ? self::asset($default) : '';
        }

        $path = ltrim($path, '/');
        return UPLOADS_URL . $path;
    }

    /**
     * Verifica daca o cale URL este activa (pentru meniuri de navigare)
     *
     * Compara calea curenta cu cea specificata. Suporta potrivire
     * exacta sau pe prefix (utila pentru submeniuri).
     *
     * @param string $path Calea de verificat
     * @param bool $exact Potrivire exacta (true) sau pe prefix (false)
     * @return bool True daca calea este activa
     */
    public static function isActive(string $path, bool $exact = true): bool
    {
        $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
        $currentPath = rtrim($currentPath, '/') ?: '/';
        $path = rtrim($path, '/') ?: '/';

        if ($exact) {
            return $currentPath === $path;
        }

        return str_starts_with($currentPath, $path);
    }

    /**
     * Returneaza clasa CSS 'active' daca calea este activa
     *
     * @param string $path Calea de verificat
     * @param string $activeClass Clasa CSS de returnat (default 'active')
     * @param bool $exact Potrivire exacta
     * @return string Clasa CSS sau string gol
     */
    public static function activeClass(string $path, string $activeClass = 'active', bool $exact = true): string
    {
        return self::isActive($path, $exact) ? $activeClass : '';
    }

    /**
     * Trimite un raspuns JSON si opreste executia
     *
     * Seteaza headerele corecte Content-Type si codul HTTP,
     * encodeaza datele si opreste scriptul.
     *
     * @param array $data Datele de trimis ca JSON
     * @param int $statusCode Codul HTTP (default 200)
     * @return never
     */
    public static function jsonResponse(array $data, int $statusCode = 200): never
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-cache, no-store, must-revalidate');

        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Genereaza URL-ul complet al unei pagini
     *
     * @param string $path Calea relativa a paginii
     * @return string URL-ul complet
     */
    public static function url(string $path = '/'): string
    {
        $path = '/' . ltrim($path, '/');
        return SITE_URL . $path;
    }

    /**
     * Formateaza dimensiunea unui fisier in format citibil
     *
     * @param int $bytes Dimensiunea in bytes
     * @param int $decimals Numarul de zecimale
     * @return string Dimensiunea formatata (ex: "2.5 MB")
     */
    public static function formatFileSize(int $bytes, int $decimals = 2): string
    {
        if ($bytes === 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $factor = (int) floor(log($bytes, 1024));
        $factor = min($factor, count($units) - 1);

        return sprintf('%.' . $decimals . 'f %s', $bytes / (1024 ** $factor), $units[$factor]);
    }

    /**
     * Genereaza numarul de pagini pentru paginare
     *
     * @param int $totalItems Numarul total de elemente
     * @param int $perPage Elemente pe pagina
     * @return int Numarul total de pagini
     */
    public static function totalPages(int $totalItems, int $perPage): int
    {
        if ($perPage <= 0) {
            return 1;
        }

        return (int) ceil($totalItems / $perPage);
    }

    /**
     * Obtine pagina curenta din query string
     *
     * @param int $default Pagina implicita
     * @return int Numarul paginii curente (minim 1)
     */
    public static function currentPage(int $default = 1): int
    {
        $page = (int) ($_GET['page'] ?? $default);
        return max(1, $page);
    }

    /**
     * Calculeaza offset-ul pentru interogari SQL LIMIT/OFFSET
     *
     * @param int $page Numarul paginii
     * @param int $perPage Elemente pe pagina
     * @return int Offset-ul calculat
     */
    public static function offset(int $page, int $perPage): int
    {
        return ($page - 1) * $perPage;
    }
}
