<?php
/**
 * Pagina Sport Content
 *
 * Variabile disponibile (din PageController::sportContent):
 * @var string $title     - titlul paginii
 * @var array  $galleries - galeriile de tip sport [{gallery, items}]
 * @var array  $settings  - setarile site-ului
 */
$metaDescription = 'Conținut vizual profesional pentru evenimente și branduri sportive: fotografie, video, reels. Experiență dovedită cu branduri din industria sportivă.';
?>

<?php
$heroType = 'page';
$heroBadge = 'Sport Content';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 000 20 14.5 14.5 0 000-20"/><path d="M2 12h20"/></svg>';
$heroTitle = 'Sport Content';
$heroSubtitle = 'Conținut vizual dedicat sportului și evenimentelor sportive';
include __DIR__ . '/../components/hero.php';
?>

<!-- ===== INTRO ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%); padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <p class="section-subtitle" style="max-width: 700px; margin: 0 auto;">
        Suntem specializați în crearea de conținut vizual pentru industria sportivă. De la evenimente și competiții, la produse și branduri — surprindem energia și pasiunea din fiecare moment.
      </p>
    </div>
  </div>
</section>

<!-- ===== CATEGORII ===== -->
<section class="content-section" style="padding: 80px 0;">
  <div class="container">

    <!-- Fotografie Sport -->
    <div class="content-grid">
      <div class="content-text">
        <div class="section-tag">01</div>
        <h2>Fotografie Sport</h2>
        <p>Fotografie de acțiune pentru competiții, antrenamente și evenimente sportive. Surprindem momentele decisive cu echipamente rapide și experimentate.</p>
        <ul style="margin-top: 16px; display: flex; flex-direction: column; gap: 8px;">
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Fotografie de acțiune high-speed
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Portrete sportivi & echipe
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Fotografie de eveniment sportiv
          </li>
        </ul>
      </div>
      <div class="content-visual">
        <svg viewBox="0 0 500 400" style="width:100%;background:#1A2B4A;border-radius:16px;">
          <rect width="500" height="400" fill="#1A2B4A" rx="16"/>
          <text x="250" y="200" text-anchor="middle" fill="#283868" font-size="28" font-family="Inter,sans-serif">Sport Foto</text>
        </svg>
      </div>
    </div>

    <!-- Video Product in Action -->
    <div class="content-grid reversed" style="margin-top: 80px;">
      <div class="content-text">
        <div class="section-tag">02</div>
        <h2>Video Product in Action</h2>
        <p>Prezentarea echipamentelor și produselor sportive în mediul lor natural. Videoclipuri dinamice care arată produsul în acțiune.</p>
        <ul style="margin-top: 16px; display: flex; flex-direction: column; gap: 8px;">
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Filmare slow-motion
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Product showcase dinamic
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Editare cu grafice și motion
          </li>
        </ul>
      </div>
      <div class="content-visual">
        <svg viewBox="0 0 500 400" style="width:100%;background:#1A2B4A;border-radius:16px;">
          <rect width="500" height="400" fill="#1A2B4A" rx="16"/>
          <text x="250" y="200" text-anchor="middle" fill="#283868" font-size="28" font-family="Inter,sans-serif">Product Video</text>
        </svg>
      </div>
    </div>

    <!-- Reels Evenimente Sport -->
    <div class="content-grid" style="margin-top: 80px;">
      <div class="content-text">
        <div class="section-tag">03</div>
        <h2>Reels & Evenimente Sport</h2>
        <p>Conținut video scurt pentru social media, recap-uri de eveniment și highlight-uri. Optimizat pentru Instagram, TikTok și YouTube Shorts.</p>
        <ul style="margin-top: 16px; display: flex; flex-direction: column; gap: 8px;">
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Reels & TikTok-uri virale
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Event recap video
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Behind-the-scenes content
          </li>
        </ul>
      </div>
      <div class="content-visual">
        <svg viewBox="0 0 500 400" style="width:100%;background:#1A2B4A;border-radius:16px;">
          <rect width="500" height="400" fill="#1A2B4A" rx="16"/>
          <text x="250" y="200" text-anchor="middle" fill="#283868" font-size="28" font-family="Inter,sans-serif">Reels Sport</text>
        </svg>
      </div>
    </div>

  </div>
</section>

<!-- ===== QUOTE ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%); padding: 60px 0;">
  <div class="container" style="text-align: center;">
    <blockquote style="max-width: 700px; margin: 0 auto; font-size: 20px; font-style: italic; color: #CBD5E1; line-height: 1.8;">
      "Sportul este emoție pură. Noi o transformăm în conținut vizual care inspiră și motivează."
    </blockquote>
    <p style="color: #04B494; margin-top: 16px; font-weight: 600;">— Echipa Scanbox</p>
  </div>
</section>

<!-- ===== PARTENERI SPORT ===== -->
<?php if (!empty($galleries)): ?>
<section class="content-section" style="padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        Parteneri Sport
      </span>
    </div>
    <div class="logos-track">
      <?php foreach ($galleries as $galleryData): ?>
        <?php foreach ($galleryData['items'] ?? [] as $item): ?>
        <div class="logo-placeholder">
          <?php if (!empty($item['url'])): ?>
          <img src="<?= htmlspecialchars($item['url']) ?>" alt="<?= htmlspecialchars($item['title'] ?? '') ?>" loading="lazy">
          <?php else: ?>
          <span><?= htmlspecialchars($item['title'] ?? '') ?></span>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
