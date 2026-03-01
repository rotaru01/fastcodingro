<?php
/**
 * Pagina Sport Content
 *
 * Variabile disponibile (din PageController::sportContent):
 * @var string $title     - titlul paginii
 * @var array  $galleries - galeriile de tip sport [{gallery, items}]
 * @var array  $settings  - setarile site-ului
 */
$metaDescription = 'Scanbox.ro oferă servicii sport content in București: fotografie sport profesională, video product in action și reels pentru evenimente sportive. Clienți: Keysport, Crosul Arenelor, Sport Guru, Share Your Run. Trăim sportul, nu doar il documentăm.';
$schemaJsonLd = '
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "name": "Sport Content",
  "description": "Fotografie sport profesională, video product in action și reels pentru evenimente sportive.",
  "provider": {
    "@type": "Organization",
    "name": "Scanbox.ro",
    "legalName": "TRIVIT SERVICES S.R.L.",
    "url": "https://scanbox.ro",
    "telephone": "+40740233353",
    "email": "office@scanbox.ro"
  },
  "areaServed": {"@type": "Country", "name": "România"},
  "serviceType": ["Fotografie Sport", "Video Product in Action", "Reels Evenimente Sportive"]
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type": "ListItem", "position": 1, "name": "Acasă", "item": "https://scanbox.ro"},
    {"@type": "ListItem", "position": 2, "name": "Sport Content", "item": "https://scanbox.ro/sport-content.html"}
  ]
}
</script>
';
?>

<!-- HERO -->
<section class="page-hero">
  <div class="hero-blob hero-blob-1"></div>
  <div class="hero-blob hero-blob-2"></div>
  <div class="page-hero-content">
    <span class="hero-badge">&#127939; Sport Content</span>
    <h1>Noi Nu Doar Document&#259;m Sportul. Tr&#259;im Sportul.</h1>
    <p>Fotografie sport, video product in action &#537;i reels pentru evenimente sportive &#8212; cadre construite s&#259; spun&#259; o poveste!</p>
    <div class="hero-buttons">
      <a href="/contact" class="btn-primary">Solicită Ofertă <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
      <a href="#categorii" class="btn-outline">Vezi Serviciile <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg></a>
    </div>
  </div>
</section>

<!-- INTRO -->
<section class="content-section" lang="ro" style="background:linear-gradient(180deg,#0D1B2A,#152540)">
  <div class="container">
    <p style="border-left: 3px solid #04B494; padding-left: 16px; color: #CBD5E1; font-size: 15px; line-height: 1.8; margin: 24px 0;">
      Scanbox.ro oferă 3 categorii de sport content: Fotografie Sport pentru evenimente și competiții, Video Product in Action pentru echipamente sportive și Reels Evenimente pentru activări de brand. Clienți: Keysport, Crosul Arenelor, Sport Guru, Share Your Run, Tenis Club AS.
    </p>
    <div class="section-header">
      <span class="section-tag">Pasiunea noastră</span>
      <h2 class="section-title">Sport, energie și autenticitate</h2>
    </div>
    <div style="max-width:800px;margin:0 auto;text-align:center">
      <p style="font-size:17px;color:#94A3B8;line-height:1.8;margin-bottom:24px">Suntem sportivi amatori, alergăm, pedalăm și participăm la curse de anduranță, așa că știm exact ce momente contează și cum să le surprindem autentic și original.</p>
      <p style="font-size:17px;color:#94A3B8;line-height:1.8;margin-bottom:24px">Fie că vorbim de fotografie la evenimente sportive, materiale video de tip product in action sau short reels pentru activări sportive, abordarea noastră este aceeași: <strong style="color:#E2E8F0">mișcare, energie și dinamism</strong>, cadre construite să spună o poveste!</p>
      <p style="font-size:17px;color:#E2E8F0;line-height:1.8;font-style:italic">Livrăm experiența sportului, a performanței și a pasiunii, surprinsă așa cum trebuie: din mișcare, din interior, cu ochiul unui sportiv care știe să vadă ceea ce contează.</p>
    </div>
  </div>
</section>

<!-- CATEGORIES -->
<section id="categorii" class="content-section" style="background:linear-gradient(180deg,#152540,#1A2B4A)">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Ce oferim</span>
      <h2 class="section-title">Servicii Sport Content</h2>
    </div>

    <!-- Fotografie Sport -->
    <div class="content-grid" style="margin-bottom:80px">
      <div class="content-text">
        <h3>Fotografie Sport</h3>
        <h2>Surprindem emoția, viteza și energia competițiilor</h2>
        <p>De la alergare și trail running, la ciclism și nu numai! De la start și până la linia finish, imortalizăm acțiunea sportivilor, efortul lor și atmosfera evenimentului.</p>
        <p>Fiind sportivi amatori și participanți în propriile curse, știm exact ce momente merită surprinse și cum să arătăm efortul și pasiunea într-un cadru dinamic și autentic.</p>
        <p><strong style="color:#E2E8F0">Rezultatul:</strong> imagini profesioniste, expresive și versatile, perfecte pentru promovare, social media, care transmit pasiunea pentru performanță, efortul și bucuria sportivilor.</p>
        <a href="/contact" class="btn-primary btn-sm" style="margin-top:16px">Solicită Ofertă</a>
      </div>
      <div class="content-visual">
        <div style="display:flex;align-items:center;justify-content:center;height:100%;font-size:64px;opacity:0.3">&#128248;</div>
      </div>
    </div>

    <!-- Video Product in Action -->
    <div class="content-grid reversed" style="margin-bottom:80px">
      <div class="content-text">
        <h3>Video „Product in Action"</h3>
        <h2>Fiecare produs are o poveste</h2>
        <p>Noi o transformăm într-un material video dinamic. Începem cu un scenariu personalizat, gândit să evidențieze funcționalitatea, designul și modul în care produsul inspiră performanță.</p>
        <p>Fie că filmăm încălțăminte, echipamente sau haine sportive, produse de nutriție, indoor sau outdoor, fiecare cadru este planificat pentru a surprinde exact ceea ce îți dorești să transmiți în online.</p>
        <a href="/contact" class="btn-primary btn-sm" style="margin-top:16px">Solicită Ofertă</a>
      </div>
      <div class="content-visual" style="flex-direction:column;gap:16px;padding:16px">
        <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/reel/DP8ZIdPCA02/" data-instgrm-version="14" style="width:100%;margin:0"></blockquote>
      </div>
    </div>

    <!-- Reels Evenimente Sport -->
    <div class="content-grid" style="margin-bottom:40px">
      <div class="content-text">
        <h3>Reels Evenimente Sport & Activări Brand</h3>
        <h2>Conținut scurt, captivant și dinamic</h2>
        <p>Transformăm evenimentele și activările sportive în conținut special pentru social media. Începem cu un scenariu creativ, adaptat obiectivelor brandului tău, astfel încât fiecare cadru să surprindă emoția, energia și acțiunea participanților.</p>
        <p>Fiind sportivi amatori și participanți activi în curse de running și ciclism, știm exact ce detalii contează și cum să le redăm autentic, astfel încât fiecare short video să inspire, să motiveze și să crească engagementul cu brandul tău.</p>
        <a href="/contact" class="btn-primary btn-sm" style="margin-top:16px">Solicită Ofertă</a>
      </div>
      <div class="content-visual" style="flex-direction:column;gap:16px;padding:16px">
        <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/reel/DSVU-PsiJ0T/" data-instgrm-version="14" style="width:100%;margin:0"></blockquote>
      </div>
    </div>
  </div>
</section>

<!-- Quote -->
<section class="content-section" style="background:linear-gradient(180deg,#1A2B4A,#1d3155);padding:80px 0">
  <div class="container" style="text-align:center;max-width:800px">
    <p style="font-size:clamp(20px,2.5vw,28px);color:#E2E8F0;line-height:1.6;font-style:italic">„Experiența noastră ca participanți la curse ne permite să anticipăm momentele cheie și să surprindem tot ce contează pentru public și brand."</p>
    <p style="color:#04B494;font-weight:600;margin-top:16px">— Echipa Scanbox</p>
  </div>
</section>

<!-- LOGOS -->
<section class="logos-section" style="background:linear-gradient(180deg,#1d3155,#172e52)">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Parteneri</span>
      <h2 class="section-title">Au încredere în noi</h2>
    </div>
    <div style="display:flex;justify-content:center;gap:32px;flex-wrap:wrap">
      <div class="logo-placeholder">Keysport</div>
      <div class="logo-placeholder">Crosul Arenelor</div>
      <div class="logo-placeholder">Sport Guru</div>
      <div class="logo-placeholder">Share Your Run</div>
      <div class="logo-placeholder">Tenis Club AS</div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section" style="background:linear-gradient(180deg,#172e52,#152540)">
  <div class="container">
    <div class="cta-banner">
      <h2>Ai un eveniment sportiv? Hai să vorbim!</h2>
      <p>Contactează-ne pentru o ofertă personalizată de sport content.</p>
      <a href="/contact" class="btn-white">Contactează-ne <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    </div>
  </div>
</section>

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
          <span itemprop="name">Ce servicii sport content oferă Scanbox?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding:0 24px 20px;color:#94A3B8;font-size:15px;line-height:1.8;">
            3 categorii: Fotografie Sport, Product in Action, Reels Evenimente. Clienți: Keysport, Crosul Arenelor, Sport Guru, Share Your Run, Tenis Club AS.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php $extraScripts = '<script async src="//www.instagram.com/embed.js"></script>'; ?>
