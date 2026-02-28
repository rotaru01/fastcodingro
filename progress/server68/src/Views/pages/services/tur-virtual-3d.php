<?php
/**
 * Pagina Tur Virtual 3D Matterport
 *
 * Variabile disponibile (din PageController::servicii):
 * @var string $title        - titlul paginii
 * @var array  $service      - datele serviciului din DB
 * @var array  $gallery      - galeria asociata
 * @var array  $galleryItems - elementele galeriei
 * @var array  $pricing      - pachetele de pret
 * @var array  $settings     - setarile site-ului
 */
$metaDescription = 'Tur virtual 3D Matterport profesional pentru imobiliare, hoteluri, restaurante, showroom-uri și spații comerciale. Reseller oficial Matterport România.';
?>

<?php
$heroType = 'page';
$heroBadge = 'Reseller Oficial Matterport';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>';
$heroTitle = 'Tur Virtual 3D Matterport';
$heroSubtitle = 'Experiențe imersive care transformă modul în care clienții tăi descoperă spațiile';
include __DIR__ . '/../../components/hero.php';
?>

<!-- ===== INTRO SECTION ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%); padding: 80px 0;">
  <div class="container">
    <div class="content-grid">
      <div class="content-text">
        <div class="section-tag">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
          Ce este un Tur Virtual 3D?
        </div>
        <h2>Prezintă-ți Spațiul în Mod Interactiv</h2>
        <p>Turul virtual 3D Matterport permite vizitatorilor să exploreze spațiul tău ca și cum ar fi acolo. Tehnologia noastră de ultimă generație creează o replică digitală completă, oferind o experiență imersivă unică.</p>
        <p>Ca reseller oficial Matterport în România, utilizăm cele mai performante echipamente pentru a livra rezultate de cea mai înaltă calitate.</p>
        <a href="/contact" class="btn-primary" style="display: inline-flex; margin-top: 20px;">
          Solicită o Demonstrație
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
      <div class="content-visual">
        <?php if (!empty($service['featured_image'])): ?>
        <img src="<?= htmlspecialchars($service['featured_image']) ?>" alt="Tur Virtual 3D Matterport" loading="lazy" style="border-radius: 16px;">
        <?php else: ?>
        <svg viewBox="0 0 500 400" style="width:100%;background:#1A2B4A;border-radius:16px;">
          <rect width="500" height="400" fill="#1A2B4A" rx="16"/>
          <text x="250" y="180" text-anchor="middle" fill="#283868" font-size="32" font-family="Inter,sans-serif">MATTERPORT</text>
          <text x="250" y="220" text-anchor="middle" fill="#394E75" font-size="18" font-family="Inter,sans-serif">Tur Virtual 3D</text>
        </svg>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- ===== AVANTAJE ===== -->
<section class="content-section" style="padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        Avantaje
      </span>
      <h2 class="section-title">De Ce Tur Virtual Matterport?</h2>
    </div>

    <div class="services-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
      <div class="service-card">
        <div class="service-icon teal">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="24" cy="24" r="16"/><path d="M24 8v32M8 24h32"/></svg>
        </div>
        <h3>Vizualizare 360°</h3>
        <p>Explorare completă a spațiului din orice unghi, cu navigare intuitivă și fluidă.</p>
      </div>
      <div class="service-card">
        <div class="service-icon blue">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="6" y="10" width="36" height="28" rx="3"/><path d="M6 18h36"/><circle cx="15" cy="14" r="2"/></svg>
        </div>
        <h3>Planimetrie & Măsurători</h3>
        <p>Generare automată de planuri de etaj și posibilitatea de a lua măsurători precise direct din tur.</p>
      </div>
      <div class="service-card">
        <div class="service-icon teal">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M24 4v40M4 24h40"/><circle cx="24" cy="24" r="20"/></svg>
        </div>
        <h3>Integrare Web</h3>
        <p>Turul virtual se integrează ușor în site-ul tău, pe Google Maps sau pe platforme imobiliare.</p>
      </div>
      <div class="service-card">
        <div class="service-icon mixed">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 8h24l6 12-18 24L6 20z"/></svg>
        </div>
        <h3>Calitate Superioară</h3>
        <p>Imagini HDR de înaltă rezoluție cu detalii excepționale și culori naturale.</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== GALERIE ===== -->
<?php if (!empty($galleryItems)): ?>
<section class="content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%); padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Portofoliu Tur Virtual</h2>
      <p class="section-subtitle">Exemple din proiectele noastre recente</p>
    </div>
    <?php include __DIR__ . '/../../components/gallery-grid.php'; ?>
  </div>
</section>
<?php endif; ?>

<!-- ===== DOMENII DE UTILIZARE ===== -->
<section class="content-section" style="padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Domenii de Utilizare</h2>
    </div>

    <div class="content-grid">
      <div class="content-text">
        <h3>Imobiliare & Arhitectură</h3>
        <p>Apartamente, case, vile, birouri, spații comerciale. Clienții pot vizita proprietatea de oriunde, economisind timp și crescând rata de conversie.</p>
      </div>
      <div class="content-visual">
        <svg viewBox="0 0 400 250" style="width:100%;background:#1A2B4A;border-radius:16px;">
          <rect width="400" height="250" fill="#1A2B4A" rx="16"/>
          <text x="200" y="125" text-anchor="middle" fill="#283868" font-size="24" font-family="Inter,sans-serif">Imobiliare</text>
        </svg>
      </div>
    </div>

    <div class="content-grid reversed" style="margin-top: 60px;">
      <div class="content-text">
        <h3>Hoteluri & Restaurante</h3>
        <p>Arată-le oaspeților exact ce îi așteaptă. Tururile virtuale cresc încrederea și rezervările, oferind transparență completă.</p>
      </div>
      <div class="content-visual">
        <svg viewBox="0 0 400 250" style="width:100%;background:#1A2B4A;border-radius:16px;">
          <rect width="400" height="250" fill="#1A2B4A" rx="16"/>
          <text x="200" y="125" text-anchor="middle" fill="#283868" font-size="24" font-family="Inter,sans-serif">HoReCa</text>
        </svg>
      </div>
    </div>

    <div class="content-grid" style="margin-top: 60px;">
      <div class="content-text">
        <h3>Showroom-uri & Muzee</h3>
        <p>Transformă-ți showroom-ul sau muzeul într-o experiență digitală accesibilă 24/7, din orice colț al lumii.</p>
      </div>
      <div class="content-visual">
        <svg viewBox="0 0 400 250" style="width:100%;background:#1A2B4A;border-radius:16px;">
          <rect width="400" height="250" fill="#1A2B4A" rx="16"/>
          <text x="200" y="125" text-anchor="middle" fill="#283868" font-size="24" font-family="Inter,sans-serif">Showroom</text>
        </svg>
      </div>
    </div>
  </div>
</section>

<!-- ===== PRICING ===== -->
<?php if (!empty($pricing)):
    $pricingTitle = 'Pachete Tur Virtual 3D';
    $pricingSubtitle = 'Alege pachetul potrivit pentru spațiul tău';
    include __DIR__ . '/../../components/pricing-table.php';
endif; ?>
