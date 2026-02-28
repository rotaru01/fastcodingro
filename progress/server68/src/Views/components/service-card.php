<?php
/**
 * Componenta Service Card
 *
 * Variabile disponibile:
 * @var string $serviceIcon   - SVG icon-ul serviciului
 * @var string $serviceColor  - clasa de culoare: 'teal', 'blue', 'mixed'
 * @var string $serviceTitle  - titlul serviciului
 * @var string $serviceDesc   - descrierea serviciului
 * @var string $serviceLink   - URL-ul catre pagina serviciului
 * @var string $serviceLinkText - textul link-ului (default: 'Află Mai Mult')
 */
$serviceIcon = $serviceIcon ?? '';
$serviceColor = $serviceColor ?? 'teal';
$serviceTitle = $serviceTitle ?? '';
$serviceDesc = $serviceDesc ?? '';
$serviceLink = $serviceLink ?? '#';
$serviceLinkText = $serviceLinkText ?? 'Află Mai Mult';
?>

<div class="service-card">
  <div class="service-icon <?= htmlspecialchars($serviceColor) ?>">
    <?= $serviceIcon ?>
  </div>
  <h3><?= htmlspecialchars($serviceTitle) ?></h3>
  <p><?= htmlspecialchars($serviceDesc) ?></p>
  <a href="<?= htmlspecialchars($serviceLink) ?>" class="service-link">
    <?= htmlspecialchars($serviceLinkText) ?>
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
  </a>
</div>
