<?php
/**
 * Scanbox.ro - Front Controller (Punct de intrare principal)
 *
 * Toate cererile HTTP trec prin acest fisier. Se ocupa de:
 * - Pornirea sesiunii
 * - Incarcarea configurarii
 * - Autoload-ul claselor din src/
 * - Initializarea router-ului
 * - Gestionarea cererii cu output buffering si gzip
 *
 * @package Scanbox
 * @version 1.0.0
 */

declare(strict_types=1);

/** Masurare timp de executie pentru debugging */
define('APP_START_TIME', microtime(true));

/** Calea de baza a aplicatiei */
define('BASE_PATH', dirname(__DIR__));

/**
 * Incarcam configurarea principala
 *
 * Defineste constantele DB_*, SITE_*, UPLOADS_*, SESSION_*, etc.
 */
require_once BASE_PATH . '/config/config.php';

/**
 * Incarcam constantele aplicatiei
 *
 * Defineste ROUTES, ALLOWED_FILE_TYPES, dimensiuni, etc.
 */
require_once BASE_PATH . '/config/constants.php';

/**
 * Incarcam clasa de conexiune la baza de date (singleton)
 */
require_once BASE_PATH . '/config/database.php';

/**
 * Incarcam functiile helper globale (view, etc.)
 */
require_once BASE_PATH . '/config/helpers.php';

/**
 * Autoloader personalizat pentru clasele din src/
 *
 * Converteste namespace-urile Scanbox\ in cai de fisier relative
 * la directorul src/. Exemplu:
 *   Scanbox\Core\Router => src/Core/Router.php
 *   Scanbox\Controllers\PageController => src/Controllers/PageController.php
 *
 * @param string $className Numele complet al clasei cu namespace
 * @return void
 */
spl_autoload_register(function (string $className): void {
    /** Verificam daca clasa apartine namespace-ului Scanbox */
    $prefix = 'Scanbox\\';
    $prefixLength = strlen($prefix);

    if (strncmp($className, $prefix, $prefixLength) !== 0) {
        return;
    }

    /** Extragem calea relativa din namespace */
    $relativeClass = substr($className, $prefixLength);

    /** Construim calea catre fisier */
    $filePath = BASE_PATH . '/src/' . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($filePath)) {
        require_once $filePath;
    }
});

/**
 * Pornirea sesiunii cu gestionare securizata
 *
 * Initializeaza sesiunea cu cookie-uri httponly, secure si samesite.
 * Verifica si timeout-ul sesiunii existente.
 */
\Scanbox\Core\Session::start();

/**
 * Output Buffering cu compresie gzip
 *
 * Activam output buffering pentru a permite:
 * 1. Trimiterea headerelor dupa ce outputul a inceput
 * 2. Compresie gzip automata daca clientul o suporta
 * 3. Capturarea erorilor fatale inainte de trimiterea raspunsului
 */
$useGzip = !empty($_SERVER['HTTP_ACCEPT_ENCODING'])
    && str_contains($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')
    && extension_loaded('zlib')
    && !ini_get('zlib.output_compression');

if ($useGzip) {
    ob_start('ob_gzhandler');
} else {
    ob_start();
}

/**
 * Setam headere de securitate implicite
 *
 * Acestea se aplica tuturor raspunsurilor HTTP.
 */
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

/**
 * Initializam si executam router-ul
 *
 * Router-ul analizeaza REQUEST_URI, gaseste ruta potrivita
 * si apeleaza controller-ul/metoda corespunzatoare.
 */
try {
    $router = new \Scanbox\Core\Router();
    $router->dispatch();
} catch (\Throwable $e) {
    /** Logam eroarea */
    error_log(sprintf(
        "[%s] Eroare fatala: %s in %s:%d\nStack trace:\n%s\n",
        date('Y-m-d H:i:s'),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine(),
        $e->getTraceAsString()
    ));

    /** Afisam pagina de eroare in productie */
    if (!headers_sent()) {
        http_response_code(500);
    }

    echo '<!DOCTYPE html><html lang="ro"><head><meta charset="UTF-8">';
    echo '<title>Eroare server | ' . SITE_NAME . '</title>';
    echo '<style>body{font-family:sans-serif;display:flex;justify-content:center;';
    echo 'align-items:center;min-height:100vh;margin:0;background:#f5f5f5;}';
    echo '.container{text-align:center;padding:2rem;}';
    echo 'h1{font-size:4rem;margin:0;color:#e94560;}';
    echo 'p{font-size:1.2rem;color:#666;margin:1rem 0;}';
    echo 'a{color:#1a1a2e;text-decoration:none;font-weight:bold;}';
    echo 'a:hover{text-decoration:underline;}</style></head>';
    echo '<body><div class="container">';
    echo '<h1>500</h1>';
    echo '<p>Ne pare rau, a aparut o eroare de server.</p>';
    echo '<p>Va rugam reincercati mai tarziu.</p>';
    echo '<a href="/">Inapoi la pagina principala</a>';
    echo '</div></body></html>';
}

/** Golim output buffer-ul */
if (ob_get_level() > 0) {
    ob_end_flush();
}
