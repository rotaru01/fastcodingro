<?php
/**
 * Componenta Hero
 *
 * Variabile disponibile:
 * @var string $heroType       - 'full' (homepage) sau 'page' (pagini interioare)
 * @var string $heroBadge      - textul badge-ului (optional)
 * @var string $heroBadgeIcon  - SVG icon-ul badge-ului (optional)
 * @var string $heroTitle      - titlul principal (H1)
 * @var array  $heroServices   - lista servicii hero [{text, href}] (optional, doar pt homepage)
 * @var array  $heroButtons    - butoane [{text, href, class, icon, tag, onclick}] (optional)
 * @var string $heroSubtitle   - subtitlul pt inner pages (optional)
 */
$heroType = $heroType ?? 'page';
$heroBadge = $heroBadge ?? '';
$heroBadgeIcon = $heroBadgeIcon ?? '';
$heroTitle = $heroTitle ?? '';
$heroSubtitle = $heroSubtitle ?? '';
$heroServices = $heroServices ?? [];
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

    <?php if (!empty($heroServices)): ?>
    <div class="hero-services">
      <?php foreach ($heroServices as $i => $svc): ?>
        <?php if ($i > 0): ?><span class="sep">|</span><?php endif; ?>
        <a href="<?= htmlspecialchars($svc['href']) ?>"><?= htmlspecialchars($svc['text']) ?></a>
      <?php endforeach; ?>
    </div>
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
