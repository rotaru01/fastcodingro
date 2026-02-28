<?php
/**
 * Sitemap XML Dinamic — Scanbox.ro
 * Genereaza sitemap.xml cu toate paginile publice, blog si portofoliu
 */

header('Content-Type: application/xml; charset=utf-8');

$baseUrl = 'https://scanbox.ro';
$today = date('Y-m-d');

// Pagini statice cu prioritate si frecventa
$staticPages = [
    ['url' => '/',                          'priority' => '1.0', 'changefreq' => 'weekly'],
    ['url' => '/servicii/tur-virtual-3d',   'priority' => '0.9', 'changefreq' => 'monthly'],
    ['url' => '/servicii/fotografie',       'priority' => '0.9', 'changefreq' => 'monthly'],
    ['url' => '/servicii/videografie-drone', 'priority' => '0.9', 'changefreq' => 'monthly'],
    ['url' => '/servicii/randare-3d',       'priority' => '0.9', 'changefreq' => 'monthly'],
    ['url' => '/servicii/social-media',     'priority' => '0.9', 'changefreq' => 'monthly'],
    ['url' => '/sport-content',             'priority' => '0.8', 'changefreq' => 'monthly'],
    ['url' => '/portofoliu',                'priority' => '0.8', 'changefreq' => 'weekly'],
    ['url' => '/portofoliu-reels',          'priority' => '0.7', 'changefreq' => 'weekly'],
    ['url' => '/blog',                      'priority' => '0.8', 'changefreq' => 'weekly'],
    ['url' => '/contact',                   'priority' => '0.7', 'changefreq' => 'monthly'],
    ['url' => '/despre-noi',                'priority' => '0.6', 'changefreq' => 'monthly'],
    ['url' => '/legal/prelucrarea-datelor',  'priority' => '0.3', 'changefreq' => 'yearly'],
    ['url' => '/legal/politica-cookies',     'priority' => '0.3', 'changefreq' => 'yearly'],
];

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

<?php foreach ($staticPages as $page): ?>
  <url>
    <loc><?= $baseUrl . $page['url'] ?></loc>
    <lastmod><?= $today ?></lastmod>
    <changefreq><?= $page['changefreq'] ?></changefreq>
    <priority><?= $page['priority'] ?></priority>
  </url>
<?php endforeach; ?>

<?php
// Blog posts din baza de date (daca e disponibila)
try {
    require_once __DIR__ . '/../config/config.php';
    require_once __DIR__ . '/../config/database.php';
    $pdo = DatabaseConnection::getInstance();
    $stmt = $pdo->query("SELECT slug, updated_at FROM blog_posts WHERE status = 'published' ORDER BY published_at DESC");
    while ($post = $stmt->fetch(PDO::FETCH_ASSOC)):
?>
  <url>
    <loc><?= $baseUrl ?>/blog/<?= htmlspecialchars($post['slug']) ?></loc>
    <lastmod><?= date('Y-m-d', strtotime($post['updated_at'])) ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.6</priority>
  </url>
<?php
    endwhile;
} catch (Exception $e) {
    // Baza de date nu e disponibila — generam doar paginile statice
}

// Proiecte portofoliu
try {
    $stmt = $pdo->query("SELECT slug, updated_at FROM portfolio_projects WHERE is_active = 1 ORDER BY created_at DESC");
    while ($project = $stmt->fetch(PDO::FETCH_ASSOC)):
?>
  <url>
    <loc><?= $baseUrl ?>/portofoliu/<?= htmlspecialchars($project['slug']) ?></loc>
    <lastmod><?= date('Y-m-d', strtotime($project['updated_at'])) ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.5</priority>
  </url>
<?php
    endwhile;
} catch (Exception $e) {
    // Skip
}
?>

</urlset>
