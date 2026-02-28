<?php
/**
 * Componenta Hero
 *
 * Variabile disponibile:
 * @var string $heroType      - 'full' (homepage) sau 'page' (pagini interioare)
 * @var string $heroBadge     - textul badge-ului (optional)
 * @var string $heroBadgeIcon - SVG icon-ul badge-ului (optional)
 * @var string $heroTitle     - titlul principal (H1)
 * @var string $heroSubtitle  - subtitlul (optional)
 * @var array  $heroButtons   - butoane [{text, href, class, icon}] (optional, doar pt homepage)
 */
$heroType = $heroType ?? 'page';
$heroBadge = $heroBadge ?? '';
$heroBadgeIcon = $heroBadgeIcon ?? '';
$heroTitle = $heroTitle ?? '';
$heroSubtitle = $heroSubtitle ?? '';
$heroButtons = $heroButtons ?? [];
?>

<?php if ($heroType === 'full'): ?>
<!-- ===== HERO (Full-Height Homepage) ===== -->
<section class="hero">
  <div class="hero-blob hero-blob-1"></div>
  <div class="hero-blob hero-blob-2"></div>
  <div class="hero-blob hero-blob-3"></div>
  <div class="hero-blob hero-blob-4"></div>

  <div class="hero-content">
    <?php if ($heroBadge): ?>
    <span class="hero-badge">
      <?php if ($heroBadgeIcon): ?>
      <?= $heroBadgeIcon ?>
      <?php endif; ?>
      <?= htmlspecialchars($heroBadge) ?>
    </span>
    <?php endif; ?>

    <h1><?= $heroTitle ?></h1>

    <?php if ($heroSubtitle): ?>
    <p class="hero-subtitle"><?= $heroSubtitle ?></p>
    <?php endif; ?>

    <?php if (!empty($heroButtons)): ?>
    <div class="hero-buttons">
      <?php foreach ($heroButtons as $btn): ?>
        <?php if (!empty($btn['tag']) && $btn['tag'] === 'button'): ?>
        <button class="<?= htmlspecialchars($btn['class'] ?? 'btn-primary') ?>" onclick="<?= htmlspecialchars($btn['onclick'] ?? '') ?>">
          <?= htmlspecialchars($btn['text'] ?? '') ?>
          <?php if (!empty($btn['icon'])): ?><?= $btn['icon'] ?><?php endif; ?>
        </button>
        <?php else: ?>
        <a href="<?= htmlspecialchars($btn['href'] ?? '#') ?>" class="<?= htmlspecialchars($btn['class'] ?? 'btn-primary') ?>">
          <?= htmlspecialchars($btn['text'] ?? '') ?>
          <?php if (!empty($btn['icon'])): ?><?= $btn['icon'] ?><?php endif; ?>
        </a>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php else: ?>
<!-- ===== PAGE HERO (Inner Pages) ===== -->
<section class="page-hero">
  <div class="hero-blob hero-blob-1"></div>
  <div class="hero-blob hero-blob-2"></div>
  <div class="page-hero-content">
    <?php if ($heroBadge): ?>
    <span class="hero-badge">
      <?php if ($heroBadgeIcon): ?>
      <?= $heroBadgeIcon ?>
      <?php endif; ?>
      <?= htmlspecialchars($heroBadge) ?>
    </span>
    <?php endif; ?>

    <h1><?= htmlspecialchars($heroTitle) ?></h1>

    <?php if ($heroSubtitle): ?>
    <p><?= htmlspecialchars($heroSubtitle) ?></p>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>
