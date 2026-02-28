<?php
/**
 * Componenta Pricing Table
 *
 * Variabile disponibile:
 * @var array $pricing - array de pachete de preturi, fiecare cu:
 *   'name'        - numele pachetului
 *   'price'       - pretul (ex: '250')
 *   'currency'    - moneda (default: 'EUR')
 *   'period'      - perioada (default: '/ lună')
 *   'vat_note'    - nota TVA (default: '+ TVA')
 *   'features'    - array de features (string)
 *   'is_featured' - boolean, daca este pachetul recomandat
 *   'cta_text'    - textul butonului CTA (default: 'Solicită Ofertă')
 *   'cta_link'    - link-ul butonului CTA (default: '/contact')
 * @var string $pricingTitle    - titlul sectiunii (optional)
 * @var string $pricingSubtitle - subtitlul sectiunii (optional)
 */
$pricing = $pricing ?? [];
$pricingTitle = $pricingTitle ?? '';
$pricingSubtitle = $pricingSubtitle ?? '';
?>

<?php if (!empty($pricing)): ?>
<!-- ===== PRICING SECTION ===== -->
<section class="pricing-section content-section">
  <div class="container">
    <?php if ($pricingTitle): ?>
    <div class="section-header">
      <h2 class="section-title"><?= htmlspecialchars($pricingTitle) ?></h2>
      <?php if ($pricingSubtitle): ?>
      <p class="section-subtitle"><?= htmlspecialchars($pricingSubtitle) ?></p>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="pricing-grid">
      <?php foreach ($pricing as $package): ?>
      <div class="pricing-card<?= !empty($package['is_featured']) ? ' featured' : '' ?>">
        <?php if (!empty($package['is_featured'])): ?>
        <div class="pricing-badge">Recomandat</div>
        <?php endif; ?>
        <h3><?= htmlspecialchars($package['name'] ?? '') ?></h3>
        <div class="pricing-price">
          <span class="pricing-amount"><?= htmlspecialchars($package['price'] ?? '0') ?></span>
          <span class="pricing-currency"><?= htmlspecialchars($package['currency'] ?? 'EUR') ?></span>
          <span class="pricing-period"><?= htmlspecialchars($package['period'] ?? '/ lună') ?></span>
        </div>
        <?php if (!empty($package['vat_note'])): ?>
        <div class="pricing-vat"><?= htmlspecialchars($package['vat_note']) ?></div>
        <?php endif; ?>

        <?php if (!empty($package['features'])): ?>
        <ul class="pricing-features">
          <?php foreach ($package['features'] as $feature): ?>
          <li>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            <?= htmlspecialchars($feature) ?>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <a href="<?= htmlspecialchars($package['cta_link'] ?? '/contact') ?>" class="<?= !empty($package['is_featured']) ? 'btn-primary' : 'btn-outline' ?>">
          <?= htmlspecialchars($package['cta_text'] ?? 'Solicită Ofertă') ?>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
