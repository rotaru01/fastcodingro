<?php
/**
 * Script temporar - resetare parola administrator
 * STERGE ACEST FISIER DUPA UTILIZARE!
 */

// Incarca configuratia bazei de date
require_once __DIR__ . '/../config/config.php';

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $password = 'ScanboxAdmin2024!';
    $hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("UPDATE admins SET password_hash = ? WHERE email = 'office@scanbox.ro'");
    $stmt->execute([$hash]);

    echo "<h2>Parola resetata cu succes!</h2>";
    echo "<p><strong>Email:</strong> office@scanbox.ro</p>";
    echo "<p><strong>Parola:</strong> {$password}</p>";
    echo "<p><strong>Hash nou (bcrypt):</strong> {$hash}</p>";
    echo "<p>Rows affected: " . $stmt->rowCount() . "</p>";
    echo "<br><p style='color:red; font-weight:bold;'>STERGE ACEST FISIER IMEDIAT! (/reset-admin-pw.php)</p>";
    echo "<p><a href='/admin/login'>Mergi la login</a></p>";

} catch (Exception $e) {
    echo "<h2>Eroare:</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
