<?php
/**
 * Pagina Blog - Lista articole
 *
 * Variabile disponibile (din BlogController::index):
 * @var string $title       - titlul paginii
 * @var array  $posts       - lista articolelor
 * @var array  $categories  - categoriile cu numar de articole
 * @var int    $currentPage - pagina curenta
 * @var int    $totalPages  - numarul total de pagini
 * @var int    $totalPosts  - numarul total de articole
 * @var array  $settings    - setarile site-ului
 */
$metaDescription = 'Blogul Scanbox: sfaturi, studii de caz și noutăți din lumea conținutului vizual, tururilor virtuale 3D și social media.';
?>

<?php
$heroType = 'page';
$heroBadge = 'Blog';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/></svg>';
$heroTitle = 'Blog';
$heroSubtitle = 'Sfaturi, studii de caz și noutăți din lumea conținutului vizual';
include __DIR__ . '/../../components/hero.php';
?>

<!-- ===== BLOG GRID ===== -->
<section class="blog-section content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%); padding: 80px 0;">
  <div class="container">

    <?php if (!empty($categories)): ?>
    <div style="display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; margin-bottom: 48px;">
      <a href="/blog" class="btn-sm <?= empty($_GET['category']) ? 'btn-primary' : 'btn-outline' ?>">Toate</a>
      <?php foreach ($categories as $cat): ?>
      <a href="/blog/categorie/<?= htmlspecialchars($cat['slug'] ?? '') ?>" class="btn-sm btn-outline">
        <?= htmlspecialchars($cat['name'] ?? '') ?>
        <?php if (!empty($cat['post_count'])): ?>
        <span style="opacity: 0.6;">(<?= (int) $cat['post_count'] ?>)</span>
        <?php endif; ?>
      </a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($posts)): ?>
    <div class="blog-grid">
      <?php foreach ($posts as $post): ?>
      <a href="/blog/<?= htmlspecialchars($post['slug'] ?? '') ?>" class="blog-card">
        <div class="blog-card-thumb">
          <?php if (!empty($post['featured_image'])): ?>
          <img src="<?= htmlspecialchars($post['featured_image']) ?>" alt="<?= htmlspecialchars($post['title'] ?? '') ?>" loading="lazy">
          <?php else: ?>
          <svg viewBox="0 0 400 250" style="width:100%;background:linear-gradient(135deg,#1A2B4A,#283868);">
            <rect width="400" height="250" fill="url(#grad)"/>
            <text x="200" y="125" text-anchor="middle" dominant-baseline="middle" fill="#394E75" font-size="24" font-family="Inter,sans-serif">SCANBOX</text>
          </svg>
          <?php endif; ?>
        </div>
        <div class="blog-card-body">
          <div class="blog-card-date">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <?= date('d.m.Y', strtotime($post['published_at'] ?? $post['created_at'] ?? 'now')) ?>
          </div>
          <h3><?= htmlspecialchars($post['title'] ?? '') ?></h3>
          <p><?= htmlspecialchars(mb_substr(strip_tags($post['excerpt'] ?? $post['content'] ?? ''), 0, 150)) ?>...</p>
          <span class="service-link">
            Citește
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>

    <!-- Paginare -->
    <?php
    $baseUrl = '/blog';
    include __DIR__ . '/../../components/pagination.php';
    ?>

    <?php else: ?>
    <div style="text-align: center; padding: 60px 0; color: #94A3B8;">
      <p>Nu există articole încă. Reveniți în curând!</p>
    </div>
    <?php endif; ?>

  </div>
</section>
