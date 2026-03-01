<?php
/**
 * Componenta Service Card
 */
$serviceIcon = $serviceIcon ?? '';
$serviceColor = $serviceColor ?? 'teal';
$serviceTitle = $serviceTitle ?? '';
$serviceDesc = $serviceDesc ?? '';
$serviceLink = $serviceLink ?? '#';
?>

<a href="<?= htmlspecialchars($serviceLink) ?>" class="service-card">
  <div class="service-icon <?= htmlspecialchars($serviceColor) ?>">
    <?= $serviceIcon ?>
  </div>
  <h3><?= htmlspecialchars($serviceTitle) ?></h3>
  <p><?= htmlspecialchars($serviceDesc) ?></p>
  <span class="service-link">
    Află Mai Mult
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
  </span>
</a>
