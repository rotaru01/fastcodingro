<?php
/**
 * API: Reordonare elemente
 * POST /api/reorder
 *
 * Parametri JSON:
 *   - type: 'gallery' | 'testimonial' | 'client'
 *   - items: [{id, order}, ...]
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

// Citire date JSON
$input = json_decode(file_get_contents('php://input'), true);
if ($input === null) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Date JSON invalide.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
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

$type = $input['type'] ?? '';
$items = $input['items'] ?? [];

if (empty($type) || !is_array($items) || empty($items)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Parametri lipsă sau invalizi.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Validare tip
$allowedTypes = ['gallery', 'testimonial', 'client'];
if (!in_array($type, $allowedTypes, true)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Tip de element invalid.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    require_once __DIR__ . '/../config/config.php';
    require_once __DIR__ . '/../config/constants.php';
    require_once __DIR__ . '/../src/Core/Database.php';

    $db = \Scanbox\Core\Database::getInstance();

    // Determinare tabel
    $table = match ($type) {
        'gallery'     => 'gallery_items',
        'testimonial' => 'testimonials',
        'client'      => 'client_logos',
    };

    // Actualizare sort_order
    foreach ($items as $item) {
        $id = (int) ($item['id'] ?? 0);
        $order = (int) ($item['order'] ?? 0);

        if ($id > 0) {
            $db->update($table, ['sort_order' => $order], 'id = ?', [$id]);
        }
    }

    echo json_encode([
        'success' => true,
        'message' => 'Ordinea a fost actualizată cu succes.',
    ], JSON_UNESCAPED_UNICODE);

} catch (\Throwable $e) {
    error_log('Eroare reordonare: ' . $e->getMessage());

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'A apărut o eroare la actualizarea ordinii.',
    ], JSON_UNESCAPED_UNICODE);
}
