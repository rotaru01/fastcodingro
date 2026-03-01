<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "PHP " . phpversion() . "<br><br>";

define('APP_START_TIME', microtime(true));
define('BASE_PATH', dirname(__DIR__));

echo "1. Loading config... ";
require_once BASE_PATH . '/config/config.php';
echo "OK<br>";

echo "2. Loading constants... ";
require_once BASE_PATH . '/config/constants.php';
echo "OK<br>";

echo "3. Loading database... ";
require_once BASE_PATH . '/config/database.php';
echo "OK<br>";

echo "4. Setting up autoloader... ";
spl_autoload_register(function (string $className): void {
    $prefix = 'Scanbox\\';
    $prefixLength = strlen($prefix);
    if (strncmp($className, $prefix, $prefixLength) !== 0) {
        return;
    }
    $relativeClass = substr($className, $prefixLength);
    $filePath = BASE_PATH . '/src/' . str_replace('\\', '/', $relativeClass) . '.php';
    echo "[autoload: $className -> $filePath exists=" . (file_exists($filePath) ? 'yes' : 'NO') . "] ";
    if (file_exists($filePath)) {
        require_once $filePath;
    }
});
echo "OK<br>";

echo "5. Starting session... ";
try {
    \Scanbox\Core\Session::start();
    echo "OK<br>";
} catch (Throwable $e) {
    echo "FAILED: " . $e->getMessage() . "<br>";
}

echo "6. Creating router... ";
try {
    $router = new \Scanbox\Core\Router();
    echo "OK<br>";
} catch (Throwable $e) {
    echo "FAILED: " . $e->getMessage() . "<br>";
}

echo "7. Dispatching... ";
try {
    $router->dispatch();
    echo "<br>OK<br>";
} catch (Throwable $e) {
    echo "FAILED: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
