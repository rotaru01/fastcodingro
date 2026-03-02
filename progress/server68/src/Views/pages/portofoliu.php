<?php
/**
 * Pagina Portofoliu
 *
 * Variabile disponibile (din PageController::portofoliu):
 * @var string $title      - titlul paginii
 * @var array  $categories - categoriile de proiecte
 * @var array  $projects   - lista proiectelor
 * @var string $mapData    - JSON cu datele pentru harta (lat, lng, title)
 * @var array  $settings   - setarile site-ului
 */
$metaDescription = 'Portofoliu Scanbox: tururi virtuale 3D Matterport, fotografie, videografie și proiecte vizuale realizate pentru clienți din diverse industrii.';
?>

<?php
$heroType = 'page';
$heroBadge = 'Portofoliu';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>';
$heroTitle = 'Portofoliu';
$heroSubtitle = 'O selecție din proiectele noastre recente';
include __DIR__ . '/../components/hero.php';
?>

<!-- ===== FILTRU CATEGORII ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%); padding: 60px 0 80px;">
  <div class="container">

    <?php if (!empty($categories)): ?>
    <div style="display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; margin-bottom: 48px;">
      <button class="btn-sm btn-primary portfolio-filter active" data-category="all">Toate</button>
      <?php foreach ($categories as $category): ?>
      <button class="btn-sm btn-outline portfolio-filter" data-category="<?= htmlspecialchars($category['slug'] ?? $category['id'] ?? '') ?>">
        <?= htmlspecialchars($category['name_ro'] ?? $category['name'] ?? '') ?>
      </button>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- ===== PROIECTE GRID ===== -->
    <?php if (!empty($projects)): ?>
    <div class="portfolio-grid" id="portfolioGrid">
      <?php foreach ($projects as $project): ?>
      <div class="portfolio-card" data-category="<?= htmlspecialchars($project['category_slug'] ?? $project['category_id'] ?? '') ?>">
        <div class="portfolio-thumb">
          <?php if (!empty($project['thumbnail'])): ?>
          <img src="<?= htmlspecialchars($project['thumbnail']) ?>" alt="<?= htmlspecialchars($project['title'] ?? '') ?>" loading="lazy">
          <?php else: ?>
          <svg viewBox="0 0 400 300" style="width:100%;height:100%;background:#0D1B2A;">
            <rect width="400" height="300" fill="#0D1B2A"/>
            <text x="200" y="150" text-anchor="middle" dominant-baseline="middle" fill="#1A2B4A" font-size="36" font-family="Inter,sans-serif">SCANBOX</text>
          </svg>
          <?php endif; ?>
        </div>
        <div class="portfolio-info">
          <?php if (!empty($project['category_name'])): ?>
          <span class="portfolio-tag"><?= htmlspecialchars($project['category_name']) ?></span>
          <?php endif; ?>
          <h3><?= htmlspecialchars($project['title'] ?? '') ?></h3>
          <?php if (!empty($project['description'])): ?>
          <p><?= htmlspecialchars(mb_substr($project['description'], 0, 100)) ?></p>
          <?php endif; ?>
          <?php if (!empty($project['matterport_url'])): ?>
          <a href="<?= htmlspecialchars($project['matterport_url']) ?>" class="service-link" target="_blank" rel="noopener">
            Vezi Proiectul
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div style="text-align: center; padding: 60px 0; color: #94A3B8;">
      <p>Portofoliul este în curs de actualizare. Reveniti în curând!</p>
    </div>
    <?php endif; ?>

    <!-- ===== HARTĂ PROIECTE ===== -->
    <?php if (!empty($mapData) && $mapData !== '[]'): ?>
    <div id="projectsMap" style="width: 100%; height: 400px; border-radius: 16px; margin-top: 60px; background: #0D1B2A;"></div>
    <?php endif; ?>

    <!-- ===== LINK REELS ===== -->
    <div style="text-align: center; margin-top: 60px;">
      <a href="/portofoliu-reels" class="btn-outline">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
        Vezi Portofoliu Reels
      </a>
    </div>
  </div>
</section>

<?php if (!empty($mapData) && $mapData !== '[]'): ?>
<?php $extraScripts = '<script>
// Portfolio map initialization placeholder
// Requires Google Maps or Leaflet library
var mapData = ' . $mapData . ';
</script>'; ?>
<?php endif; ?>

<script>
// Portfolio category filter
document.querySelectorAll('.portfolio-filter').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.portfolio-filter').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
    const category = this.dataset.category;
    document.querySelectorAll('.portfolio-card').forEach(card => {
      if (category === 'all' || card.dataset.category === category) {
        card.style.display = '';
      } else {
        card.style.display = 'none';
      }
    });
  });
});
</script>
