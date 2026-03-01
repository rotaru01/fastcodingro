<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "PHP " . phpversion() . "<br><br>";

echo "1. Loading config... ";
require_once __DIR__ . '/../config/config.php';
echo "OK<br>";

echo "2. Loading constants... ";
require_once __DIR__ . '/../config/constants.php';
echo "OK<br>";

echo "3. Loading database class... ";
require_once __DIR__ . '/../config/database.php';
echo "OK<br>";

echo "4. Testing DB connection... ";
try {
    $pdo = DatabaseConnection::getInstance();
    echo "OK - Connected!<br>";
} catch (Exception $e) {
    echo "FAILED: " . $e->getMessage() . "<br>";
}

echo "5. Loading Session class... ";
require_once __DIR__ . '/../src/Core/Session.php';
echo "OK<br>";

echo "6. Loading Router class... ";
require_once __DIR__ . '/../src/Core/Router.php';
echo "OK<br>";

echo "<br>All good!";
