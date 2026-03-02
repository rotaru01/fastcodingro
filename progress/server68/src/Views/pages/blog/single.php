<?php
/**
 * Pagina Articol Blog - Single Post
 *
 * Variabile disponibile (din BlogController::show):
 * @var string $title        - titlul paginii
 * @var array  $post         - datele articolului
 * @var array  $relatedPosts - articole similare
 * @var array  $categories   - categoriile cu numar de articole
 * @var array  $settings     - setarile site-ului
 */
$metaDescription = htmlspecialchars(mb_substr(strip_tags($post['excerpt'] ?? $post['content'] ?? ''), 0, 160));
$ogImage = $post['featured_image'] ?? '';
$ogType = 'article';
?>

<?php
$heroType = 'page';
$heroBadge = $post['category_name'] ?? 'Blog';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/></svg>';
$heroTitle = htmlspecialchars($post['title'] ?? '');
$heroSubtitle = date('d.m.Y', strtotime($post['published_at'] ?? $post['created_at'] ?? 'now'));
include __DIR__ . '/../../components/hero.php';
?>

<!-- ===== ARTICOL ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%); padding: 60px 0 80px;">
  <div class="container">
    <article style="max-width: 800px; margin: 0 auto;">

      <!-- Featured Image -->
      <?php if (!empty($post['featured_image'])): ?>
      <div style="border-radius: 16px; overflow: hidden; margin-bottom: 40px;">
        <img src="<?= htmlspecialchars($post['featured_image']) ?>" alt="<?= htmlspecialchars($post['title'] ?? '') ?>" style="width: 100%; display: block;">
      </div>
      <?php endif; ?>

      <!-- Meta -->
      <div style="display: flex; flex-wrap: wrap; gap: 16px; align-items: center; margin-bottom: 32px; color: #94A3B8; font-size: 14px;">
        <span style="display: flex; align-items: center; gap: 6px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          <?= date('d F Y', strtotime($post['published_at'] ?? $post['created_at'] ?? 'now')) ?>
        </span>
        <?php if (!empty($post['category_name'])): ?>
        <a href="/blog/categorie/<?= htmlspecialchars($post['category_slug'] ?? '') ?>" style="color: #04B494;">
          <?= htmlspecialchars($post['category_name']) ?>
        </a>
        <?php endif; ?>
        <?php if (!empty($post['views'])): ?>
        <span style="display: flex; align-items: center; gap: 6px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          <?= number_format((int)$post['views']) ?> vizualizări
        </span>
        <?php endif; ?>
      </div>

      <!-- Conținut -->
      <div class="blog-content" style="color: #CBD5E1; line-height: 1.8; font-size: 16px;">
        <?= $post['content'] ?? '' ?>
      </div>

      <!-- Tags -->
      <?php if (!empty($post['tags'])): ?>
      <div style="margin-top: 40px; display: flex; flex-wrap: wrap; gap: 8px;">
        <?php foreach (explode(',', $post['tags']) as $tag): ?>
        <span style="background: rgba(4, 180, 148, 0.1); color: #04B494; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 500;">
          #<?= htmlspecialchars(trim($tag)) ?>
        </span>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <!-- Share -->
      <div style="margin-top: 40px; padding-top: 32px; border-top: 1px solid rgba(255,255,255,0.06);">
        <p style="color: #94A3B8; font-size: 14px; margin-bottom: 12px;">Distribuie articolul:</p>
        <div style="display: flex; gap: 12px;">
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode((defined('SITE_URL') ? SITE_URL : '') . '/blog/' . ($post['slug'] ?? '')) ?>" target="_blank" rel="noopener" style="width: 40px; height: 40px; background: rgba(26, 43, 74, 0.5); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="#94A3B8"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          </a>
          <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode((defined('SITE_URL') ? SITE_URL : '') . '/blog/' . ($post['slug'] ?? '')) ?>" target="_blank" rel="noopener" style="width: 40px; height: 40px; background: rgba(26, 43, 74, 0.5); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="#94A3B8"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
        </div>
      </div>
    </article>
  </div>
</section>

<!-- ===== ARTICOLE SIMILARE ===== -->
<?php if (!empty($relatedPosts)): ?>
<section class="blog-section content-section" style="padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Articole Similare</h2>
    </div>
    <div class="blog-grid">
      <?php foreach ($relatedPosts as $related): ?>
      <a href="/blog/<?= htmlspecialchars($related['slug'] ?? '') ?>" class="blog-card">
        <div class="blog-card-thumb">
          <?php if (!empty($related['featured_image'])): ?>
          <img src="<?= htmlspecialchars($related['featured_image']) ?>" alt="<?= htmlspecialchars($related['title'] ?? '') ?>" loading="lazy">
          <?php else: ?>
          <svg viewBox="0 0 400 250" style="width:100%;background:linear-gradient(135deg,#1A2B4A,#283868);">
            <text x="200" y="125" text-anchor="middle" fill="#394E75" font-size="24" font-family="Inter,sans-serif">SCANBOX</text>
          </svg>
          <?php endif; ?>
        </div>
        <div class="blog-card-body">
          <div class="blog-card-date">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <?= date('d.m.Y', strtotime($related['published_at'] ?? $related['created_at'] ?? 'now')) ?>
          </div>
          <h3><?= htmlspecialchars($related['title'] ?? '') ?></h3>
          <p><?= htmlspecialchars(mb_substr(strip_tags($related['excerpt'] ?? $related['content'] ?? ''), 0, 120)) ?>...</p>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
