<?php
/**
 * Scanbox.ro - Sistem de caching bazat pe fisiere
 *
 * Implementeaza un cache simplu bazat pe fisiere in directorul logs/.
 * Suporta TTL (Time To Live) configurabil pentru fiecare cheie.
 *
 * @package Scanbox\Core
 * @version 1.0.0
 */

declare(strict_types=1);

namespace Scanbox\Core;

class Cache
{
    /** @var string Directorul pentru fisierele cache */
    private string $cacheDir;

    /** @var string Prefixul fisierelor cache */
    private string $prefix = 'cache_';

    /**
     * Constructor - seteaza directorul cache
     *
     * Foloseste directorul logs/ ca locatie implicita pentru cache.
     * Creeaza directorul daca nu exista.
     */
    public function __construct()
    {
        $this->cacheDir = __DIR__ . '/../../logs/cache/';

        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    /**
     * Obtine o valoare din cache
     *
     * Verifica daca fisierul cache exista, daca nu a expirat
     * si returneaza valoarea deserializata.
     *
     * @param string $key Cheia cache-ului
     * @param mixed $default Valoarea implicita daca cheia nu exista sau a expirat
     * @return mixed Valoarea din cache sau valoarea implicita
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $filePath = $this->getFilePath($key);

        if (!file_exists($filePath)) {
            return $default;
        }

        $content = file_get_contents($filePath);
        if ($content === false) {
            return $default;
        }

        $data = unserialize($content);
        if ($data === false) {
            $this->delete($key);
            return $default;
        }

        /** Verificam daca cache-ul a expirat */
        if (isset($data['expires_at']) && $data['expires_at'] > 0 && time() > $data['expires_at']) {
            $this->delete($key);
            return $default;
        }

        return $data['value'] ?? $default;
    }

    /**
     * Stocheaza o valoare in cache
     *
     * Serializeaza valoarea si o salveaza in fisier cu metadata TTL.
     * Foloseste scriere atomica (write + rename) pentru a preveni
     * coruperea datelor la accesuri concurente.
     *
     * @param string $key Cheia cache-ului
     * @param mixed $value Valoarea de stocat
     * @param int $ttl Durata de viata in secunde (0 = fara expirare)
     * @return bool True daca valoarea a fost stocata cu succes
     */
    public function set(string $key, mixed $value, int $ttl = 3600): bool
    {
        $filePath = $this->getFilePath($key);

        $data = [
            'key'        => $key,
            'value'      => $value,
            'created_at' => time(),
            'expires_at' => $ttl > 0 ? time() + $ttl : 0,
        ];

        $serialized = serialize($data);

        /** Scriere atomica - scriem intr-un fisier temporar apoi redenumim */
        $tempFile = $filePath . '.tmp.' . getmypid();

        $written = file_put_contents($tempFile, $serialized, LOCK_EX);
        if ($written === false) {
            @unlink($tempFile);
            return false;
        }

        return rename($tempFile, $filePath);
    }

    /**
     * Sterge o valoare din cache
     *
     * @param string $key Cheia cache-ului de sters
     * @return bool True daca fisierul a fost sters sau nu exista
     */
    public function delete(string $key): bool
    {
        $filePath = $this->getFilePath($key);

        if (file_exists($filePath)) {
            return unlink($filePath);
        }

        return true;
    }

    /**
     * Goleste intregul cache
     *
     * Sterge toate fisierele cache din directorul cache.
     *
     * @return bool True daca cache-ul a fost golit complet
     */
    public function clear(): bool
    {
        $files = glob($this->cacheDir . $this->prefix . '*');

        if ($files === false) {
            return false;
        }

        $success = true;
        foreach ($files as $file) {
            if (is_file($file)) {
                if (!unlink($file)) {
                    $success = false;
                }
            }
        }

        return $success;
    }

    /**
     * Verifica daca o cheie exista si nu a expirat in cache
     *
     * @param string $key Cheia de verificat
     * @return bool True daca cheia exista si este valida
     */
    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }

    /**
     * Obtine valoarea din cache sau o genereaza si o stocheaza
     *
     * Daca cheia exista in cache, returneaza valoarea stocata.
     * Daca nu exista, apeleaza callback-ul pentru a genera valoarea,
     * o stocheaza in cache si o returneaza.
     *
     * @param string $key Cheia cache-ului
     * @param callable $callback Functia care genereaza valoarea
     * @param int $ttl Durata de viata in secunde
     * @return mixed Valoarea din cache sau cea generata
     */
    public function remember(string $key, callable $callback, int $ttl = 3600): mixed
    {
        $value = $this->get($key);

        if ($value !== null) {
            return $value;
        }

        $value = $callback();
        $this->set($key, $value, $ttl);

        return $value;
    }

    /**
     * Sterge fisierele cache expirate
     *
     * Parcurge toate fisierele cache si le sterge pe cele expirate.
     * Recomandat a fi rulat periodic (cron job) pentru curatenie.
     *
     * @return int Numarul de fisiere sterse
     */
    public function cleanup(): int
    {
        $files = glob($this->cacheDir . $this->prefix . '*');
        $deleted = 0;

        if ($files === false) {
            return 0;
        }

        foreach ($files as $file) {
            if (!is_file($file)) {
                continue;
            }

            $content = file_get_contents($file);
            if ($content === false) {
                unlink($file);
                $deleted++;
                continue;
            }

            $data = @unserialize($content);
            if ($data === false) {
                unlink($file);
                $deleted++;
                continue;
            }

            if (isset($data['expires_at']) && $data['expires_at'] > 0 && time() > $data['expires_at']) {
                unlink($file);
                $deleted++;
            }
        }

        return $deleted;
    }

    /**
     * Construieste calea completa catre fisierul cache
     *
     * Genereaza un hash MD5 al cheii pentru numele fisierului.
     *
     * @param string $key Cheia cache-ului
     * @return string Calea completa catre fisierul cache
     */
    private function getFilePath(string $key): string
    {
        $safeKey = md5($key);
        return $this->cacheDir . $this->prefix . $safeKey;
    }
}
