<?php
/**
 * Pagina generica serviciu - dispatch catre view-ul specific
 *
 * Variabile disponibile (din PageController::servicii):
 * @var string $title        - titlul paginii
 * @var array  $service      - datele serviciului din DB
 * @var array  $gallery      - galeria asociata
 * @var array  $galleryItems - elementele galeriei
 * @var array  $pricing      - pachetele de pret
 * @var array  $settings     - setarile site-ului
 */

$slug = $service['slug'] ?? '';

// Mapare slug -> view specific
$viewMap = [
    'tur-virtual-3d'    => __DIR__ . '/tur-virtual-3d.php',
    'fotografie'        => __DIR__ . '/fotografie.php',
    'videografie-drone' => __DIR__ . '/videografie-drone.php',
    'randare-3d'        => __DIR__ . '/randare-3d.php',
    'social-media'      => __DIR__ . '/social-media.php',
];

if (isset($viewMap[$slug]) && file_exists($viewMap[$slug])) {
    include $viewMap[$slug];
} else {
    // Fallback - afisare generica serviciu din DB
    ?>

    <?php
    $heroType = 'page';
    $heroBadge = $service['category'] ?? 'Serviciu';
    $heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>';
    $heroTitle = htmlspecialchars($service['title'] ?? '');
    $heroSubtitle = htmlspecialchars($service['short_description'] ?? '');
    include __DIR__ . '/../../components/hero.php';
    ?>

    <!-- ===== CONTINUT SERVICIU ===== -->
    <section class="content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%); padding: 80px 0;">
      <div class="container">
        <?php if (!empty($service['content'])): ?>
        <div class="content-text" style="max-width: 800px; margin: 0 auto;">
          <?= $service['content'] ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($service['description'])): ?>
        <div class="content-text" style="max-width: 800px; margin: 0 auto;">
          <p><?= nl2br(htmlspecialchars($service['description'])) ?></p>
        </div>
        <?php endif; ?>
      </div>
    </section>

    <!-- ===== GALERIE ===== -->
    <?php if (!empty($galleryItems)): ?>
    <section class="content-section" style="padding: 80px 0;">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">Galerie</h2>
        </div>
        <?php include __DIR__ . '/../../components/gallery-grid.php'; ?>
      </div>
    </section>
    <?php endif; ?>

    <!-- ===== PRICING ===== -->
    <?php if (!empty($pricing)):
        $pricingTitle = 'Pachete & Prețuri';
        $pricingSubtitle = '';
        include __DIR__ . '/../../components/pricing-table.php';
    endif;
}
?>
