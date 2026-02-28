<?php
/**
 * Pagina Servicii Foto B2B
 *
 * Variabile disponibile (din PageController::servicii):
 * @var string $title        - titlul paginii
 * @var array  $service      - datele serviciului din DB
 * @var array  $gallery      - galeria asociata
 * @var array  $galleryItems - elementele galeriei
 * @var array  $pricing      - pachetele de pret
 * @var array  $settings     - setarile site-ului
 */
$metaDescription = 'Servicii foto profesionale B2B: fotografie corporate, comercială, culinară, imobiliară și de produs. Echipamente profesionale, livrare rapidă.';
?>

<?php
$heroType = 'page';
$heroBadge = 'Fotografie Profesională';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>';
$heroTitle = 'Servicii Foto B2B';
$heroSubtitle = 'Fotografie profesională pentru companii și branduri';
include __DIR__ . '/../../components/hero.php';
?>

<!-- ===== CATEGORII FOTOGRAFIE ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%); padding: 80px 0;">
  <div class="container">

    <!-- Corporate & Brand -->
    <div class="content-grid">
      <div class="content-text">
        <div class="section-tag">01</div>
        <h2>Fotografie Corporate & Brand</h2>
        <p>Imagini profesionale pentru echipa ta, birouri, evenimente corporate și materiale de marketing. Fotografii care transmit identitatea și valorile brandului tău.</p>
        <ul style="margin-top: 16px; display: flex; flex-direction: column; gap: 8px;">
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Portrete profesionale echipă
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Fotografie de eveniment
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Branding vizual complet
          </li>
        </ul>
      </div>
      <div class="content-visual">
        <svg viewBox="0 0 500 400" style="width:100%;background:#1A2B4A;border-radius:16px;">
          <rect width="500" height="400" fill="#1A2B4A" rx="16"/>
          <text x="250" y="200" text-anchor="middle" fill="#283868" font-size="28" font-family="Inter,sans-serif">Corporate</text>
        </svg>
      </div>
    </div>

    <!-- Comerciala & Industriala -->
    <div class="content-grid reversed" style="margin-top: 80px;">
      <div class="content-text">
        <div class="section-tag">02</div>
        <h2>Fotografie Comercială & Industrială</h2>
        <p>Documentare vizuală pentru spații comerciale, hale industriale, procese de producție și produse tehnice. Imagini care vorbesc despre profesionalism.</p>
        <ul style="margin-top: 16px; display: flex; flex-direction: column; gap: 8px;">
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Fotografie industrială
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Spații comerciale & retail
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Documentare procese
          </li>
        </ul>
      </div>
      <div class="content-visual">
        <svg viewBox="0 0 500 400" style="width:100%;background:#1A2B4A;border-radius:16px;">
          <rect width="500" height="400" fill="#1A2B4A" rx="16"/>
          <text x="250" y="200" text-anchor="middle" fill="#283868" font-size="28" font-family="Inter,sans-serif">Comercial</text>
        </svg>
      </div>
    </div>

    <!-- Culinara & Produs -->
    <div class="content-grid" style="margin-top: 80px;">
      <div class="content-text">
        <div class="section-tag">03</div>
        <h2>Fotografie Culinară & de Produs</h2>
        <p>Imagini apetisante pentru restaurante, catering și producători alimentari. Fotografie de produs pentru cataloage, e-commerce și materiale publicitare.</p>
        <ul style="margin-top: 16px; display: flex; flex-direction: column; gap: 8px;">
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Food photography profesional
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Fotografie de catalog & e-commerce
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Styling & aranjare scene
          </li>
        </ul>
      </div>
      <div class="content-visual">
        <svg viewBox="0 0 500 400" style="width:100%;background:#1A2B4A;border-radius:16px;">
          <rect width="500" height="400" fill="#1A2B4A" rx="16"/>
          <text x="250" y="200" text-anchor="middle" fill="#283868" font-size="28" font-family="Inter,sans-serif">Culinar</text>
        </svg>
      </div>
    </div>

    <!-- Imobiliara & Arhitectura -->
    <div class="content-grid reversed" style="margin-top: 80px;">
      <div class="content-text">
        <div class="section-tag">04</div>
        <h2>Fotografie Imobiliară & Arhitectură</h2>
        <p>Imagini profesionale pentru agenții imobiliare, dezvoltatori și arhitecți. Fotografie interioară și exterioară care valorifică fiecare proprietate.</p>
        <ul style="margin-top: 16px; display: flex; flex-direction: column; gap: 8px;">
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Interior & exterior HDR
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Fotografie aeriană cu drona
          </li>
          <li style="display: flex; align-items: center; gap: 8px; color: #94A3B8;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Twilight & golden hour
          </li>
        </ul>
      </div>
      <div class="content-visual">
        <svg viewBox="0 0 500 400" style="width:100%;background:#1A2B4A;border-radius:16px;">
          <rect width="500" height="400" fill="#1A2B4A" rx="16"/>
          <text x="250" y="200" text-anchor="middle" fill="#283868" font-size="28" font-family="Inter,sans-serif">Imobiliar</text>
        </svg>
      </div>
    </div>

  </div>
</section>

<!-- ===== BENEFICII ===== -->
<section class="content-section" style="padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">De Ce Să Alegi Scanbox?</h2>
    </div>
    <div class="services-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
      <div class="service-card">
        <div class="service-icon teal">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="6" y="14" width="36" height="24" rx="2"/><path d="M16 14V8h16v6"/></svg>
        </div>
        <h3>Echipamente Pro</h3>
        <p>Camere full-frame, obiective profesionale, sisteme de iluminare studio și drona pentru fotografii aeriene.</p>
      </div>
      <div class="service-card">
        <div class="service-icon blue">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="24" cy="24" r="16"/><polyline points="24 14 24 24 32 28"/></svg>
        </div>
        <h3>Livrare Rapidă</h3>
        <p>Fotografiile editate și optimizate sunt livrate în 48-72 ore de la sesiunea foto.</p>
      </div>
      <div class="service-card">
        <div class="service-icon teal">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M24 4l6 12h14l-11 8 4 14-13-9-13 9 4-14L4 16h14z"/></svg>
        </div>
        <h3>Post-Producție Pro</h3>
        <p>Editare avansată, retușare, color grading și optimizare pentru web și print.</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== GALERIE ===== -->
<?php if (!empty($galleryItems)): ?>
<section class="content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%); padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Galerie Foto</h2>
      <p class="section-subtitle">O selecție din proiectele noastre recente</p>
    </div>
    <?php include __DIR__ . '/../../components/gallery-grid.php'; ?>
  </div>
</section>
<?php endif; ?>

<!-- ===== PRICING ===== -->
<?php if (!empty($pricing)):
    $pricingTitle = 'Pachete Fotografie';
    $pricingSubtitle = 'Tarife transparente, fără costuri ascunse';
    include __DIR__ . '/../../components/pricing-table.php';
endif; ?>
