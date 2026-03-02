<?php
/**
 * Pagina Blog - Articole filtrate pe categorie
 *
 * Variabile disponibile (din BlogController::category):
 * @var string $title       - titlul paginii
 * @var array  $category    - categoria curenta
 * @var array  $posts       - lista articolelor din categorie
 * @var array  $categories  - toate categoriile
 * @var int    $currentPage - pagina curenta
 * @var int    $totalPages  - numarul total de pagini
 * @var int    $totalPosts  - numarul total de articole
 * @var array  $settings    - setarile site-ului
 */
$categoryName = htmlspecialchars($category['name'] ?? $category['name_ro'] ?? '');
$metaDescription = "Articole blog Scanbox.ro din categoria {$categoryName}. Resurse utile despre conținut vizual profesional.";
?>

<?php
$heroType = 'page';
$heroBadge = 'Blog';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/></svg>';
$heroTitle = $categoryName;
$heroSubtitle = "Articole din categoria {$categoryName}";
include __DIR__ . '/../../components/hero.php';
?>

<!-- ===== BLOG CATEGORY SECTION ===== -->
<section class="blog-section" lang="ro">
  <div class="container">

    <?php if (!empty($categories)): ?>
    <div style="display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; margin-bottom: 48px;">
      <a href="/blog" class="btn-sm btn-outline">Toate</a>
      <?php foreach ($categories as $cat): ?>
      <a href="/blog/categorie/<?= htmlspecialchars($cat['slug'] ?? '') ?>" class="btn-sm <?= ($cat['slug'] ?? '') === ($category['slug'] ?? '') ? 'btn-primary' : 'btn-outline' ?>">
        <?= htmlspecialchars($cat['name'] ?? '') ?>
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
          <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:48px;opacity:0.3;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1.5"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
          </div>
          <?php endif; ?>
        </div>
        <div class="blog-card-body">
          <div class="blog-card-date">
            <?= date('d.m.Y', strtotime($post['published_at'] ?? $post['created_at'] ?? 'now')) ?>
          </div>
          <h3><?= htmlspecialchars($post['title'] ?? '') ?></h3>
          <p><?= htmlspecialchars(mb_substr(strip_tags($post['excerpt'] ?? $post['content'] ?? ''), 0, 150)) ?>...</p>
          <span class="service-link">Citește &rarr;</span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>

    <!-- Paginare -->
    <?php
    $baseUrl = '/blog/categorie/' . htmlspecialchars($category['slug'] ?? '');
    include __DIR__ . '/../../components/pagination.php';
    ?>

    <?php else: ?>
    <div style="text-align: center; padding: 80px 0; color: #94A3B8;">
      <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#394E75" stroke-width="1.5" style="margin: 0 auto 16px;display:block;"><path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/></svg>
      <p>Nu există articole în această categorie.</p>
      <a href="/blog" style="color: #04B494; margin-top: 8px; display: inline-block;">Toate articolele &rarr;</a>
    </div>
    <?php endif; ?>

  </div>
</section>
