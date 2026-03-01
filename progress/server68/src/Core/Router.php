<?php
/**
 * Scanbox.ro - Router MVC personalizat
 *
 * Analizeaza URL-ul din REQUEST_URI, potriveste rutele definite
 * in constante si apeleaza controller-ul si metoda corespunzatoare.
 * Suporta metode GET/POST, parametri dinamici si fallback 404.
 *
 * @package Scanbox\Core
 * @version 1.0.0
 */

declare(strict_types=1);

namespace Scanbox\Core;

class Router
{
    /** @var array Rutele inregistrate din configurare */
    private array $routes = [];

    /** @var string Calea URL curenta */
    private string $currentPath = '';

    /** @var string Metoda HTTP curenta (GET, POST) */
    private string $currentMethod = '';

    /**
     * Constructor - incarca rutele si determina cererea curenta
     *
     * Parseaza REQUEST_URI pentru a extrage calea curata (fara query string),
     * normalizeaza slash-urile si determina metoda HTTP.
     */
    public function __construct()
    {
        $this->routes = ROUTES;
        $this->currentMethod = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';

        /** Eliminam base path-ul (pentru instalare in subfolder) */
        $basePath = defined('BASE_URL_PATH') ? BASE_URL_PATH : '';
        if ($basePath && str_starts_with($path, $basePath)) {
            $path = substr($path, strlen($basePath));
        }

        /** Eliminam trailing slash, dar pastram root */
        $path = rtrim($path, '/') ?: '/';

        $this->currentPath = $path;
    }

    /**
     * Proceseaza cererea si apeleaza controller-ul potrivit
     *
     * Parcurge rutele definite in ordine, cauta o potrivire exacta
     * sau cu parametri dinamici. Daca gaseste o ruta API, o directioneaza
     * catre fisierul API corespunzator. Pentru rute inexistente, afiseaza 404.
     *
     * @return void
     */
    public function dispatch(): void
    {
        /** Verificam daca este o ruta API */
        if ($this->handleApiRoute()) {
            return;
        }

        /** Cautam ruta potrivita */
        foreach ($this->routes as $routePattern => $handler) {
            $match = $this->matchRoute($routePattern);

            if ($match !== false) {
                $this->callController($handler, $match);
                return;
            }
        }

        /** Nicio ruta gasita - afisam 404 */
        $this->handle404();
    }

    /**
     * Verifica daca ruta curenta se potriveste cu un pattern
     *
     * Suporta pattern-uri statice si dinamice cu {param}.
     * Verifica si metoda HTTP (GET/POST).
     *
     * @param string $routePattern Pattern-ul rutei (ex: 'GET|/blog/{slug}')
     * @return array|false Parametrii extrasi sau false daca nu se potriveste
     */
    private function matchRoute(string $routePattern): array|false
    {
        /** Extragem metoda si calea din pattern */
        $parts = explode('|', $routePattern, 2);
        if (count($parts) !== 2) {
            return false;
        }

        [$method, $pattern] = $parts;

        /** Verificam metoda HTTP */
        if ($method !== $this->currentMethod) {
            return false;
        }

        /** Potrivire exacta - fara parametri dinamici */
        if ($pattern === $this->currentPath) {
            return [];
        }

        /** Potrivire cu parametri dinamici */
        if (str_contains($pattern, '{')) {
            $regex = $this->patternToRegex($pattern);
            if (preg_match($regex, $this->currentPath, $matches)) {
                /** Returnam doar grupurile numite */
                return array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            }
        }

        return false;
    }

    /**
     * Converteste un pattern de ruta intr-o expresie regulata
     *
     * Transforma {param} in grupuri de capturare numite.
     * Exemple:
     *   /blog/{slug} => /^\/blog\/(?P<slug>[a-zA-Z0-9\-_]+)$/
     *   /admin/blog/edit/{id} => /^\/admin\/blog\/edit\/(?P<id>[a-zA-Z0-9\-_]+)$/
     *
     * @param string $pattern Pattern-ul rutei
     * @return string Expresia regulata
     */
    private function patternToRegex(string $pattern): string
    {
        $regex = preg_replace_callback(
            '/\{([a-zA-Z_]+)\}/',
            function (array $matches): string {
                return '(?P<' . $matches[1] . '>[a-zA-Z0-9\-_]+)';
            },
            $pattern
        );

        return '#^' . $regex . '$#';
    }

    /**
     * Apeleaza controller-ul si metoda din handler
     *
     * Instantiaza controller-ul, verifica existenta metodei si o apeleaza
     * cu parametrii extrasi din ruta. Handler-ul poate contine si parametri
     * predefiniti (ex: pentru paginile de servicii).
     *
     * @param array $handler Configurarea handler-ului [controller, metoda, ?parametri_predefiniti]
     * @param array $routeParams Parametrii extrasi din URL
     * @return void
     */
    private function callController(array $handler, array $routeParams): void
    {
        $controllerName = $handler[0];
        $methodName = $handler[1];
        $predefinedParams = $handler[2] ?? [];

        /** Construim numele complet al clasei cu namespace */
        $controllerClass = 'Scanbox\\Controllers\\' . $controllerName;

        /** Verificam existenta clasei controller */
        if (!class_exists($controllerClass)) {
            error_log(sprintf(
                '[%s] Controller inexistent: %s',
                date('Y-m-d H:i:s'),
                $controllerClass
            ));
            $this->handle404();
            return;
        }

        $controller = new $controllerClass();

        /** Verificam existenta metodei */
        if (!method_exists($controller, $methodName)) {
            error_log(sprintf(
                '[%s] Metoda inexistenta: %s::%s',
                date('Y-m-d H:i:s'),
                $controllerClass,
                $methodName
            ));
            $this->handle404();
            return;
        }

        /** Combinam parametrii predefiniti cu cei din URL */
        $params = !empty($predefinedParams) ? $predefinedParams : array_values($routeParams);

        /** Apelam metoda cu parametrii */
        call_user_func_array([$controller, $methodName], $params);
    }

    /**
     * Gestioneaza rutele API (/api/*)
     *
     * Directioneaza cererile /api/* catre fisierele PHP corespunzatoare
     * din directorul api/. Valideaza existenta fisierului inainte de includere.
     *
     * @return bool True daca a fost o ruta API, false altfel
     */
    private function handleApiRoute(): bool
    {
        if (!str_starts_with($this->currentPath, '/api/')) {
            return false;
        }

        /** Extragem numele endpoint-ului API */
        $endpoint = substr($this->currentPath, 5); // elimina '/api/'
        $endpoint = preg_replace('/[^a-zA-Z0-9\-_\/]/', '', $endpoint);

        /** Construim calea catre fisierul API */
        $apiFile = __DIR__ . '/../../api/' . $endpoint . '.php';
        $apiFile = realpath($apiFile);

        /** Verificam ca fisierul exista si este in directorul api/ */
        $apiDir = realpath(__DIR__ . '/../../api/');
        if ($apiFile === false || !str_starts_with($apiFile, $apiDir)) {
            http_response_code(404);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'success' => false,
                'message' => 'Endpoint API inexistent.',
            ], JSON_UNESCAPED_UNICODE);
            return true;
        }

        /** Includem fisierul API */
        require_once $apiFile;
        return true;
    }

    /**
     * Afiseaza pagina 404 - Pagina nu a fost gasita
     *
     * Seteaza codul HTTP 404 si incearca sa incarce un view personalizat.
     * Daca view-ul nu exista, afiseaza un mesaj simplu.
     *
     * @return void
     */
    private function handle404(): void
    {
        http_response_code(404);

        $viewFile = __DIR__ . '/../Views/pages/404.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            header('Content-Type: text/html; charset=utf-8');
            echo '<!DOCTYPE html><html lang="ro"><head><meta charset="UTF-8">';
            echo '<title>404 - Pagina nu a fost gasita | ' . SITE_NAME . '</title>';
            echo '<style>body{font-family:sans-serif;display:flex;justify-content:center;';
            echo 'align-items:center;min-height:100vh;margin:0;background:#f5f5f5;}';
            echo '.container{text-align:center;padding:2rem;}';
            echo 'h1{font-size:6rem;margin:0;color:#1a1a2e;}';
            echo 'p{font-size:1.2rem;color:#666;margin:1rem 0;}';
            echo 'a{color:#e94560;text-decoration:none;font-weight:bold;}';
            echo 'a:hover{text-decoration:underline;}</style></head>';
            echo '<body><div class="container">';
            echo '<h1>404</h1>';
            echo '<p>Ne pare rau, pagina cautata nu a fost gasita.</p>';
            echo '<a href="/">Inapoi la pagina principala</a>';
            echo '</div></body></html>';
        }
    }

    /**
     * Returneaza calea URL curenta
     *
     * @return string Calea URL curenta
     */
    public function getCurrentPath(): string
    {
        return $this->currentPath;
    }

    /**
     * Returneaza metoda HTTP curenta
     *
     * @return string Metoda HTTP (GET, POST)
     */
    public function getCurrentMethod(): string
    {
        return $this->currentMethod;
    }
}
