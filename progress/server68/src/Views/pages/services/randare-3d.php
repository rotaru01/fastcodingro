<?php
/**
 * Pagina Randare 3D
 *
 * Variabile disponibile (din PageController::servicii):
 * @var string $title        - titlul paginii
 * @var array  $service      - datele serviciului din DB
 * @var array  $gallery      - galeria asociata
 * @var array  $galleryItems - elementele galeriei
 * @var array  $pricing      - pachetele de pret
 * @var array  $settings     - setarile site-ului
 */
$metaDescription = 'Servicii de randare 3D fotorealistă pentru arhitectură, design interior și dezvoltări imobiliare. Vizualizări care vând înainte de construcție.';
?>

<?php
$heroType = 'page';
$heroBadge = 'Vizualizare 3D';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>';
$heroTitle = 'Randare 3D';
$heroSubtitle = 'Vizualizări fotorealiste care dau viață proiectelor tale';
include __DIR__ . '/../../components/hero.php';
?>

<!-- ===== INTRO ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%); padding: 80px 0;">
  <div class="container">
    <div class="content-grid">
      <div class="content-text">
        <h2>Ce Este Randarea 3D?</h2>
        <p>Randarea 3D transformă planurile și schițele tehnice în imagini fotorealiste sau animații care prezintă proiectul înainte de construcție. O unealtă esențială pentru arhitecți, designeri și dezvoltatori imobiliari.</p>
        <p>Folosim software-uri profesionale și tehnici avansate de iluminare și materiale pentru a obține rezultate care nu se deosebesc de fotografii reale.</p>
        <a href="/contact" class="btn-primary" style="display: inline-flex; margin-top: 20px;">
          Solicită Randare 3D
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
      <div class="content-visual">
        <svg viewBox="0 0 500 400" style="width:100%;background:#1A2B4A;border-radius:16px;">
          <rect width="500" height="400" fill="#1A2B4A" rx="16"/>
          <text x="250" y="180" text-anchor="middle" fill="#283868" font-size="32" font-family="Inter,sans-serif">RANDARE 3D</text>
          <text x="250" y="220" text-anchor="middle" fill="#394E75" font-size="18" font-family="Inter,sans-serif">Fotorealist</text>
        </svg>
      </div>
    </div>
  </div>
</section>

<!-- ===== BENEFICII ===== -->
<section class="content-section" style="padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Beneficii Randare 3D</h2>
    </div>

    <div class="services-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
      <div class="service-card">
        <div class="service-icon teal">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M24 4l20 12v16L24 44 4 32V16z"/></svg>
        </div>
        <h3>Vizualizare Realistă</h3>
        <p>Imagini fotorealiste cu iluminare naturală, materiale autentice și detalii fine.</p>
      </div>
      <div class="service-card">
        <div class="service-icon blue">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="24" cy="24" r="16"/><path d="M16 24l6 6 10-12"/></svg>
        </div>
        <h3>Economie de Timp</h3>
        <p>Prezintă proiectul clienților fără a aștepta finalizarea construcției.</p>
      </div>
      <div class="service-card">
        <div class="service-icon teal">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="6" y="6" width="36" height="36" rx="4"/><path d="M6 18h36M18 6v36"/></svg>
        </div>
        <h3>Flexibilitate</h3>
        <p>Modificări rapide de materiale, culori, mobilier și aranjamente fără costuri de construcție.</p>
      </div>
      <div class="service-card">
        <div class="service-icon mixed">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M8 36l12-16 8 10 12-18"/><rect x="4" y="4" width="40" height="40" rx="2"/></svg>
        </div>
        <h3>Marketing Puternic</h3>
        <p>Materiale vizuale impresionante pentru broșuri, site-uri web și prezentări.</p>
      </div>
      <div class="service-card">
        <div class="service-icon blue">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="24" cy="24" r="20"/><path d="M24 14v10l8 4"/></svg>
        </div>
        <h3>Livrare Rapidă</h3>
        <p>Termen de livrare optimizat, cu revizii incluse în fiecare pachet.</p>
      </div>
      <div class="service-card">
        <div class="service-icon teal">
          <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 24h40M24 4v40"/><circle cx="24" cy="24" r="8"/></svg>
        </div>
        <h3>Rezoluție Maximă</h3>
        <p>Randări în rezoluție înaltă, pregătite pentru print, web sau panouri publicitare.</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== CAZURI DE UTILIZARE ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%); padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Domenii de Aplicare</h2>
    </div>

    <div class="content-grid">
      <div class="content-text">
        <h3>Arhitectură</h3>
        <p>Randări exterioare și interioare pentru proiecte arhitecturale: clădiri rezidențiale, birouri, spații comerciale. Vizualizări care surprind esența designului.</p>
      </div>
      <div class="content-visual">
        <svg viewBox="0 0 400 250" style="width:100%;background:#0D1B2A;border-radius:16px;">
          <rect width="400" height="250" fill="#0D1B2A" rx="16"/>
          <text x="200" y="125" text-anchor="middle" fill="#1A2B4A" font-size="24" font-family="Inter,sans-serif">Arhitectură</text>
        </svg>
      </div>
    </div>

    <div class="content-grid reversed" style="margin-top: 60px;">
      <div class="content-text">
        <h3>Design Interior</h3>
        <p>Vizualizări interioare cu mobilier, materiale și iluminare personalizate. Clientul vede cum va arăta spațiul finalizat înainte de a începe amenajarea.</p>
      </div>
      <div class="content-visual">
        <svg viewBox="0 0 400 250" style="width:100%;background:#0D1B2A;border-radius:16px;">
          <rect width="400" height="250" fill="#0D1B2A" rx="16"/>
          <text x="200" y="125" text-anchor="middle" fill="#1A2B4A" font-size="24" font-family="Inter,sans-serif">Design Interior</text>
        </svg>
      </div>
    </div>

    <div class="content-grid" style="margin-top: 60px;">
      <div class="content-text">
        <h3>Dezvoltări Imobiliare</h3>
        <p>Prezentări complete pentru dezvoltări imobiliare: vederi exterioare, apartamente tip, facilități comune. Instrumente vizuale care accelerează vânzările.</p>
      </div>
      <div class="content-visual">
        <svg viewBox="0 0 400 250" style="width:100%;background:#0D1B2A;border-radius:16px;">
          <rect width="400" height="250" fill="#0D1B2A" rx="16"/>
          <text x="200" y="125" text-anchor="middle" fill="#1A2B4A" font-size="24" font-family="Inter,sans-serif">Dezvoltări Imobiliare</text>
        </svg>
      </div>
    </div>
  </div>
</section>

<!-- ===== GALERIE ===== -->
<?php if (!empty($galleryItems)): ?>
<section class="content-section" style="padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Portofoliu Randare 3D</h2>
    </div>
    <?php include __DIR__ . '/../../components/gallery-grid.php'; ?>
  </div>
</section>
<?php endif; ?>

<!-- ===== PRICING ===== -->
<?php if (!empty($pricing)):
    $pricingTitle = 'Pachete Randare 3D';
    $pricingSubtitle = 'Preturi personalizate in functie de complexitate';
    include __DIR__ . '/../../components/pricing-table.php';
endif; ?>
