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
    <?php
      $imgUrl = $item['url'] ?? $item['file_path'] ?? $item['thumbnail_path'] ?? $item['thumbnail'] ?? '';
      $altText = $item['alt'] ?? $item['alt_text'] ?? $item['title'] ?? '';
      $thumbUrl = $item['thumbnail'] ?? $item['thumbnail_path'] ?? '';
      $embedUrl = $item['external_url'] ?? $item['url'] ?? '';
      // Adauga prefixul /uploads/ daca e cale relativa (nu URL complet)
      if (!empty($imgUrl) && !str_starts_with($imgUrl, 'http') && !str_starts_with($imgUrl, '/')) {
          $imgUrl = '/uploads/' . $imgUrl;
      }
      if (!empty($thumbUrl) && !str_starts_with($thumbUrl, 'http') && !str_starts_with($thumbUrl, '/')) {
          $thumbUrl = '/uploads/' . $thumbUrl;
      }
    ?>
    <?php if (($item['type'] ?? 'image') === 'image'): ?>
      <img src="<?= htmlspecialchars($imgUrl) ?>"
           alt="<?= htmlspecialchars($altText) ?>"
           loading="lazy">
    <?php elseif (($item['type'] ?? '') === 'video'): ?>
      <video controls preload="metadata" poster="<?= htmlspecialchars($thumbUrl) ?>">
        <source src="<?= htmlspecialchars($imgUrl) ?>" type="video/mp4">
      </video>
    <?php elseif (($item['type'] ?? '') === 'embed'): ?>
      <div class="gallery-embed">
        <?= $embedUrl ?>
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
