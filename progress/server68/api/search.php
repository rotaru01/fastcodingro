<?php
/**
 * API: Căutare (endpoint public)
 * GET /api/search?q=termen
 *
 * Parametri GET:
 *   - q: termenul de căutare (minim 2 caractere)
 *
 * Caută în:
 *   - blog_posts (title, content) - doar publicate
 *   - services (title_ro, description_ro) - doar active
 *
 * Returnează JSON cu rezultatele căutării
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Metoda nu este permisă.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$query = trim($_GET['q'] ?? '');

if (mb_strlen($query) < 2) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Termenul de căutare trebuie să aibă cel puțin 2 caractere.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Limitare lungime query
if (mb_strlen($query) > 100) {
    $query = mb_substr($query, 0, 100);
}

try {
    require_once __DIR__ . '/../config/config.php';
    require_once __DIR__ . '/../config/constants.php';
    require_once __DIR__ . '/../src/Core/Database.php';

    $db = \Scanbox\Core\Database::getInstance();
    $searchTerm = '%' . $query . '%';

    $results = [];

    // Căutare articole blog
    $blogResults = $db->fetchAll(
        "SELECT id, title, slug, excerpt, published_at, 'blog' as result_type
         FROM blog_posts
         WHERE status = 'published'
           AND published_at <= NOW()
           AND (title LIKE ? OR content LIKE ? OR excerpt LIKE ? OR tags LIKE ?)
         ORDER BY published_at DESC
         LIMIT 10",
        [$searchTerm, $searchTerm, $searchTerm, $searchTerm]
    );

    foreach ($blogResults as $post) {
        $results[] = [
            'type'    => 'blog',
            'id'      => (int) $post['id'],
            'title'   => $post['title'],
            'url'     => '/blog/' . $post['slug'],
            'excerpt' => $post['excerpt'] ?? '',
            'date'    => $post['published_at'],
        ];
    }

    // Căutare servicii
    $serviceResults = $db->fetchAll(
        "SELECT id, title_ro, slug, description_ro, 'service' as result_type
         FROM services
         WHERE is_active = 1
           AND (title_ro LIKE ? OR description_ro LIKE ?)
         ORDER BY sort_order ASC
         LIMIT 10",
        [$searchTerm, $searchTerm]
    );

    foreach ($serviceResults as $service) {
        $results[] = [
            'type'    => 'service',
            'id'      => (int) $service['id'],
            'title'   => $service['title_ro'],
            'url'     => '/servicii/' . $service['slug'],
            'excerpt' => mb_substr($service['description_ro'] ?? '', 0, 200),
        ];
    }

    // Căutare proiecte portofoliu
    $portfolioResults = $db->fetchAll(
        "SELECT id, title, slug, city, 'portfolio' as result_type
         FROM portfolio_projects
         WHERE is_active = 1
           AND (title LIKE ? OR description LIKE ? OR city LIKE ?)
         ORDER BY sort_order ASC
         LIMIT 10",
        [$searchTerm, $searchTerm, $searchTerm]
    );

    foreach ($portfolioResults as $project) {
        $results[] = [
            'type'  => 'portfolio',
            'id'    => (int) $project['id'],
            'title' => $project['title'],
            'url'   => '/portofoliu/' . $project['slug'],
            'city'  => $project['city'] ?? '',
        ];
    }

    echo json_encode([
        'success' => true,
        'query'   => $query,
        'results' => $results,
        'count'   => count($results),
    ], JSON_UNESCAPED_UNICODE);

} catch (\Throwable $e) {
    error_log('Eroare API search: ' . $e->getMessage());

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'A apărut o eroare la căutare.',
    ], JSON_UNESCAPED_UNICODE);
}
