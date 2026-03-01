<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

define('APP_START_TIME', microtime(true));
define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/config/constants.php';
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/config/helpers.php';

spl_autoload_register(function (string $className): void {
    $prefix = 'Scanbox\\';
    $prefixLength = strlen($prefix);
    if (strncmp($className, $prefix, $prefixLength) !== 0) {
        return;
    }
    $relativeClass = substr($className, $prefixLength);
    $filePath = BASE_PATH . '/src/' . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($filePath)) {
        require_once $filePath;
    }
});

echo "<pre>";
echo "Testing home page controller...\n\n";

try {
    $controller = new \Scanbox\Controllers\PageController();
    echo "Controller created OK\n";
    $controller->home();
} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    echo $e->getTraceAsString();
}
