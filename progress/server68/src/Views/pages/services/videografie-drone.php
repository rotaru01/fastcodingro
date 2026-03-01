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
$metaDescription = 'Scanbox.ro produce conținut video profesional B2B in București: clipuri prezentare companie, interviuri, testimoniale, video imobiliare cu dronă și reels social media. Filmări 4K/6K, editare cinematică, livrare optimizată. Prețuri de la 200 euro.';
?>

<?php
$heroType = 'page';
$heroBadge = 'Videografie Profesională B2B';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>';
$heroTitle = 'Servicii Video B2B';
$heroSubtitle = 'Producem conținut video profesional care prezintă afacerea ta la cel mai înalt nivel — de la conceptualizare la livrarea finală.';
include __DIR__ . '/../../components/hero.php';
?>

<!-- ===== EQUIPMENT MENTION ===== -->
<section class="content-section" lang="ro" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 100%);">
  <div class="container">
    <p style="border-left: 3px solid #04B494; padding-left: 16px; color: #CBD5E1; font-size: 15px; line-height: 1.8; margin: 24px 0;">
      Scanbox.ro produce conținut video profesional B2B in București: filmări 4K/6K cu camere cinema, aeriene cu drone DJI, editare cinematică și color grading. Clipuri Social Media de la 200 euro, prezentări de la 400 euro, filme cinematice de la 700 euro, cu muzică licențiată și livrare optimizată.
    </p>
    <div class="section-header">
      <span class="section-tag">Echipament profesional</span>
      <h2 class="section-title">Calitate premium, de la echipament la livrare</h2>
    </div>
    <div style="max-width: 820px; margin: 0 auto; text-align: center;">
      <p style="font-size: 17px; color: #94A3B8; line-height: 1.8; margin-bottom: 24px;">
        Utilizăm echipamente profesionale de ultimă generație — camere cinema, lumini de studio, promptere, microfoane lavalieră și tot ce este necesar ca să iasă materiale premium. Fiecare proiect este tratat cu aceeași atenție la detaliu, indiferent de complexitate.
      </p>
      <p style="font-size: 17px; color: #E2E8F0; line-height: 1.8; font-weight: 500;">
        Rezultatul? Materiale video de calitate superioară care poziționează brandul tău exact acolo unde merită.
      </p>
    </div>
    <div class="stats-grid" style="grid-template-columns: repeat(4, 1fr); margin-top: 48px;">
      <div class="stat-item">
        <div style="margin-bottom: 12px;">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
        </div>
        <div class="stat-label" style="font-size: 14px; color: #E2E8F0; font-weight: 600;">Camere Cinema</div>
      </div>
      <div class="stat-item">
        <div style="margin-bottom: 12px;">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        </div>
        <div class="stat-label" style="font-size: 14px; color: #E2E8F0; font-weight: 600;">Lumini Studio</div>
      </div>
      <div class="stat-item">
        <div style="margin-bottom: 12px;">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1a3 3 0 00-3 3v8a3 3 0 006 0V4a3 3 0 00-3-3z"/><path d="M19 10v2a7 7 0 01-14 0v-2"/><line x1="12" y1="19" x2="12" y2="23"/><line x1="8" y1="23" x2="16" y2="23"/></svg>
        </div>
        <div class="stat-label" style="font-size: 14px; color: #E2E8F0; font-weight: 600;">Lavaliere Audio</div>
      </div>
      <div class="stat-item">
        <div style="margin-bottom: 12px;">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <div class="stat-label" style="font-size: 14px; color: #E2E8F0; font-weight: 600;">Promptere</div>
      </div>
    </div>
  </div>
</section>

<!-- ===== CATEGORY 1: Video Prezentare Companie ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #1A2B4A 0%, #1d3155 100%);">
  <div class="container">
    <div class="content-grid">
      <div class="content-text">
        <h3>Video Prezentare Companie</h3>
        <h2>Povestea companiei tale, spusă profesional</h2>
        <p>
          Un video de prezentare profesional este cartea de vizită a companiei tale în mediul digital. Creăm clipuri care surprind esența businessului — valorile, echipa, procesele și produsele — într-un format captivant și memorabil.
        </p>
        <ul>
          <li>Clip de prezentare pentru website și social media</li>
          <li>Video corporate pentru evenimente și conferințe</li>
          <li>Prezentare servicii și procese interne</li>
          <li>Storytelling vizual pentru brand awareness</li>
        </ul>
        <a href="/contact" class="btn-primary btn-sm">
          Solicită ofertă
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
      <div class="content-visual">
        <iframe
          src="https://www.youtube.com/embed/ZbMwcPjQomU"
          title="Video Prezentare Companie — Scanbox.ro"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          allowfullscreen>
        </iframe>
      </div>
    </div>
  </div>
</section>

<!-- ===== CATEGORY 2: Video Interviu & Testimonial ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #1d3155 0%, #1A2B4A 100%);">
  <div class="container">
    <div class="content-grid reversed">
      <div class="content-text">
        <h3>Video Interviu & Testimonial</h3>
        <h2>Lasă clienții și echipa să vorbească pentru tine</h2>
        <p>
          Interviurile video și testimonialele sunt cele mai puternice instrumente de construcție a încrederii. Filmăm interviuri cu membrii echipei, clienți mulțumiți sau parteneri — într-un cadru profesional, cu sunet clar și imagine de calitate cinematografică.
        </p>
        <ul>
          <li>Testimoniale clienți pentru website și campanii</li>
          <li>Interviuri cu management și echipă</li>
          <li>Video Q&A pentru social media</li>
          <li>Studii de caz video cu rezultate concrete</li>
        </ul>
        <a href="/contact" class="btn-primary btn-sm">
          Solicită ofertă
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
      <div class="content-visual" style="flex-direction: column; gap: 0;">
        <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px;">
          <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.4; margin-bottom: 20px;">
            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4-4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
          </svg>
          <p style="font-size: 16px; color: #94A3B8; text-align: center; line-height: 1.6;">Video interviuri realizate cu echipament profesional, lumini de studio și microfoane lavalieră.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== CATEGORY 3: Video Prezentare Imobiliare ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #1A2B4A 0%, #1d3155 100%);">
  <div class="container">
    <div class="content-grid">
      <div class="content-text">
        <h3>Video Prezentare Imobiliare</h3>
        <h2>Transformă proprietățile în experiențe vizuale</h2>
        <p>
          Un video imobiliar profesional poate face diferența între o proprietate care stă pe piață și una care se vinde rapid. Filmăm proprietăți rezidențiale și comerciale cu mișcări fluide de cameră, lumină naturală și editare cinematografică.
        </p>
        <ul>
          <li>Video walkthrough pentru proprietăți rezidențiale</li>
          <li>Prezentări video pentru dezvoltatori imobiliari</li>
          <li>Filmări aeriene cu dronă pentru perspective unice</li>
          <li>Video pentru campanii de marketing imobiliar</li>
        </ul>
        <a href="/contact" class="btn-primary btn-sm">
          Solicită ofertă
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
      <div class="content-visual" style="flex-direction: column; gap: 0;">
        <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px;">
          <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.4; margin-bottom: 20px;">
            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
          </svg>
          <p style="font-size: 16px; color: #94A3B8; text-align: center; line-height: 1.6;">Video prezentări imobiliare cu mișcări cinematografice și filmări aeriene cu dronă.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== CATEGORY 4: Reels Video Social Media ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #1d3155 0%, #1A2B4A 100%);">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Social Media</span>
      <h2 class="section-title">Reels Video Social Media</h2>
      <p class="section-subtitle">Conținut video vertical, dinamic și captivant — creat special pentru Instagram, TikTok și Facebook Reels.</p>
    </div>
    <div class="reels-grid">
      <div class="reel-item">
        <iframe
          src="https://www.instagram.com/reel/C1HAzZhIs_0/embed"
          title="Scanbox Reel 1"
          allowfullscreen>
        </iframe>
      </div>
      <div class="reel-item">
        <iframe
          src="https://www.instagram.com/reel/C0gOfOgo1FM/embed"
          title="Scanbox Reel 2"
          allowfullscreen>
        </iframe>
      </div>
      <div class="reel-item">
        <iframe
          src="https://www.instagram.com/reel/DKwYH4ZsgCB/embed"
          title="Scanbox Reel 3"
          allowfullscreen>
        </iframe>
      </div>
      <div class="reel-item">
        <iframe
          src="https://www.instagram.com/reel/DT4y8oeAhqR/embed"
          title="Scanbox Reel 4"
          allowfullscreen>
        </iframe>
      </div>
    </div>
  </div>
</section>

<!-- ===== CTA BANNER ===== -->
<section class="cta-section" style="background: linear-gradient(180deg, #1A2B4A 0%, #152540 100%);">
  <div class="container">
    <div class="cta-banner">
      <h2>Pregătit pentru un video profesional?</h2>
      <p>Contactează-ne și hai să creăm împreună conținut video care face diferența pentru brandul tău.</p>
      <a href="/contact" class="btn-white">
        Contactează-ne
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
          <span itemprop="name">Ce servicii video oferă Scanbox?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding: 0 24px 20px; color: #94A3B8; font-size: 15px; line-height: 1.8;">
            Filmări 4K/6K, aeriene cu drone DJI, editare cinematică, color grading. Clipuri Social Media (30-60s), prezentări (1-2min), filme cinematice (2-3min).
          </div>
        </div>
      </div>
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <button class="faq-toggle">
          <span itemprop="name">Cât costă un video profesional?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding: 0 24px 20px; color: #94A3B8; font-size: 15px; line-height: 1.8;">
            Clip Scurt: de la 200&euro;. Prezentare: de la 400&euro;. Cinematic: de la 700&euro;. Include muzică licențiată și livrare optimizată.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
