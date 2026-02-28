<?php
/**
 * Componenta Gallery Grid
 *
 * Variabile disponibile:
 * @var array  $galleryItems - array de elemente galerie, fiecare cu:
 *   'type'      - 'image', 'video', 'embed'
 *   'url'       - URL fisier/embed
 *   'thumbnail' - URL thumbnail (optional)
 *   'title'     - titlul elementului
 *   'alt'       - text alternativ (optional)
 * @var string $galleryTitle   - titlul sectiunii galerie (optional)
 * @var string $galleryColumns - numar coloane: '2', '3', '4' (default: '3')
 */
$galleryItems = $galleryItems ?? [];
$galleryTitle = $galleryTitle ?? '';
$galleryColumns = $galleryColumns ?? '3';
?>

<?php if (!empty($galleryItems)): ?>
<div class="gallery-grid" style="--gallery-cols: <?= (int)$galleryColumns ?>;">
  <?php foreach ($galleryItems as $item): ?>
  <div class="gallery-item">
    <?php if (($item['type'] ?? 'image') === 'image'): ?>
      <img src="<?= htmlspecialchars($item['url'] ?? $item['thumbnail'] ?? '') ?>"
           alt="<?= htmlspecialchars($item['alt'] ?? $item['title'] ?? '') ?>"
           loading="lazy">
    <?php elseif (($item['type'] ?? '') === 'video'): ?>
      <video controls preload="metadata" poster="<?= htmlspecialchars($item['thumbnail'] ?? '') ?>">
        <source src="<?= htmlspecialchars($item['url'] ?? '') ?>" type="video/mp4">
      </video>
    <?php elseif (($item['type'] ?? '') === 'embed'): ?>
      <div class="gallery-embed">
        <?= $item['url'] ?? '' ?>
      </div>
    <?php endif; ?>
    <?php if (!empty($item['title'])): ?>
    <div class="gallery-item-caption">
      <p><?= htmlspecialchars($item['title']) ?></p>
    </div>
    <?php endif; ?>
  </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>
