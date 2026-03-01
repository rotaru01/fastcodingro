<?php
/**
 * Componenta CTA Banner
 *
 * Variabile disponibile:
 * @var string $ctaTitle    - titlul CTA (default: 'Ai un proiect? Hai să vorbim!')
 * @var string $ctaText     - textul CTA
 * @var string $ctaButton   - textul butonului (default: 'Contactează-ne Acum')
 * @var string $ctaLink     - link-ul butonului (default: '/contact')
 * @var bool   $ctaHidden   - ascunde CTA-ul (pentru pagini fara CTA)
 */
$ctaTitle = $ctaTitle ?? 'Ai un proiect? Hai să vorbim!';
$ctaText = $ctaText ?? 'Solicită o ofertă personalizată și descoperă cum putem transforma vizual afacerea ta.';
$ctaButton = $ctaButton ?? 'Contactează-ne Acum';
$ctaLink = $ctaLink ?? '/contact';
$ctaHidden = $ctaHidden ?? false;
?>

<?php if (!$ctaHidden): ?>
<!-- ===== CTA SECTION ===== -->
<section class="cta-section" id="cta">
  <div class="container">
    <div class="cta-banner">
      <h2><?= htmlspecialchars($ctaTitle) ?></h2>
      <p><?= htmlspecialchars($ctaText) ?></p>
      <a href="<?= htmlspecialchars($ctaLink) ?>" class="btn-white">
        <?= htmlspecialchars($ctaButton) ?>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>
</section>
<?php endif; ?>
