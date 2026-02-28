<?php
/**
 * Componenta Project Card
 *
 * Variabile disponibile:
 * @var array $project - datele proiectului cu cheile:
 *   'thumbnail'   - URL-ul imaginii thumbnail
 *   'title'       - titlul proiectului
 *   'category'    - categoria (tag)
 *   'description' - descrierea scurta
 *   'slug'        - slug-ul pentru link
 *   'link'        - URL extern (optional, pentru Matterport etc.)
 */
$project = $project ?? [];
$thumbnail = $project['thumbnail'] ?? '';
$projectTitle = $project['title'] ?? '';
$category = $project['category_name'] ?? $project['category'] ?? '';
$description = $project['description'] ?? '';
$slug = $project['slug'] ?? '';
$link = $project['link'] ?? '';
$href = $link ?: ($slug ? '/portofoliu/' . $slug : '#');
?>

<div class="portfolio-card">
  <div class="portfolio-thumb">
    <?php if ($thumbnail): ?>
    <img src="<?= htmlspecialchars($thumbnail) ?>" alt="<?= htmlspecialchars($projectTitle) ?>" loading="lazy">
    <?php else: ?>
    <svg viewBox="0 0 400 300" style="width:100%;height:100%;background:#1A2B4A;">
      <rect width="400" height="300" fill="#1A2B4A"/>
      <text x="200" y="150" text-anchor="middle" dominant-baseline="middle" fill="#283868" font-size="48" font-family="Inter,sans-serif">SCANBOX</text>
    </svg>
    <?php endif; ?>
  </div>
  <div class="portfolio-info">
    <?php if ($category): ?>
    <span class="portfolio-tag"><?= htmlspecialchars($category) ?></span>
    <?php endif; ?>
    <h3><?= htmlspecialchars($projectTitle) ?></h3>
    <?php if ($description): ?>
    <p><?= htmlspecialchars($description) ?></p>
    <?php endif; ?>
    <a href="<?= htmlspecialchars($href) ?>" class="service-link"<?= $link ? ' target="_blank" rel="noopener"' : '' ?>>
      Vezi Proiectul
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </a>
  </div>
</div>
