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
$metaDescription = 'Blogul Scanbox.ro — articole despre tururi virtuale 3D Matterport, fotografie profesională, videografie drone și conținut vizual B2B. Ghiduri și studii de caz.';
$schemaJsonLd = '
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Blog",
  "name": "Blogul Scanbox.ro",
  "description": "Articole și resurse utile despre conținut vizual profesional, tururi virtuale 3D, fotografie și videografie.",
  "url": "https://scanbox.ro/blog",
  "publisher": {
    "@type": "Organization",
    "name": "Scanbox.ro",
    "legalName": "TRIVIT SERVICES S.R.L.",
    "url": "https://scanbox.ro"
  }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type": "ListItem", "position": 1, "name": "Acasă", "item": "https://scanbox.ro"},
    {"@type": "ListItem", "position": 2, "name": "Blog", "item": "https://scanbox.ro/blog"}
  ]
}
</script>
';
?>

<?php
$heroType = 'page';
$heroBadge = 'Blog';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/></svg>';
$heroTitle = 'Blog';
$heroSubtitle = 'Articole și resurse utile despre conținut vizual profesional';
include __DIR__ . '/../../components/hero.php';
?>

<!-- ===== BLOG SECTION ===== -->
<section class="blog-section" lang="ro">
  <div class="container">
    <p style="border-left: 3px solid #04B494; padding-left: 16px; color: #CBD5E1; font-size: 15px; line-height: 1.8; margin: 0 0 40px 0;">
      Blogul Scanbox.ro oferă articole utile despre tururi virtuale 3D Matterport, fotografie profesională, videografie cu dronă și conținut vizual B2B. Ghiduri practice, studii de caz și noutăți din industria vizuală profesională din România.
    </p>

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
    $baseUrl = '/blog';
    include __DIR__ . '/../../components/pagination.php';
    ?>

    <?php else: ?>
    <div style="text-align: center; padding: 80px 0; color: #94A3B8;">
      <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#394E75" stroke-width="1.5" style="margin: 0 auto 16px;display:block;"><path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/></svg>
      <p>Nu există articole publicate momentan.</p>
    </div>
    <?php endif; ?>

  </div>
</section>
