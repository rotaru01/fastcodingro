<?php
/**
 * API: Date hartă portofoliu (endpoint public)
 * GET /api/map-data
 *
 * Parametri GET:
 *   - category: (opțional) filtru pe categorie
 *
 * Returnează JSON cu proiecte active care au coordonate GPS
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Cache-Control: public, max-age=300');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Metoda nu este permisă.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    require_once __DIR__ . '/../config/config.php';
    require_once __DIR__ . '/../config/constants.php';
    require_once __DIR__ . '/../src/Core/Database.php';
    require_once __DIR__ . '/../src/Models/Project.php';

    $projectModel = new \Scanbox\Models\Project();

    // Filtru categorie opțional
    $category = isset($_GET['category']) ? (int) $_GET['category'] : null;

    $projects = $projectModel->getForMap($category);

    // Formatare date pentru hartă
    $mapData = [];
    foreach ($projects as $project) {
        $mapData[] = [
            'id'             => (int) $project['id'],
            'title'          => $project['title'],
            'category'       => $project['category_id'] ?? null,
            'city'           => $project['city'] ?? '',
            'lat'            => (float) $project['latitude'],
            'lng'            => (float) $project['longitude'],
            'thumbnail'      => $project['thumbnail'] ?? '',
            'matterport_url' => $project['matterport_url'] ?? '',
        ];
    }

    echo json_encode([
        'success' => true,
        'data'    => $mapData,
        'count'   => count($mapData),
    ], JSON_UNESCAPED_UNICODE);

} catch (\Throwable $e) {
    error_log('Eroare API map-data: ' . $e->getMessage());

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'A apărut o eroare la încărcarea datelor.',
    ], JSON_UNESCAPED_UNICODE);
}
