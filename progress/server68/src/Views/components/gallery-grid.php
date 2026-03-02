<?php
/**
 * Componenta Gallery Grid
 *
 * Variabile disponibile:
 * @var array  $galleryItems - array de elemente galerie, fiecare cu:
 *   'type'         - 'image', 'video', 'embed'
 *   'file_path'    - cale fisier (imagini)
 *   'external_url' - URL extern (YouTube, Instagram, TikTok)
 *   'title'        - titlul elementului
 *   'alt_text'     - text alternativ (optional)
 * @var string $galleryTitle   - titlul sectiunii galerie (optional)
 * @var string $galleryColumns - numar coloane: '2', '3', '4' (default: '3')
 */
$galleryItems = $galleryItems ?? [];
$galleryTitle = $galleryTitle ?? '';
$galleryColumns = $galleryColumns ?? '3';

/**
 * Converteste un URL YouTube/Instagram/TikTok in iframe embed
 */
function galleryGetEmbed(string $url): string
{
    // YouTube: watch, shorts, youtu.be
    if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/)|youtu\.be\/)([\w\-]+)/', $url, $m)) {
        return '<iframe src="https://www.youtube.com/embed/' . htmlspecialchars($m[1]) . '" frameborder="0" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" style="width:100%;aspect-ratio:16/9;border-radius:12px"></iframe>';
    }
    // Instagram: reel, p
    if (preg_match('/instagram\.com\/(?:reel|p)\/([\w\-]+)/', $url, $m)) {
        return '<iframe src="https://www.instagram.com/p/' . htmlspecialchars($m[1]) . '/embed" frameborder="0" scrolling="no" allowtransparency="true" style="width:100%;min-height:480px;border-radius:12px;background:#000"></iframe>';
    }
    // TikTok
    if (preg_match('/tiktok\.com\/@[\w.]+\/video\/(\d+)/', $url, $m)) {
        return '<iframe src="https://www.tiktok.com/embed/v2/' . htmlspecialchars($m[1]) . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope" style="width:100%;min-height:580px;border-radius:12px;background:#000"></iframe>';
    }
    // Fallback: link simplu
    return '<a href="' . htmlspecialchars($url) . '" target="_blank" rel="noopener" style="display:flex;align-items:center;justify-content:center;width:100%;min-height:200px;background:#0D1B2A;border-radius:12px;color:#04B494;text-decoration:none;font-size:15px;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:8px"><polygon points="5 3 19 12 5 21 5 3"/></svg>
        Deschide video
    </a>';
}
?>

<?php if (!empty($galleryItems)): ?>
<div class="gallery-grid" style="--gallery-cols: <?= (int)$galleryColumns ?>;">
  <?php foreach ($galleryItems as $item): ?>
  <div class="gallery-item">
    <?php
      $itemType = $item['type'] ?? 'image';
      $imgUrl = $item['url'] ?? $item['file_path'] ?? $item['thumbnail_path'] ?? $item['thumbnail'] ?? '';
      $altText = $item['alt'] ?? $item['alt_text'] ?? $item['title'] ?? '';
      $thumbUrl = $item['thumbnail'] ?? $item['thumbnail_path'] ?? '';
      $embedUrl = $item['external_url'] ?? '';
      // Adauga prefixul /uploads/ daca e cale relativa (nu URL complet)
      if (!empty($imgUrl) && !str_starts_with($imgUrl, 'http') && !str_starts_with($imgUrl, '/')) {
          $imgUrl = '/uploads/' . $imgUrl;
      }
      if (!empty($thumbUrl) && !str_starts_with($thumbUrl, 'http') && !str_starts_with($thumbUrl, '/')) {
          $thumbUrl = '/uploads/' . $thumbUrl;
      }
    ?>
    <?php if ($itemType === 'embed' && !empty($embedUrl)): ?>
      <div class="gallery-embed">
        <?= galleryGetEmbed($embedUrl) ?>
      </div>
    <?php elseif ($itemType === 'video'): ?>
      <video controls preload="metadata" poster="<?= htmlspecialchars($thumbUrl) ?>">
        <source src="<?= htmlspecialchars($imgUrl) ?>" type="video/mp4">
      </video>
    <?php else: ?>
      <img src="<?= htmlspecialchars($imgUrl) ?>"
           alt="<?= htmlspecialchars($altText) ?>"
           loading="lazy">
    <?php endif; ?>
    <?php if (!empty($item['title']) && $itemType !== 'embed'): ?>
    <div class="gallery-item-caption">
      <p><?= htmlspecialchars($item['title']) ?></p>
    </div>
    <?php endif; ?>
  </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>
