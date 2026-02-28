<?php
/**
 * API: Ștergere imagine
 * POST /api/delete-image
 *
 * Parametri:
 *   - id: ID-ul elementului din gallery_items
 *   - csrf_token: token CSRF
 *
 * Returnează JSON cu rezultatul operației
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

// Verificare autentificare
session_start();
if (empty($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Autentificare necesară.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Verificare metodă
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Metoda nu este permisă.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Citire date din JSON sau POST
$input = json_decode(file_get_contents('php://input'), true);
if ($input === null) {
    $input = $_POST;
}

// Verificare CSRF
$csrfToken = $input['csrf_token'] ?? '';
if (empty($csrfToken) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrfToken)) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'Token de securitate invalid.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$itemId = (int) ($input['id'] ?? 0);
if ($itemId <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'ID invalid.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    require_once __DIR__ . '/../config/config.php';
    require_once __DIR__ . '/../config/constants.php';
    require_once __DIR__ . '/../src/Core/Database.php';
    require_once __DIR__ . '/../src/Models/GalleryItem.php';

    $galleryItemModel = new \Scanbox\Models\GalleryItem();

    // Obținere detalii element
    $item = $galleryItemModel->getById($itemId);
    if ($item === null) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Imaginea nu a fost găsită.',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Ștergere fișiere de pe disc
    $uploadsBase = defined('UPLOADS_PATH') ? UPLOADS_PATH : __DIR__ . '/../public/uploads/';
    $uploadsUrl = defined('UPLOADS_URL') ? UPLOADS_URL : '/uploads/';

    $filesToDelete = [];

    if (!empty($item['file_path'])) {
        $relativePath = str_replace($uploadsUrl, '', $item['file_path']);
        $fullPath = $uploadsBase . $relativePath;
        if (file_exists($fullPath)) {
            $filesToDelete[] = $fullPath;
        }
    }

    if (!empty($item['thumbnail'])) {
        $relativePath = str_replace($uploadsUrl, '', $item['thumbnail']);
        $fullPath = $uploadsBase . $relativePath;
        if (file_exists($fullPath)) {
            $filesToDelete[] = $fullPath;
        }
    }

    foreach ($filesToDelete as $filePath) {
        if (is_file($filePath) && is_writable($filePath)) {
            unlink($filePath);
        }
    }

    // Ștergere din baza de date
    $galleryItemModel->delete($itemId);

    echo json_encode([
        'success' => true,
        'message' => 'Imaginea a fost ștearsă cu succes.',
    ], JSON_UNESCAPED_UNICODE);

} catch (\Throwable $e) {
    error_log('Eroare ștergere imagine: ' . $e->getMessage());

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'A apărut o eroare la ștergerea imaginii.',
    ], JSON_UNESCAPED_UNICODE);
}
