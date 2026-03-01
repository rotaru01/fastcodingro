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
$metaDescription = 'Scanbox.ro creează vizualizări 3D fotorealiste și planuri izometrice in București. Randări pentru arhitectură, design interior și dezvoltări imobiliare off-plan. Transformăm planuri tehnice in imagini de inaltă calitate — exterioare, interioare, tururi virtuale pe bază de proiect.';
?>

<?php
$heroType = 'page';
$heroBadge = 'Vizualizare 3D';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>';
$heroTitle = 'Randare 3D';
$heroSubtitle = 'Vizualizări 3D fotorealiste și planuri izometrice';
include __DIR__ . '/../../components/hero.php';
?>

<!-- ===== GENERAL INFO ===== -->
<section class="content-section" lang="ro" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 100%);">
  <div class="container">
    <p style="border-left: 3px solid #04B494; padding-left: 16px; color: #CBD5E1; font-size: 15px; line-height: 1.8; margin: 24px 0;">
      Randarea 3D fotorealistă inseamnă crearea de imagini digitale fotorealiste pornind de la modele 3D. Scanbox.ro transformă planuri tehnice in vizualizări de inaltă calitate pentru dezvoltatori imobiliari, arhitecți, designeri interior și agenții imobiliare cu proprietăți off-plan.
    </p>
    <div class="content-grid">
      <div class="content-text">
        <h3>Ce este Randarea 3D?</h3>
        <h2>Vizualizări Fotorealiste pentru Proiectul Tău</h2>
        <p>Randarea 3D este procesul de creare a imaginilor fotorealiste din modele tridimensionale digitale. Folosind software avansat de randare, transformăm planurile și proiectele tale arhitecturale în imagini de o calitate excepțională, greu de distins de fotografiile reale.</p>
        <p>Fie că ai nevoie de vizualizări exterioare pentru un ansamblu rezidențial, randări interioare pentru un proiect de design sau planuri izometrice detaliate, echipa noastră livrează rezultate la cele mai înalte standarde.</p>
        <a href="/contact" class="btn-primary btn-sm">
          Solicită o Ofertă
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
      <div class="content-visual">
        <div style="padding: 60px; text-align: center;">
          <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.4;">
            <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>
            <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
            <line x1="12" y1="22.08" x2="12" y2="12"/>
          </svg>
          <p style="color: #94A3B8; font-size: 14px; margin-top: 16px;">Vizualizare 3D Fotorealistă</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== FEATURES / BENEFITS ===== -->
<section class="services-section" style="background: linear-gradient(180deg, #1A2B4A 0%, #1d3155 100%);">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Beneficii</span>
      <h2 class="section-title">De ce să alegi Randarea 3D?</h2>
      <p class="section-subtitle">Vizualizările 3D profesionale adaugă valoare proiectelor tale și accelerează procesul de vânzare.</p>
    </div>

    <div class="services-grid">
      <!-- Benefit 1 -->
      <div class="service-card">
        <div class="service-icon teal">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        </div>
        <h3>Fotorealism Excepțional</h3>
        <p>Randările noastre sunt practic imposibil de deosebit de fotografiile reale, oferind clienților o imagine clară a produsului final.</p>
      </div>

      <!-- Benefit 2 -->
      <div class="service-card">
        <div class="service-icon blue">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2D4A7A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <h3>Economisire de Timp</h3>
        <p>Vizualizează proiectul înainte de construcție, reducând costurile și timpul de decizie pentru clienții tăi.</p>
      </div>

      <!-- Benefit 3 -->
      <div class="service-card">
        <div class="service-icon mixed">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20V10"/><path d="M18 20V4"/><path d="M6 20v-4"/></svg>
        </div>
        <h3>Creșterea Vânzărilor</h3>
        <p>Proiectele prezentate cu randări 3D profesionale au o rată de conversie semnificativ mai mare decât cele cu planuri 2D clasice.</p>
      </div>

      <!-- Benefit 4 -->
      <div class="service-card">
        <div class="service-icon teal">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
        </div>
        <h3>Planuri Izometrice</h3>
        <p>Planuri de etaj detaliate în perspectivă izometrică, ideale pentru prezentarea compartimentării și a fluxului spațiilor.</p>
      </div>

      <!-- Benefit 5 -->
      <div class="service-card">
        <div class="service-icon blue">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2D4A7A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        </div>
        <h3>Revizii Nelimitate</h3>
        <p>Lucrăm îndeaproape cu tine până când fiecare detaliu este exact așa cum ți-l dorești, cu modificări incluse.</p>
      </div>

      <!-- Benefit 6 -->
      <div class="service-card">
        <div class="service-icon mixed">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        </div>
        <h3>Formate Multiple</h3>
        <p>Livrăm în toate formatele necesare: JPEG, PNG, TIFF pentru print sau optimizate pentru web și social media.</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== USE CASES ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #1d3155 0%, #1A2B4A 100%);">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Aplicații</span>
      <h2 class="section-title">Unde se utilizează Randarea 3D?</h2>
      <p class="section-subtitle">Vizualizările 3D sunt esențiale în multiple industrii, de la arhitectură la marketing imobiliar.</p>
    </div>

    <!-- Use Case 1: Arhitectură -->
    <div class="content-grid" style="margin-bottom: 80px;">
      <div class="content-text">
        <h3>Arhitectură</h3>
        <h2>Vizualizări Arhitecturale Exterioare și Interioare</h2>
        <p>Transformăm proiectele arhitecturale în imagini fotorealiste care surprind fiecare detaliu, de la texturile materialelor la jocul luminii naturale. Randările noastre arhitecturale ajută la:</p>
        <ul>
          <li>Prezentarea proiectelor în faza de concept pentru aprobare</li>
          <li>Materiale de marketing pentru birouri de arhitectură</li>
          <li>Vizualizări pentru concursuri de arhitectură</li>
          <li>Documentație pentru autorizații de construire</li>
        </ul>
      </div>
      <div class="content-visual">
        <div style="padding: 60px; text-align: center;">
          <svg width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1" style="opacity: 0.4;">
            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
          </svg>
          <p style="color: #94A3B8; font-size: 14px; margin-top: 16px;">Randare Arhitecturală</p>
        </div>
      </div>
    </div>

    <!-- Use Case 2: Design Interior -->
    <div class="content-grid reversed" style="margin-bottom: 80px;">
      <div class="content-text">
        <h3>Design Interior</h3>
        <h2>Vizualizări de Interior cu Fiecare Detaliu</h2>
        <p>Randările de interior dau viață conceptelor de design, permițând clienților să vadă exact cum va arăta spațiul lor înainte de implementare. Serviciile includ:</p>
        <ul>
          <li>Randări fotorealiste de living, dormitor, bucătărie, baie</li>
          <li>Vizualizări cu mobilier și decorațiuni personalizate</li>
          <li>Variante de culori și materiale pentru comparație</li>
          <li>Iluminare naturală și artificială realistă</li>
        </ul>
      </div>
      <div class="content-visual">
        <div style="padding: 60px; text-align: center;">
          <svg width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1" style="opacity: 0.4;">
            <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/>
          </svg>
          <p style="color: #94A3B8; font-size: 14px; margin-top: 16px;">Randare Design Interior</p>
        </div>
      </div>
    </div>

    <!-- Use Case 3: Dezvoltări Imobiliare -->
    <div class="content-grid">
      <div class="content-text">
        <h3>Dezvoltări Imobiliare</h3>
        <h2>Materiale Vizuale pentru Vânzarea Off-Plan</h2>
        <p>Pentru dezvoltatorii imobiliari, randările 3D sunt instrumentul principal de vânzare a proprietăților înainte de finalizarea construcției. Oferim:</p>
        <ul>
          <li>Randări exterioare ale ansamblurilor rezidențiale</li>
          <li>Vizualizări interioare pentru fiecare tip de apartament</li>
          <li>Planuri izometrice detaliate cu cote și suprafețe</li>
          <li>Animații 3D și fly-through-uri pentru prezentări</li>
          <li>Materiale optimizate pentru broșuri, site-uri web și social media</li>
        </ul>
      </div>
      <div class="content-visual">
        <div style="padding: 60px; text-align: center;">
          <svg width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1" style="opacity: 0.4;">
            <path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
          </svg>
          <p style="color: #94A3B8; font-size: 14px; margin-top: 16px;">Vizualizare Ansamblu Rezidențial</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== CTA BANNER ===== -->
<section class="cta-section" style="background: linear-gradient(180deg, #1A2B4A 0%, #152540 100%);">
  <div class="container">
    <div class="cta-banner">
      <h2>Ai un proiect care are nevoie de vizualizări 3D?</h2>
      <p>Contactează-ne pentru o ofertă personalizată. Transformăm ideile tale în imagini fotorealiste.</p>
      <a href="/contact" class="btn-white">
        Cere Ofertă Gratuită
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>
</section>

<!-- ===== FAQ ===== -->
<section class="content-section" lang="ro" style="background: linear-gradient(180deg, #152540 0%, #152540 100%); padding: 80px 0;">
  <div class="container" style="max-width: 800px;">
    <div class="section-header">
      <span class="section-tag">FAQ</span>
      <h2 class="section-title">Întrebări Frecvente</h2>
    </div>
    <div itemscope itemtype="https://schema.org/FAQPage">
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <button class="faq-toggle">
          <span itemprop="name">Ce este randarea 3D fotorealistă?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding: 0 24px 20px; color: #94A3B8; font-size: 15px; line-height: 1.8;">
            Crearea de imagini digitale fotorealiste pornind de la modele 3D. Scanbox transformă planuri tehnice în vizualizări de înaltă calitate &mdash; exterioare, interioare, tururi virtuale pe bază de proiect.
          </div>
        </div>
      </div>
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <button class="faq-toggle">
          <span itemprop="name">Pentru cine sunt utile?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding: 0 24px 20px; color: #94A3B8; font-size: 15px; line-height: 1.8;">
            Dezvoltatori imobiliari, arhitecți, designeri interior, agenții imobiliare (proprietăți off-plan), firme construcții.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
