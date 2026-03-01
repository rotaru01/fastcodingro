<?php
/**
 * Componenta Testimonial Slider
 */
$testimonials = $testimonials ?? [];

// Fallback testimoniale daca nu sunt in DB
if (empty($testimonials)) {
    $testimonials = [
        [
            'author_name' => 'Ana Maria Cioclei',
            'author_role' => 'Director Marketing, Park 20 by Cordia',
            'quote' => 'Colaborarea cu Scanbox a fost impecabilă. Turul virtual 3D realizat pentru proiectul nostru rezidențial a crescut semnificativ rata de conversie a vizitelor online în vizionări reale. Recomand cu încredere!',
            'rating' => 5,
        ],
        [
            'author_name' => 'Mihai Popescu',
            'author_role' => 'Manager Evenimente Sportive',
            'quote' => 'Echipa Scanbox a livrat un conținut video excepțional pentru evenimentele noastre sportive. Profesionalismul și atenția la detalii ne-au impresionat de fiecare dată. Partenerul ideal pentru sport content!',
            'rating' => 5,
        ],
        [
            'author_name' => 'Elena Dumitrescu',
            'author_role' => 'CEO, Boutique Hotel București',
            'quote' => 'De când colaborăm cu Scanbox pentru social media, engagement-ul pe paginile noastre a crescut cu peste 200%. Strategia lor e bine gândită și conținutul vizual e mereu de calitate superioară.',
            'rating' => 5,
        ],
    ];
}

$starSvg = '<svg viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>';
?>

<!-- ===== TESTIMONIALS ===== -->
<section class="testimonial-section">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Testimoniale</span>
      <h2 class="section-title">Ce Spun Clienții Noștri</h2>
    </div>

    <div class="testimonial-slider" id="testimonialSlider">
      <?php foreach ($testimonials as $index => $testimonial):
        $name = $testimonial['author_name'] ?? $testimonial['name'] ?? '';
        $role = $testimonial['author_role'] ?? $testimonial['role'] ?? '';
        $text = $testimonial['quote'] ?? $testimonial['text'] ?? '';
        $initials = '';
        $words = explode(' ', $name);
        foreach ($words as $w) { if ($w) $initials .= mb_strtoupper(mb_substr($w, 0, 1)); }
      ?>
      <div class="testimonial-slide<?= $index === 0 ? ' active' : '' ?>" data-slide="<?= $index ?>">
        <span class="testimonial-quote-mark">&ldquo;</span>
        <div class="testimonial-stars">
          <?= str_repeat($starSvg, (int)($testimonial['rating'] ?? 5)) ?>
        </div>
        <p class="testimonial-text">
          &bdquo;<?= htmlspecialchars($text) ?>&rdquo;
        </p>
        <div class="testimonial-author">
          <div class="testimonial-avatar"><?= htmlspecialchars($initials) ?></div>
          <span class="testimonial-author-name"><?= htmlspecialchars($name) ?></span>
          <span class="testimonial-author-role"><?= htmlspecialchars($role) ?></span>
        </div>
      </div>
      <?php endforeach; ?>

      <!-- Dots -->
      <?php if (count($testimonials) > 1): ?>
      <div class="testimonial-dots">
        <?php foreach ($testimonials as $index => $t): ?>
        <button class="testimonial-dot<?= $index === 0 ? ' active' : '' ?>" data-index="<?= $index ?>" aria-label="Testimonial <?= $index + 1 ?>"></button>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>
