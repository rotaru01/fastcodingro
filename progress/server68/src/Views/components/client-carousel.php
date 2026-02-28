<?php
/**
 * Componenta Client Logo Carousel
 *
 * Variabile disponibile:
 * @var array $clientLogos - array de logo-uri client, fiecare cu:
 *   'name'  - numele clientului
 *   'image' - URL imagine logo (optional)
 *   'url'   - link catre site-ul clientului (optional)
 */
$clientLogos = $clientLogos ?? [];
?>

<?php if (!empty($clientLogos)): ?>
<!-- ===== CLIENT LOGOS CAROUSEL ===== -->
<section class="logos-section">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        Clienți și Parteneri
      </span>
    </div>
  </div>
  <div class="logos-track">
    <?php
    // Duplicam logo-urile pentru efect infinite scroll
    $allLogos = array_merge($clientLogos, $clientLogos);
    foreach ($allLogos as $logo):
    ?>
    <div class="logo-placeholder">
      <?php if (!empty($logo['image'])): ?>
        <?php if (!empty($logo['url'])): ?>
        <a href="<?= htmlspecialchars($logo['url']) ?>" target="_blank" rel="noopener">
          <img src="<?= htmlspecialchars($logo['image']) ?>" alt="<?= htmlspecialchars($logo['name'] ?? '') ?>" loading="lazy">
        </a>
        <?php else: ?>
        <img src="<?= htmlspecialchars($logo['image']) ?>" alt="<?= htmlspecialchars($logo['name'] ?? '') ?>" loading="lazy">
        <?php endif; ?>
      <?php else: ?>
      <span><?= htmlspecialchars($logo['name'] ?? '') ?></span>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>
