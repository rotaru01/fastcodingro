<?php
/**
 * Componenta Testimonial Slider
 *
 * Variabile disponibile:
 * @var array $testimonials - array de testimoniale, fiecare cu:
 *   'text'    - textul testimonialului
 *   'name'    - numele persoanei
 *   'role'    - rolul/pozitia
 *   'company' - compania
 *   'avatar'  - URL imagine avatar (optional)
 *   'rating'  - rating 1-5 (optional)
 */
$testimonials = $testimonials ?? [];
?>

<?php if (!empty($testimonials)): ?>
<!-- ===== TESTIMONIAL SLIDER ===== -->
<section class="testimonial-section content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%);">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        Ce Spun Clienții
      </span>
      <h2 class="section-title">Testimoniale</h2>
      <p class="section-subtitle">Feedback-ul clienților noștri ne motivează să oferim calitate superioară în fiecare proiect.</p>
    </div>

    <div class="testimonials-slider">
      <?php foreach ($testimonials as $index => $testimonial): ?>
      <div class="testimonial-slide<?= $index === 0 ? ' active' : '' ?>">
        <div class="testimonial-content">
          <div class="testimonial-quote-mark">"</div>
          <p class="testimonial-text"><?= htmlspecialchars($testimonial['text'] ?? '') ?></p>
          <div class="testimonial-author">
            <div class="testimonial-avatar">
              <?php if (!empty($testimonial['avatar'])): ?>
              <img src="<?= htmlspecialchars($testimonial['avatar']) ?>" alt="<?= htmlspecialchars($testimonial['name'] ?? '') ?>" loading="lazy">
              <?php else: ?>
              <?= mb_strtoupper(mb_substr($testimonial['name'] ?? 'A', 0, 1)) ?>
              <?php endif; ?>
            </div>
            <div>
              <strong><?= htmlspecialchars($testimonial['name'] ?? '') ?></strong>
              <?php if (!empty($testimonial['role']) || !empty($testimonial['company'])): ?>
              <span>
                <?= htmlspecialchars($testimonial['role'] ?? '') ?>
                <?php if (!empty($testimonial['role']) && !empty($testimonial['company'])): ?>, <?php endif; ?>
                <?= htmlspecialchars($testimonial['company'] ?? '') ?>
              </span>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <?php if (count($testimonials) > 1): ?>
    <div class="testimonials-dots">
      <?php foreach ($testimonials as $index => $testimonial): ?>
      <button class="testimonial-dot<?= $index === 0 ? ' active' : '' ?>" data-index="<?= $index ?>" aria-label="Testimonial <?= $index + 1 ?>"></button>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>
