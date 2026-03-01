<?php
/**
 * Scanbox.ro - Functii helper globale
 *
 * @package Scanbox
 * @version 1.0.0
 */

declare(strict_types=1);

/**
 * Randeaza un view cu date, wrapat in layout
 *
 * @param string $viewName Calea relativa a view-ului (ex: 'pages/home')
 * @param array $data Variabilele disponibile in view
 * @param string|null $layout Layout-ul de folosit (null = 'layout/layout', false = fara layout)
 * @return void
 */
function view(string $viewName, array $data = [], ?string $layout = 'layout/layout'): void
{
    extract($data);

    $viewFile = BASE_PATH . '/src/Views/' . $viewName . '.php';

    if (!file_exists($viewFile)) {
        error_log(sprintf('[%s] View inexistent: %s', date('Y-m-d H:i:s'), $viewFile));
        http_response_code(500);
        echo 'View not found: ' . htmlspecialchars($viewName);
        return;
    }

    if ($layout !== null) {
        $layoutFile = BASE_PATH . '/src/Views/' . $layout . '.php';

        if (file_exists($layoutFile)) {
            // Randam view-ul in buffer
            ob_start();
            require $viewFile;
            $content = ob_get_clean();

            // Randam layout-ul cu $content
            require $layoutFile;
            return;
        }
    }

    // Fara layout - randam direct
    require $viewFile;
}
