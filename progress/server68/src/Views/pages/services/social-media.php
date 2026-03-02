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
$metaDescription = 'Scanbox.ro oferă pachete social media lunare in București: administrare platforme de la 250 euro, creare conținut vizual de la 350 euro și soluție completă de la 450 euro. Instagram, Facebook, TikTok, LinkedIn, YouTube — strategie, conținut foto-video și consistență pentru brandul tău.';
$schemaJsonLd = '
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "name": "Social Media Management",
  "description": "Administrare social media, creare conținut vizual și pachete lunare complete pentru afacerea ta.",
  "provider": {
    "@type": "Organization",
    "name": "Scanbox.ro",
    "legalName": "TRIVIT SERVICES S.R.L.",
    "url": "https://scanbox.ro",
    "telephone": "+40740233353",
    "email": "office@scanbox.ro"
  },
  "areaServed": {"@type": "Country", "name": "România"},
  "hasOfferCatalog": {
    "@type": "OfferCatalog",
    "name": "Pachete Social Media",
    "itemListElement": [
      {"@type": "Offer", "name": "ADMIN", "description": "12 postări, calendar editorial, administrare platforme", "price": "250", "priceCurrency": "EUR"},
      {"@type": "Offer", "name": "CREATOR", "description": "12 postări, 4 Reels, sesiune foto-video, strategie", "price": "350", "priceCurrency": "EUR"},
      {"@type": "Offer", "name": "MANAGER", "description": "12 postări, 6 Reels, conținut original, administrare completă", "price": "450", "priceCurrency": "EUR"}
    ]
  }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Ce pachete social media oferă Scanbox?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "3 pachete: ADMIN (250€/lună — 12 postări, calendar editorial), CREATOR (350€/lună — 20 postări, 4 Reels, strategie) și MANAGER (450€/lună — 30 postări, 8 Reels, Stories zilnice, campanii). Prețuri fără buget publicitar."
      }
    },
    {
      "@type": "Question",
      "name": "Pentru ce platforme?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Instagram, Facebook, TikTok, LinkedIn, YouTube. Specializare pe branduri din imobiliare, HoReCa, retail și sport."
      }
    }
  ]
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type": "ListItem", "position": 1, "name": "Acasă", "item": "https://scanbox.ro"},
    {"@type": "ListItem", "position": 2, "name": "Social Media", "item": "https://scanbox.ro/social-media.html"}
  ]
}
</script>
';

$extraCss = '
.slogan-text{font-size:clamp(32px,5vw,56px);font-weight:800;letter-spacing:4px;text-transform:uppercase;background:linear-gradient(90deg,#04B494,#039B7E,#04B494);background-size:200% auto;-webkit-background-clip:text;-webkit-text-fill-color:transparent;animation:gradientShift 4s linear infinite;margin-bottom:16px}
.collab-steps{display:grid;grid-template-columns:repeat(3,1fr);gap:28px;margin-top:40px}
.collab-step{background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.06);border-radius:24px;padding:32px 24px;text-align:center;transition:all 0.4s}
.collab-step:hover{transform:translateY(-6px);background:rgba(255,255,255,0.07)}
.collab-step .num{width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,rgba(4,180,148,0.15),rgba(3,155,126,0.08));border:1px solid rgba(4,180,148,0.2);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:20px;font-weight:800;background-clip:padding-box}
.collab-step .num span{background:linear-gradient(90deg,#04B494,#039B7E);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.collab-step h3{font-size:18px;font-weight:700;margin-bottom:10px}
.collab-step p{font-size:14px;color:#94A3B8;line-height:1.7}
.note-box{background:rgba(4,180,148,0.08);border:1px solid rgba(4,180,148,0.2);border-radius:16px;padding:24px;margin-top:40px;text-align:center}
.note-box p{font-size:15px;color:#E2E8F0;line-height:1.7}
@media(max-width:768px){.collab-steps{grid-template-columns:1fr}}
';
?>

<?php
$heroType = 'page';
$heroStyle = 'min-height:60vh';
$heroTitle = 'Social Media';
$heroSubtitleHtml = 'Ce înseamnă Social Media în realitate! Îți spunem noi!<br><strong style="color:#E2E8F0">Strategie, Conținut, Consistență</strong>';
$heroSloganText = 'WE ARE YOUR CONTENT CREATORS';
$heroButtons = [
  ['text' => 'Vezi exemple de conținut', 'href' => '/portofoliu-reels', 'class' => 'btn-primary', 'icon' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>'],
  ['text' => 'Vezi prețurile noastre', 'href' => '#pachete', 'class' => 'btn-outline', 'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>'],
];
?>
<!-- HERO -->
<section class="page-hero" style="min-height:60vh">
  <div class="hero-blob hero-blob-1"></div>
  <div class="hero-blob hero-blob-2"></div>
  <div class="page-hero-content">
    <div class="slogan-text">WE ARE YOUR CONTENT CREATORS</div>
    <h1>Social Media</h1>
    <p>Ce înseamnă Social Media în realitate! Îți spunem noi!<br><strong style="color:#E2E8F0">Strategie, Conținut, Consistență</strong></p>
    <div class="hero-buttons" style="margin-top:24px">
      <a href="/portofoliu-reels" class="btn-primary">Vezi exemple de conținut <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
      <a href="#pachete" class="btn-outline">Vezi prețurile noastre <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg></a>
    </div>
  </div>
</section>

<!-- INTRO -->
<section class="content-section" lang="ro" style="background:linear-gradient(180deg,#0D1B2A,#152540)">
  <div class="container" style="max-width:800px;text-align:center">
    <p style="border-left: 3px solid #04B494; padding-left: 16px; color: #CBD5E1; font-size: 15px; line-height: 1.8; margin: 24px 0; text-align: left;">
      Scanbox.ro oferă pachete social media lunare in București: administrare platforme de la 250 euro/lună, creare conținut vizual de la 350 euro/lună și soluție completă de la 450 euro/lună. Acoperim Instagram, Facebook, TikTok, LinkedIn și YouTube cu strategie, conținut foto-video original și consistență.
    </p>
    <p style="font-size:17px;color:#94A3B8;line-height:1.8;margin-bottom:16px">Prezența în social media nu înseamnă doar postări constante. Înseamnă direcție, coerență vizuală și conținut care susține poziționarea brandului.</p>
    <p style="font-size:17px;color:#94A3B8;line-height:1.8;margin-bottom:16px">Felul în care arată și comunică brandul tău influențează direct încrederea, poziționarea și interacțiunea cu viitorii tăi clienți.</p>
    <p style="font-size:17px;color:#E2E8F0;line-height:1.8">Fie că ai nevoie de administrare profesionistă, de conținut vizual nou sau de o soluție completă „la cheie", îți construim o prezență online care arată bine, comunică clar și susține obiectivele businessului tău!</p>
  </div>
</section>

<!-- SERVICES -->
<section class="services-section" id="servicii" style="background:linear-gradient(180deg,#152540,#1A2B4A)">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Ce oferim</span>
      <h2 class="section-title">Servicii Social Media</h2>
    </div>
    <div class="services-grid" style="grid-template-columns:repeat(3,1fr)">
      <div class="service-card">
        <div class="service-icon teal"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg></div>
        <h3>Administrare Social Media</h3>
        <p>Soluția potrivită pentru companiile care nu au timp de „stat pe net". Tu creezi. Noi gestionăm prezența în online! Dacă ai materialele foto-video pregătite, ne ocupăm de partea operațională: organizare, programare, scriere de texte, publicare.</p>
      </div>
      <div class="service-card">
        <div class="service-icon mixed"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
        <h3>Creare de Conținut Vizual</h3>
        <p>Ideal pentru brandurile care au deja o strategie, dar au nevoie de conținut profesionist. Realizăm materiale foto-video adaptate platformelor sociale, gândite să atragă atenția și să susțină identitatea brandului tău.</p>
      </div>
      <div class="service-card">
        <div class="service-icon blue"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#6B8ACA" stroke-width="2"><path d="M12 20V10"/><path d="M18 20V4"/><path d="M6 20v-4"/></svg></div>
        <h3>Administrare + Creare Conținut</h3>
        <p>Soluția completă pentru afaceri care vor consistență, estetică și eficiență. Planificăm, creăm și administrăm tot conținutul online într-un flux unitar. Este opțiunea ideală pentru companiile care înțeleg că social media este un canal strategic.</p>
      </div>
    </div>
  </div>
</section>

<!-- PRICING -->
<section class="pricing-section" id="pachete" style="background:linear-gradient(180deg,#1A2B4A,#1d3155)">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Pachete Lunare</span>
      <h2 class="section-title">Prețuri corecte, rezultate reale</h2>
      <p class="section-subtitle">Alege pachetul potrivit pentru businessul tău.</p>
    </div>
    <div class="pricing-grid">
      <!-- ADMIN -->
      <div class="pricing-card">
        <h3>ADMIN</h3>
        <div class="price">250€</div>
        <div class="price-period">+ TVA / lună</div>
        <p class="price-desc">Administrăm platformele și prelucrăm materialele foto-video puse la dispoziție de tine.</p>
        <ul class="pricing-features">
          <li>12 postări lunare</li>
          <li>Administrare platforme</li>
          <li>Materialele clientului</li>
          <li>Grafică pentru postări</li>
          <li>Texte și descrieri postări</li>
          <li>Calendar de postări dedicat</li>
          <li>Acces online la livrabile</li>
          <li>Raport lunar de activitate</li>
        </ul>
        <a href="/contact" class="btn-outline btn-sm" style="width:100%;justify-content:center">Solicită Ofertă</a>
      </div>
      <!-- CREATOR -->
      <div class="pricing-card featured">
        <h3>CREATOR</h3>
        <div class="price">350€</div>
        <div class="price-period">+ TVA / lună</div>
        <p class="price-desc">Realizăm conținutul vizual foto-video necesar pentru o lună, iar tu te ocupi de administrare.</p>
        <ul class="pricing-features">
          <li>12 postări lunare</li>
          <li>4 Reels lunare</li>
          <li>Sesiune foto-video 2 ore / lună</li>
          <li>Scenarii clipuri video</li>
          <li>Înregistrare, filmare, editare</li>
          <li>Livrare materiale în 48 ore</li>
        </ul>
        <a href="/contact" class="btn-primary btn-sm" style="width:100%;justify-content:center">Solicită Ofertă</a>
      </div>
      <!-- MANAGER -->
      <div class="pricing-card">
        <h3>MANAGER</h3>
        <div class="price">450€</div>
        <div class="price-period">+ TVA / lună</div>
        <p class="price-desc">Noi facem totul! Scenarii, idei, filmări, fotografii, descrieri, postare și administrare.</p>
        <ul class="pricing-features">
          <li>12 postări lunare</li>
          <li>6 Reels lunare</li>
          <li>Sesiune foto-video 3 ore / lună</li>
          <li>Conținut foto/video original</li>
          <li>Scenarii clipuri video</li>
          <li>Înregistrare, filmare, editare</li>
          <li>Administrare platforme</li>
          <li>Grafică pentru postări</li>
          <li>Texte și descrieri postări</li>
          <li>Calendar de postări dedicat</li>
          <li>Acces online la livrabile</li>
          <li>Raport lunar de activitate</li>
        </ul>
        <a href="/contact" class="btn-outline btn-sm" style="width:100%;justify-content:center">Solicită Ofertă</a>
      </div>
    </div>
    <div class="note-box">
      <p>Numărul postărilor lunare se poate adapta în funcție de bugetul alocat, astfel încât să obținem o prezență online coerentă, cu performanțe ridicate.</p>
      <p style="margin-top:12px;color:#94A3B8">Dacă nu vrei să apari în fața camerei, nu este nicio problemă! Venim noi cu actori și influenceri care să îți prezinte afacerea, serviciile și produsele într-o manieră elegantă și profesionistă.</p>
    </div>
  </div>
</section>

<!-- CUM FUNCȚIONEAZĂ -->
<section class="content-section" style="background:linear-gradient(180deg,#1d3155,#1A2B4A);padding:100px 0">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Proces</span>
      <h2 class="section-title">Cum Funcționează Colaborarea</h2>
    </div>
    <div class="collab-steps">
      <div class="collab-step">
        <div class="num"><span>1</span></div>
        <h3>Strategie & Poziționare</h3>
        <p>Începem cu o discuție aplicată despre obiective, public și nivelul la care vrei să îți poziționezi brandul. Nu vorbim acum despre postări, doar despre percepția publicului tău.</p>
      </div>
      <div class="collab-step">
        <div class="num"><span>2</span></div>
        <h3>Concept & Execuție</h3>
        <p>Construim planul editorial și producem conținutul vizual. Fie că lucrăm cu materialele tale sau le creăm de la zero, totul este coordonat unitar, vizual și estetic, aliniat cu brandul tău.</p>
      </div>
      <div class="collab-step">
        <div class="num"><span>3</span></div>
        <h3>Implementare & Optimizare</h3>
        <p>Planificăm și monitorizăm evoluția postărilor și ajustăm acolo unde este necesar. Comunicarea rămâne coerentă, ritmul este controlat, iar imaginea brandului tău este gestionată profesionist.</p>
      </div>
    </div>
  </div>
</section>

<!-- REELS PREVIEW -->
<section class="content-section" style="background:linear-gradient(180deg,#1A2B4A,#172e52)">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Portofoliu</span>
      <h2 class="section-title">Exemple de Conținut</h2>
      <p class="section-subtitle">O selecție din conținutul creat pentru clienții noștri.</p>
    </div>
    <div class="reels-grid" style="max-width:900px;margin:0 auto">
      <div class="reel-item"><blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/reel/DT4y8oeAhqR/" data-instgrm-version="14" style="width:100%;margin:0"></blockquote></div>
      <div class="reel-item"><blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/reel/DUoBChhDIa0/" data-instgrm-version="14" style="width:100%;margin:0"></blockquote></div>
    </div>
    <div style="text-align:center;margin-top:40px">
      <a href="/portofoliu-reels" class="btn-outline">Vezi mai multe Reel-uri <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section" style="background:linear-gradient(180deg,#172e52,#152540)">
  <div class="container">
    <div class="cta-banner">
      <h2>Pregătit pentru o prezență online profesionistă?</h2>
      <p>Contactează-ne și hai să construim împreună strategia de social media potrivită brandului tău.</p>
      <a href="/contact" class="btn-white">Contactează-ne <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    </div>
  </div>
</section>

<!-- ===== GALERIE DINAMICA ===== -->
<?php if (!empty($galleryItems)): ?>
<section class="content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%); padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Portofoliu</span>
      <h2 class="section-title">Galerie Social Media</h2>
    </div>
    <?php
      $galleryColumns = '3';
      include __DIR__ . '/../../components/gallery-grid.php';
    ?>
  </div>
</section>
<?php endif; ?>

<!-- ===== FAQ ===== -->
<section class="content-section" lang="ro" style="background:linear-gradient(180deg,#152540,#152540);padding:80px 0">
  <div class="container" style="max-width:800px">
    <div class="section-header">
      <span class="section-tag">FAQ</span>
      <h2 class="section-title">Întrebări Frecvente</h2>
    </div>
    <div itemscope itemtype="https://schema.org/FAQPage">
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <button class="faq-toggle">
          <span itemprop="name">Ce pachete social media oferă Scanbox?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding:0 24px 20px;color:#94A3B8;font-size:15px;line-height:1.8;">
            3 pachete: ADMIN (250&euro;/lună &mdash; 12 postări, calendar editorial), CREATOR (350&euro;/lună &mdash; 20 postări, 4 Reels, strategie) și MANAGER (450&euro;/lună &mdash; 30 postări, 8 Reels, Stories zilnice, campanii). Prețuri fără buget publicitar.
          </div>
        </div>
      </div>
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <button class="faq-toggle">
          <span itemprop="name">Pentru ce platforme?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding:0 24px 20px;color:#94A3B8;font-size:15px;line-height:1.8;">
            Instagram, Facebook, TikTok, LinkedIn, YouTube. Specializare pe branduri din imobiliare, HoReCa, retail și sport.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
