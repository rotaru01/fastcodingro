<?php
/**
 * Pagina Servicii Video & Drone
 *
 * Variabile disponibile (din PageController::servicii):
 * @var string $title        - titlul paginii
 * @var array  $service      - datele serviciului din DB
 * @var array  $gallery      - galeria asociata
 * @var array  $galleryItems - elementele galeriei
 * @var array  $pricing      - pachetele de pret
 * @var array  $settings     - setarile site-ului
 */
$metaDescription = 'Servicii video profesionale B2B: prezentări companie, interviuri, testimoniale, filmări cu drona, reels pentru social media.';
?>

<?php
$heroType = 'page';
$heroBadge = 'Producție Video';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>';
$heroTitle = 'Servicii Video B2B';
$heroSubtitle = 'Producție video completă pentru companii și branduri';
include __DIR__ . '/../../components/hero.php';
?>

<!-- ===== ECHIPAMENTE ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%); padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
        Echipamente Profesionale
      </span>
      <h2 class="section-title">Tehnologie de Ultimă Generație</h2>
    </div>

    <div class="services-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
      <div class="service-card" style="text-align: center;">
        <div class="service-icon teal">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="8" y="10" width="32" height="24" rx="3"/><circle cx="24" cy="22" r="8"/></svg>
        </div>
        <h3>Camere Cinema</h3>
        <p>Sony FX3, A7S III pentru calitate cinematografică 4K.</p>
      </div>
      <div class="service-card" style="text-align: center;">
        <div class="service-icon blue">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="24" cy="16" r="8"/><path d="M24 24v16"/><path d="M16 36h16"/></svg>
        </div>
        <h3>Iluminare</h3>
        <p>Panouri LED bi-color și softbox-uri pentru lumină perfectă.</p>
      </div>
      <div class="service-card" style="text-align: center;">
        <div class="service-icon teal">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M24 4C12 4 4 24 4 24s8 20 20 20 20-20 20-20S36 4 24 4z"/><circle cx="24" cy="24" r="6"/></svg>
        </div>
        <h3>Microfoane</h3>
        <p>Rode wireless, shotgun și lavaliere pentru sunet crystal clear.</p>
      </div>
      <div class="service-card" style="text-align: center;">
        <div class="service-icon mixed">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="12" y="8" width="24" height="32" rx="2"/><path d="M20 12h8"/><circle cx="24" cy="34" r="2"/></svg>
        </div>
        <h3>Prompter</h3>
        <p>Teleprompter profesional pentru prezentări fluente și naturale.</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== TIPURI VIDEO ===== -->
<section class="content-section" style="padding: 80px 0;">
  <div class="container">

    <!-- Prezentare Companie -->
    <div class="content-grid">
      <div class="content-text">
        <div class="section-tag">01</div>
        <h2>Video Prezentare Companie</h2>
        <p>Videoclipuri profesionale care prezintă povestea, valorile și activitatea companiei tale. De la concept la montaj final, ne ocupăm de întreaga producție.</p>
        <ul style="margin-top: 16px; display: flex; flex-direction: column; gap: 8px;">
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Concept & storyboard
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Filmare 4K cu echipamente cinema
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Montaj, color grading, muzică
          </li>
        </ul>
      </div>
      <div class="content-visual">
        <?php if (!empty($service['video_embed'])): ?>
        <div style="position: relative; padding-bottom: 56.25%; height: 0; border-radius: 16px; overflow: hidden;">
          <iframe src="<?= htmlspecialchars($service['video_embed']) ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" allowfullscreen loading="lazy"></iframe>
        </div>
        <?php else: ?>
        <div style="position: relative; padding-bottom: 56.25%; height: 0; border-radius: 16px; overflow: hidden;">
          <iframe src="https://www.youtube.com/embed/ZbMwcPjQomU" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" allowfullscreen loading="lazy"></iframe>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Interviu & Testimonial -->
    <div class="content-grid reversed" style="margin-top: 80px;">
      <div class="content-text">
        <div class="section-tag">02</div>
        <h2>Video Interviu & Testimonial</h2>
        <p>Interviuri profesionale cu angajați, clienți sau parteneri. Testimoniale video autentice care construiesc încredere și credibilitate.</p>
        <ul style="margin-top: 16px; display: flex; flex-direction: column; gap: 8px;">
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Setup profesional multi-cameră
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Sunet de studio cu microfoane wireless
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Prompter pentru subiecți
          </li>
        </ul>
      </div>
      <div class="content-visual">
        <svg viewBox="0 0 500 300" style="width:100%;background:#1A2B4A;border-radius:16px;">
          <rect width="500" height="300" fill="#1A2B4A" rx="16"/>
          <text x="250" y="150" text-anchor="middle" fill="#283868" font-size="28" font-family="Inter,sans-serif">Interviu Video</text>
        </svg>
      </div>
    </div>

    <!-- Prezentare Imobiliara -->
    <div class="content-grid" style="margin-top: 80px;">
      <div class="content-text">
        <div class="section-tag">03</div>
        <h2>Video Prezentare Imobiliară</h2>
        <p>Videoclipuri cinematografice pentru proprietăți imobiliare, inclusiv filmări aeriene cu drona. Prezentări care vând.</p>
        <ul style="margin-top: 16px; display: flex; flex-direction: column; gap: 8px;">
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Filmare interior & exterior
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Filmare aeriană cu drona 4K
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Montaj cu muzică și tranziții cinematografice
          </li>
        </ul>
      </div>
      <div class="content-visual">
        <svg viewBox="0 0 500 300" style="width:100%;background:#1A2B4A;border-radius:16px;">
          <rect width="500" height="300" fill="#1A2B4A" rx="16"/>
          <text x="250" y="150" text-anchor="middle" fill="#283868" font-size="28" font-family="Inter,sans-serif">Imobiliar Video</text>
        </svg>
      </div>
    </div>

  </div>
</section>

<!-- ===== REELS SECTION ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%); padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Reels & Short-Form Content</h2>
      <p class="section-subtitle">Conținut video scurt, optimizat pentru Instagram, TikTok și YouTube Shorts</p>
    </div>

    <div style="text-align: center; margin-top: 40px;">
      <a href="/portofoliu-reels" class="btn-outline">
        Vezi Portofoliu Reels
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>
</section>

<!-- ===== GALERIE ===== -->
<?php if (!empty($galleryItems)): ?>
<section class="content-section" style="padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Portofoliu Video</h2>
    </div>
    <?php include __DIR__ . '/../../components/gallery-grid.php'; ?>
  </div>
</section>
<?php endif; ?>

<!-- ===== PRICING ===== -->
<?php if (!empty($pricing)):
    $pricingTitle = 'Pachete Video';
    $pricingSubtitle = 'De la concept la final, la prețuri transparente';
    include __DIR__ . '/../../components/pricing-table.php';
endif; ?>
