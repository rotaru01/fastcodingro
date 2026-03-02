<?php
/**
 * Pagina Portofoliu Reels
 */
$metaDescription = 'Portofoliul video Scanbox.ro: o selecție din cele mai recente proiecte video in format scurt (Reels) realizate pentru clienți din imobiliare, HoReCa, sport și retail. Conținut dinamic pentru Instagram, TikTok și Facebook.';
$schemaJsonLd = '
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CollectionPage",
  "name": "Portofoliu Reels — Scanbox.ro",
  "description": "O selecție din cele mai recente proiecte video în format scurt realizate de Scanbox.ro.",
  "url": "https://scanbox.ro/portofoliu-reels.html",
  "publisher": {
    "@type": "Organization",
    "name": "Scanbox.ro",
    "url": "https://scanbox.ro"
  }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type": "ListItem", "position": 1, "name": "Acasă", "item": "https://scanbox.ro"},
    {"@type": "ListItem", "position": 2, "name": "Portofoliu Reels", "item": "https://scanbox.ro/portofoliu-reels.html"}
  ]
}
</script>
';
?>

<?php
$heroType = 'page';
$heroBadge = 'Portofoliu Video';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>';
$heroTitle = 'Portofoliu Reels';
$heroSubtitle = 'O selecție din cele mai recente proiecte video în format scurt';
include __DIR__ . '/../components/hero.php';
?>

<!-- ===== REELS GRID ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%); padding: 80px 0 100px;">
  <div class="container">
    <div class="reels-grid">
      <?php if (!empty($reelsItems)): ?>
        <?php foreach ($reelsItems as $reel):
          $reelUrl = $reel['external_url'] ?? '';
          $reelTitle = $reel['title'] ?? '';
          $thumbPath = $reel['thumbnail_path'] ?? '';
          if ($thumbPath && !str_starts_with($thumbPath, 'http') && !str_starts_with($thumbPath, '/')) {
              $thumbPath = '/uploads/' . $thumbPath;
          }
        ?>
        <a href="<?= htmlspecialchars($reelUrl) ?>" target="_blank" rel="noopener" class="reel-card<?= $thumbPath ? ' has-thumb' : '' ?>">
          <?php if ($thumbPath): ?>
          <img src="<?= htmlspecialchars($thumbPath) ?>" alt="<?= htmlspecialchars($reelTitle) ?>" class="reel-card-thumb" loading="lazy">
          <?php else: ?>
          <div class="reel-card-bg">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.08)" stroke-width="1"><rect x="2" y="2" width="20" height="20" rx="5"/><line x1="2" y1="8" x2="22" y2="8"/><line x1="8" y1="2" x2="8" y2="8"/><circle cx="12" cy="15" r="3.5"/></svg>
          </div>
          <?php endif; ?>
          <div class="reel-card-play">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="#fff"><polygon points="6 3 20 12 6 21 6 3"/></svg>
          </div>
          <?php if ($reelTitle): ?>
          <div class="reel-card-title"><?= htmlspecialchars($reelTitle) ?></div>
          <?php endif; ?>
          <div class="reel-card-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="18" cy="6" r="1.5" fill="currentColor"/></svg>
            Instagram Reel
          </div>
        </a>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="color:#94A3B8; text-align:center; grid-column:1/-1;">Nu sunt reels disponibile momentan.</p>
      <?php endif; ?>
    </div>

    <!-- Back link -->
    <div style="text-align: center; margin-top: 60px;">
      <a href="/servicii/social-media" class="btn-outline">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Înapoi la Social Media
      </a>
    </div>
  </div>
</section>
