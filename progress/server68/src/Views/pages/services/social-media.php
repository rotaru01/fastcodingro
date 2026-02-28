<?php
/**
 * Pagina Social Media Management
 *
 * Variabile disponibile (din PageController::servicii):
 * @var string $title        - titlul paginii
 * @var array  $service      - datele serviciului din DB
 * @var array  $gallery      - galeria asociata
 * @var array  $galleryItems - elementele galeriei
 * @var array  $pricing      - pachetele de pret
 * @var array  $settings     - setarile site-ului
 */
$metaDescription = 'Servicii complete de social media management: strategie, creare conținut, administrare pagini, reels și stories pentru Instagram, Facebook, TikTok.';

$extraCss = '
.slogan-text {
  font-size: clamp(28px, 5vw, 56px);
  font-weight: 800;
  letter-spacing: 2px;
  color: rgba(255,255,255,0.08);
  text-transform: uppercase;
  text-align: center;
  padding: 40px 0;
}
.collab-steps {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 32px;
  margin-top: 40px;
}
.collab-step {
  background: rgba(26, 43, 74, 0.5);
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: 16px;
  padding: 32px;
  text-align: center;
}
.collab-step .step-num {
  width: 48px;
  height: 48px;
  background: linear-gradient(135deg, #04B494, #039B7E);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 18px;
  margin: 0 auto 16px;
}
.collab-step h3 { margin-bottom: 8px; }
.collab-step p { color: #94A3B8; font-size: 14px; }
.note-box {
  background: rgba(4, 180, 148, 0.08);
  border: 1px solid rgba(4, 180, 148, 0.2);
  border-radius: 12px;
  padding: 20px 24px;
  margin-top: 32px;
  color: #94A3B8;
  font-size: 14px;
  line-height: 1.6;
}
';
?>

<?php
$heroType = 'page';
$heroBadge = 'Social Media';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>';
$heroTitle = 'Social Media Management';
$heroSubtitle = 'Strategie, creare conținut și administrare completă';
include __DIR__ . '/../../components/hero.php';
?>

<!-- ===== SLOGAN ===== -->
<section class="content-section" style="padding: 40px 0; background: linear-gradient(180deg, #152540 0%, #1A2B4A 100%);">
  <div class="container">
    <div class="slogan-text">WE ARE YOUR CONTENT CREATORS</div>
  </div>
</section>

<!-- ===== INTRO ===== -->
<section class="content-section" style="background: #1A2B4A; padding: 60px 0;">
  <div class="container">
    <div class="section-header">
      <p class="section-subtitle" style="max-width: 700px; margin: 0 auto;">
        Echipa noastră se ocupă de tot ce înseamnă prezența ta pe social media: de la strategie și creare conținut, până la gestionarea comunității și raportare lunară.
      </p>
    </div>
  </div>
</section>

<!-- ===== SERVICII SM ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #1A2B4A 0%, #152540 100%); padding: 80px 0;">
  <div class="container">
    <div class="services-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
      <div class="service-card">
        <div class="service-icon teal">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="6" y="6" width="36" height="36" rx="4"/><path d="M6 18h36"/><path d="M18 6v36"/></svg>
        </div>
        <h3>Strategie & Planificare</h3>
        <p>Calendar editorial personalizat, strategie de conținut aliniată la obiectivele tale de business și analiza competiției.</p>
      </div>
      <div class="service-card">
        <div class="service-icon blue">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="24" cy="24" r="16"/><path d="M24 16v16M16 24h16"/></svg>
        </div>
        <h3>Creare Conținut</h3>
        <p>Fotografii, videoclipuri, reels, stories și grafice profesionale create special pentru brandingul tău.</p>
      </div>
      <div class="service-card">
        <div class="service-icon teal">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 36V12a4 4 0 014-4h32a4 4 0 014 4v24a4 4 0 01-4 4H8a4 4 0 01-4-4z"/><path d="M12 20l8 8 16-16"/></svg>
        </div>
        <h3>Administrare & Community</h3>
        <p>Gestionarea postărilor, răspuns la comentarii și mesaje, creștere organică a comunității.</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== PRICING ===== -->
<section class="pricing-section content-section" style="background: linear-gradient(180deg, #152540 0%, #0D1B2A 100%); padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Pachete Social Media</h2>
      <p class="section-subtitle">Alege pachetul care se potrivește cel mai bine nevoilor tale</p>
    </div>

    <?php if (!empty($pricing)): ?>
    <div class="pricing-grid">
      <?php foreach ($pricing as $package): ?>
      <div class="pricing-card<?= !empty($package['is_featured']) ? ' featured' : '' ?>">
        <?php if (!empty($package['is_featured'])): ?>
        <div class="pricing-badge">Recomandat</div>
        <?php endif; ?>
        <h3><?= htmlspecialchars($package['name'] ?? '') ?></h3>
        <div class="pricing-price">
          <span class="pricing-amount"><?= htmlspecialchars($package['price'] ?? '0') ?></span>
          <span class="pricing-currency"><?= htmlspecialchars($package['currency'] ?? 'EUR') ?></span>
          <span class="pricing-period"><?= htmlspecialchars($package['period'] ?? '/ lună') ?></span>
        </div>
        <div class="pricing-vat"><?= htmlspecialchars($package['vat_note'] ?? '+ TVA') ?></div>

        <?php if (!empty($package['features'])): ?>
        <ul class="pricing-features">
          <?php foreach ($package['features'] as $feature): ?>
          <li>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <?= htmlspecialchars($feature) ?>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <a href="/contact" class="<?= !empty($package['is_featured']) ? 'btn-primary' : 'btn-outline' ?>">Solicită Ofertă</a>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <!-- Fallback pachete statice -->
    <div class="pricing-grid">
      <div class="pricing-card">
        <h3>ADMIN</h3>
        <div class="pricing-price">
          <span class="pricing-amount">250</span>
          <span class="pricing-currency">EUR</span>
          <span class="pricing-period">/ lună</span>
        </div>
        <div class="pricing-vat">+ TVA</div>
        <ul class="pricing-features">
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Administrare 2 platforme</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> 12 postări / lună</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> 4 stories / lună</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Raport lunar</li>
        </ul>
        <a href="/contact" class="btn-outline">Solicită Ofertă</a>
      </div>
      <div class="pricing-card featured">
        <div class="pricing-badge">Recomandat</div>
        <h3>CREATOR</h3>
        <div class="pricing-price">
          <span class="pricing-amount">350</span>
          <span class="pricing-currency">EUR</span>
          <span class="pricing-period">/ lună</span>
        </div>
        <div class="pricing-vat">+ TVA</div>
        <ul class="pricing-features">
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Administrare 3 platforme</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> 20 postări / lună</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> 8 stories + 4 reels / lună</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Ședință foto lunară</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Raport detaliat</li>
        </ul>
        <a href="/contact" class="btn-primary">Solicită Ofertă</a>
      </div>
      <div class="pricing-card">
        <h3>MANAGER</h3>
        <div class="pricing-price">
          <span class="pricing-amount">450</span>
          <span class="pricing-currency">EUR</span>
          <span class="pricing-period">/ lună</span>
        </div>
        <div class="pricing-vat">+ TVA</div>
        <ul class="pricing-features">
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Administrare 4+ platforme</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> 30 postări / lună</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> 12 stories + 8 reels / lună</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> 2 ședințe foto / lună</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Strategie completă + ads</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Raport săptămânal</li>
        </ul>
        <a href="/contact" class="btn-outline">Solicită Ofertă</a>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- ===== PAȘI COLABORARE ===== -->
<section class="content-section" style="padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Cum Colaborăm</h2>
    </div>
    <div class="collab-steps">
      <div class="collab-step">
        <div class="step-num">1</div>
        <h3>Consultanță Gratuită</h3>
        <p>Analizăm prezența ta actuală pe social media și stabilim obiectivele împreună.</p>
      </div>
      <div class="collab-step">
        <div class="step-num">2</div>
        <h3>Strategie & Calendar</h3>
        <p>Creăm o strategie personalizată și un calendar editorial pentru luna următoare.</p>
      </div>
      <div class="collab-step">
        <div class="step-num">3</div>
        <h3>Creare & Publicare</h3>
        <p>Realizăm conținutul, programăm postările și gestionăm interacțiunile zilnic.</p>
      </div>
    </div>

    <div class="note-box">
      <strong>Notă:</strong> Toate pachetele includ consultanță inițială gratuită. Prețurile nu includ bugetul pentru campanii de promovare plătite (Facebook Ads, Instagram Ads). Acesta se stabilește separat, în funcție de obiective.
    </div>
  </div>
</section>

<!-- ===== REELS PREVIEW ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%); padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Reels Recente</h2>
      <p class="section-subtitle">Exemple din conținutul creat de echipa noastră</p>
    </div>

    <div style="text-align: center; margin-top: 40px;">
      <a href="/portofoliu-reels" class="btn-outline">
        Vezi Tot Portofoliul de Reels
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>
</section>
