<?php
/**
 * API: Statistici dashboard (autentificare necesară)
 * GET /api/stats
 *
 * Returnează JSON cu statistici:
 *   - mesaje necitite
 *   - total proiecte
 *   - total articole blog
 *   - total imagini galerie
 *   - ultimele 5 mesaje
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
    require_once __DIR__ . '/../src/Models/Message.php';
    require_once __DIR__ . '/../src/Models/BlogPost.php';
    require_once __DIR__ . '/../src/Models/GalleryItem.php';

    $db = \Scanbox\Core\Database::getInstance();
    $messageModel = new \Scanbox\Models\Message();
    $blogModel = new \Scanbox\Models\BlogPost();

    // Mesaje necitite
    $unreadMessages = $messageModel->countUnread();

    // Total proiecte
    $projectsResult = $db->fetch("SELECT COUNT(*) as total FROM portfolio_projects WHERE is_active = 1");
    $totalProjects = (int) ($projectsResult['total'] ?? 0);

    // Total articole
    $totalPosts = $blogModel->countAll();

    // Total imagini galerie
    $galleryResult = $db->fetch("SELECT COUNT(*) as total FROM gallery_items WHERE is_active = 1");
    $totalGalleryImages = (int) ($galleryResult['total'] ?? 0);

    // Ultimele 5 mesaje
    $recentMessages = $messageModel->getRecent(5);
    $formattedMessages = [];
    foreach ($recentMessages as $msg) {
        $formattedMessages[] = [
            'id'         => (int) $msg['id'],
            'name'       => $msg['name'],
            'email'      => $msg['email'],
            'subject'    => $msg['subject'] ?? '',
            'status'     => $msg['status'],
            'created_at' => $msg['created_at'],
        ];
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'unread_messages'      => $unreadMessages,
            'total_projects'       => $totalProjects,
            'total_posts'          => $totalPosts,
            'total_gallery_images' => $totalGalleryImages,
            'recent_messages'      => $formattedMessages,
        ],
    ], JSON_UNESCAPED_UNICODE);

} catch (\Throwable $e) {
    error_log('Eroare API stats: ' . $e->getMessage());

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'A apărut o eroare la încărcarea statisticilor.',
    ], JSON_UNESCAPED_UNICODE);
}
