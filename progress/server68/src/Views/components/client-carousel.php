<?php
/**
 * Componenta Client Logo Carousel
 */
$clientLogos = $clientLogos ?? [];

// Fallback logo-uri daca nu sunt in DB
if (empty($clientLogos)) {
    $clientLogos = [
        ['name' => 'Cordia'],
        ['name' => 'Lidl'],
        ['name' => 'Kaufland'],
        ['name' => 'Dedeman'],
        ['name' => 'Renault'],
        ['name' => 'Carrefour'],
        ['name' => 'Orange'],
        ['name' => 'Vodafone'],
        ['name' => 'ING Bank'],
        ['name' => 'BCR'],
        ['name' => 'Mega Image'],
        ['name' => 'Decathlon'],
    ];
}
?>

<!-- ===== CLIENT LOGOS CAROUSEL ===== -->
<section class="logos-section">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Parteneri</span>
      <h2 class="section-title">Am Colaborat cu Branduri de Top</h2>
    </div>
  </div>
  <div class="logos-track-wrapper">
    <div class="logos-track" id="logosTrack">
      <?php
      // Duplicam logo-urile pentru efect infinite scroll
      $allLogos = array_merge($clientLogos, $clientLogos);
      foreach ($allLogos as $logo):
      ?>
      <div class="logo-placeholder">
        <?php $logoImg = $logo['logo_path'] ?? $logo['image'] ?? ''; ?>
        <?php if (!empty($logoImg)): ?>
          <?php $logoUrl = $logo['website_url'] ?? $logo['url'] ?? ''; ?>
          <?php if (!empty($logoUrl)): ?>
          <a href="<?= htmlspecialchars($logoUrl) ?>" target="_blank" rel="noopener">
            <img src="<?= htmlspecialchars($logoImg) ?>" alt="<?= htmlspecialchars($logo['name'] ?? '') ?>" loading="lazy">
          </a>
          <?php else: ?>
          <img src="<?= htmlspecialchars($logoImg) ?>" alt="<?= htmlspecialchars($logo['name'] ?? '') ?>" loading="lazy">
          <?php endif; ?>
        <?php else: ?>
        <?= htmlspecialchars($logo['name'] ?? '') ?>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
