<?php
/**
 * Pagina Portofoliu Reels
 *
 * Variabile disponibile (din PageController::portofoliuReels):
 * @var string $title    - titlul paginii
 * @var array  $projects - proiectele de tip reels (fiecare cu 'embed_url' sau 'instagram_url')
 * @var array  $settings - setarile site-ului
 */
$metaDescription = 'O selecție din cele mai recente proiecte video în format scurt realizate de Scanbox.';
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
      <?php if (!empty($projects)): ?>
        <?php foreach ($projects as $reel): ?>
        <div class="reel-item">
          <?php if (!empty($reel['instagram_url'])): ?>
          <blockquote class="instagram-media"
            data-instgrm-permalink="<?= htmlspecialchars($reel['instagram_url']) ?>"
            data-instgrm-version="14"
            style="background:#0D1B2A; border:0; border-radius:16px; margin:0; max-width:100%; min-width:100%; padding:0; width:100%;">
          </blockquote>
          <?php elseif (!empty($reel['embed_url'])): ?>
          <div style="position:relative;padding-bottom:177%;height:0;border-radius:16px;overflow:hidden;">
            <iframe src="<?= htmlspecialchars($reel['embed_url']) ?>" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allowfullscreen loading="lazy"></iframe>
          </div>
          <?php elseif (!empty($reel['thumbnail'])): ?>
          <div style="border-radius:16px;overflow:hidden;">
            <img src="<?= htmlspecialchars($reel['thumbnail']) ?>" alt="<?= htmlspecialchars($reel['title'] ?? 'Reel') ?>" loading="lazy">
          </div>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Fallback - reels statice -->
        <?php
        $defaultReels = [
            'https://www.instagram.com/reel/C1HAzZhIs_0/',
            'https://www.instagram.com/reel/C0gOfOgo1FM/',
            'https://www.instagram.com/reel/Cy5BL7Ux5ll/',
            'https://www.instagram.com/reel/DKwYH4ZsgCB/',
            'https://www.instagram.com/reel/DT4y8oeAhqR/',
            'https://www.instagram.com/reel/DUoBChhDIa0/',
        ];
        foreach ($defaultReels as $reelUrl): ?>
        <div class="reel-item">
          <blockquote class="instagram-media"
            data-instgrm-permalink="<?= htmlspecialchars($reelUrl) ?>"
            data-instgrm-version="14"
            style="background:#0D1B2A; border:0; border-radius:16px; margin:0; max-width:100%; min-width:100%; padding:0; width:100%;">
          </blockquote>
        </div>
        <?php endforeach; ?>
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

<?php $extraScripts = '<script async src="//www.instagram.com/embed.js"></script>'; ?>
