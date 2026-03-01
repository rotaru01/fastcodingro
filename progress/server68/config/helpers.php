<?php
/**
 * Scanbox.ro - Functii helper globale
 *
 * @package Scanbox
 * @version 1.0.0
 */

declare(strict_types=1);

/**
 * Randeaza un view cu date
 *
 * @param string $viewName Calea relativa a view-ului (ex: 'pages/home')
 * @param array $data Variabilele disponibile in view
 * @return void
 */
function view(string $viewName, array $data = []): void
{
    extract($data);

    $viewFile = BASE_PATH . '/src/Views/' . $viewName . '.php';

    if (!file_exists($viewFile)) {
        error_log(sprintf('[%s] View inexistent: %s', date('Y-m-d H:i:s'), $viewFile));
        http_response_code(500);
        echo 'View not found: ' . htmlspecialchars($viewName);
        return;
    }

    require $viewFile;
}
