<?php
/**
 * Pagina principala - Homepage
 *
 * Variabile disponibile (din PageController::home):
 * @var string $title           - titlul paginii
 * @var array  $services        - lista serviciilor active
 * @var array  $featuredProjects - proiectele promovate
 * @var array  $testimonials    - testimonialele active
 * @var array  $clientLogos     - logo-urile clientilor
 * @var array  $recentPosts     - ultimele 3 articole blog
 * @var array  $settings        - setarile site-ului
 */
?>

<?php
$heroBadge = 'Reseller Oficial Matterport România';
$heroBadgeIcon = '<svg viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>';
$heroTitle = 'Soluții Vizuale pentru Afacerea Ta';
$heroType = 'full';
$heroServices = [
    ['text' => 'Tur Virtual 3D Matterport', 'href' => '/servicii/tur-virtual-3d'],
    ['text' => 'Foto B2B', 'href' => '/servicii/fotografie'],
    ['text' => 'Video B2B', 'href' => '/servicii/videografie-drone'],
    ['text' => 'Social Media', 'href' => '/servicii/social-media'],
    ['text' => 'Sport Content', 'href' => '/sport-content'],
    ['text' => 'Randare 3D', 'href' => '/servicii/randare-3d'],
];
$heroButtons = [
    ['text' => 'Cere Ofertă Gratuită', 'tag' => 'button', 'class' => 'btn-primary', 'onclick' => "document.getElementById('contact-section').scrollIntoView({behavior:'smooth'})", 'icon' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>'],
    ['text' => 'Vezi Serviciile', 'href' => '#servicii', 'class' => 'btn-outline', 'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>'],
];
include __DIR__ . '/../components/hero.php';
?>

<!-- ===== SLOGAN ===== -->
<div class="slogan-banner">
  <p class="slogan-text">WE ARE YOUR CONTENT CREATORS</p>
</div>

<!-- ===== CITATION BLOCK ===== -->
<section lang="ro" style="background: linear-gradient(180deg, #0D1B2A, #0D1B2A); padding: 40px 0 0;">
  <div class="container" style="max-width: 900px;">
    <p style="border-left: 3px solid #04B494; padding-left: 16px; color: #CBD5E1; font-size: 15px; line-height: 1.8; margin: 24px 0;">
      Scanbox.ro (TRIVIT SERVICES S.R.L.) este o companie B2B din București specializată in soluții vizuale profesionale: tur virtual 3D Matterport, fotografie profesională, videografie drone 4K, randare 3D fotorealistă, social media și sport content. Reseller Oficial Matterport România, 500+ proiecte finalizate.
    </p>
  </div>
</section>

<!-- ===== STATS ===== -->
<?php
$stats = [
    ['value' => setting($settings ?? [], 'stats_projects_count', '500'), 'suffix' => '+', 'label' => 'Proiecte Livrate'],
    ['value' => setting($settings ?? [], 'stats_clients_count', '150'), 'suffix' => '+', 'label' => 'Clienți Mulțumiți'],
    ['value' => setting($settings ?? [], 'stats_years_experience', '7'), 'suffix' => '+', 'label' => 'Ani de Experiență'],
    ['value' => setting($settings ?? [], 'stats_satisfaction_rate', '98'), 'suffix' => '%', 'label' => 'Rată de Satisfacție'],
];
include __DIR__ . '/../components/counter.php';
?>

<!-- ===== SERVICES ===== -->
<section class="services-section" id="servicii">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Servicii</span>
      <h2 class="section-title">Ce Facem pentru Afacerea Ta</h2>
      <p class="section-subtitle">Soluții complete de conținut vizual, de la scanări 3D la strategii de social media.</p>
    </div>

    <div class="services-grid">
      <?php if (!empty($services)): ?>
        <?php foreach ($services as $service): ?>
          <?php
          $serviceTitle = $service['title'] ?? $service['title_ro'] ?? '';
          $serviceDesc = $service['short_description'] ?? $service['description_ro'] ?? '';
          $serviceLink = '/servicii/' . ($service['slug'] ?? '#');
          $serviceColor = $service['icon_color'] ?? 'teal';
          $serviceIcon = $service['icon_svg'] ?? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/></svg>';
          include __DIR__ . '/../components/service-card.php';
          ?>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Fallback - servicii statice ca in HTML original -->
        <a href="/servicii/tur-virtual-3d" class="service-card">
          <div class="service-icon teal">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
          </div>
          <h3>Tur Virtual 3D Matterport</h3>
          <p>Scanări 3D imersive care permit vizitatorilor să exploreze spații ca și cum ar fi acolo. Ideal pentru imobiliare, HoReCa și retail.</p>
          <span class="service-link">Află mai multe <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </a>

        <a href="/servicii/fotografie" class="service-card">
          <div class="service-icon blue">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#5B7FBF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
          </div>
          <h3>Servicii Foto B2B</h3>
          <p>Fotografii profesionale de înaltă calitate pentru imobiliare, produse, evenimente corporate și orice alt context vizual B2B.</p>
          <span class="service-link">Află mai multe <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </a>

        <a href="/servicii/videografie-drone" class="service-card">
          <div class="service-icon teal">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
          </div>
          <h3>Servicii Video B2B</h3>
          <p>Conținut video cinematic, filmare aeriană cu drone și editare profesională pentru prezentări de impact ale afacerii tale.</p>
          <span class="service-link">Află mai multe <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </a>

        <a href="/servicii/social-media" class="service-card">
          <div class="service-icon mixed">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
          </div>
          <h3>Social Media</h3>
          <p>Strategie completă de social media: creare conținut, programare postări, community management și raportare lunară detaliată.</p>
          <span class="service-link">Află mai multe <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </a>

        <a href="/sport-content" class="service-card">
          <div class="service-icon blue">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#5B7FBF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
          </div>
          <h3>Sport Content</h3>
          <p>Conținut vizual dinamic pentru evenimente sportive, cluburi și federații. Foto, video și social media specializate pe sport.</p>
          <span class="service-link">Află mai multe <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </a>

        <a href="/servicii/randare-3d" class="service-card">
          <div class="service-icon teal">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
          </div>
          <h3>Randare 3D</h3>
          <p>Vizualizări 3D fotorealiste și planuri izometrice pentru arhitectură, design interior și dezvoltări imobiliare de top.</p>
          <span class="service-link">Află mai multe <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </a>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ===== CLIENT LOGOS ===== -->
<?php include __DIR__ . '/../components/client-carousel.php'; ?>

<!-- ===== HOW IT WORKS ===== -->
<section class="how-section" id="cum-lucram">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Proces Simplu</span>
      <h2 class="section-title">Cum Lucrăm</h2>
      <p class="section-subtitle">Trei pași simpli pentru rezultate vizuale excepționale.</p>
    </div>

    <div class="steps-wrapper">
      <div class="step-item">
        <div class="step-number"><span>1</span></div>
        <div class="step-connector">
          <svg viewBox="0 0 200 40" preserveAspectRatio="none">
            <path d="M0,20 C50,0 150,40 200,20" fill="none" stroke="url(#grad1)" stroke-width="2" stroke-dasharray="6 4"/>
            <defs><linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" style="stop-color:#04B494;stop-opacity:0.6"/><stop offset="100%" style="stop-color:#039B7E;stop-opacity:0.3"/></linearGradient></defs>
          </svg>
        </div>
        <h3>Discutăm Proiectul</h3>
        <p>Ne spui despre nevoile tale, iar noi propunem soluția vizuală potrivită bugetului și obiectivelor tale.</p>
      </div>
      <div class="step-item">
        <div class="step-number"><span>2</span></div>
        <div class="step-connector">
          <svg viewBox="0 0 200 40" preserveAspectRatio="none">
            <path d="M0,20 C50,40 150,0 200,20" fill="none" stroke="url(#grad2)" stroke-width="2" stroke-dasharray="6 4"/>
            <defs><linearGradient id="grad2" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" style="stop-color:#039B7E;stop-opacity:0.5"/><stop offset="100%" style="stop-color:#283868;stop-opacity:0.3"/></linearGradient></defs>
          </svg>
        </div>
        <h3>Realizăm Conținutul</h3>
        <p>Echipa noastră de profesioniști creează conținutul vizual la cel mai înalt standard de calitate.</p>
      </div>
      <div class="step-item">
        <div class="step-number"><span>3</span></div>
        <h3>Livrăm Rezultate</h3>
        <p>Primești materialele finalizate, gata de utilizare, împreună cu suport dedicat post-livrare.</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== SPECIAL PROJECTS ===== -->
<section class="special-section">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Proiecte Speciale</span>
      <h2 class="section-title">Proiecte Unice</h2>
      <p class="section-subtitle">Proiecte care depășesc limitele conținutului vizual tradițional.</p>
    </div>

    <div class="special-grid">
      <?php if (!empty($featuredProjects)): ?>
        <?php foreach ($featuredProjects as $project): ?>
        <div class="special-card">
          <div class="special-card-visual">
            <?php if (!empty($project['thumbnail'])): ?>
            <img src="<?= htmlspecialchars($project['thumbnail']) ?>" alt="<?= htmlspecialchars($project['title'] ?? '') ?>" loading="lazy">
            <?php else: ?>
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="1"><circle cx="12" cy="12" r="10"/></svg>
            <?php endif; ?>
          </div>
          <div class="special-card-body">
            <h3><?= htmlspecialchars($project['title'] ?? '') ?></h3>
            <?php if (!empty($project['description'])): ?>
            <p><?= htmlspecialchars($project['description']) ?></p>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Fallback - proiecte statice ca in HTML original -->
        <div class="special-card">
          <div class="special-card-visual romania">
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <div class="special-card-badge">Proiect Național</div>
          </div>
          <div class="special-card-body">
            <h3>Aplicația România Atractivă</h3>
            <p>Peste 100 de tururi virtuale 3D pentru obiective turistice din România. Un proiect ambițios care aduce patrimoniul cultural și turistic al țării mai aproape de toți prin tehnologia Matterport.</p>
          </div>
        </div>

        <div class="special-card">
          <div class="special-card-visual pestera">
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
            <div class="special-card-badge">Premieră Națională</div>
          </div>
          <div class="special-card-body">
            <h3>Primul Tur Virtual 3D într-o Peșteră</h3>
            <p>Proiectul Rural Karst by Exploratorii.org — o premieră națională în care am scanat 3D o peșteră din România, aducând mediul subteran în lumea digitală prin realitate virtuală imersivă.</p>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ===== TESTIMONIALS ===== -->
<?php include __DIR__ . '/../components/testimonial-slider.php'; ?>

<!-- ===== BLOG PREVIEW ===== -->
<section class="blog-section">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Blog</span>
      <h2 class="section-title">Ultimele Articole</h2>
      <p class="section-subtitle">Noutăți, sfaturi și studii de caz din lumea conținutului vizual.</p>
    </div>

    <div class="blog-grid">
      <?php if (!empty($recentPosts)): ?>
        <?php foreach ($recentPosts as $post): ?>
        <a href="/blog/<?= htmlspecialchars($post['slug'] ?? '') ?>" class="blog-card">
          <div class="blog-card-thumb">
            <?php if (!empty($post['featured_image'])): ?>
            <img src="<?= htmlspecialchars($post['featured_image']) ?>" alt="<?= htmlspecialchars($post['title'] ?? '') ?>" loading="lazy">
            <?php endif; ?>
          </div>
          <div class="blog-card-body">
            <span class="blog-card-date"><?= date('d F Y', strtotime($post['published_at'] ?? $post['created_at'] ?? 'now')) ?></span>
            <h3><?= htmlspecialchars($post['title'] ?? '') ?></h3>
            <p><?= htmlspecialchars(mb_substr(strip_tags($post['excerpt'] ?? $post['content'] ?? ''), 0, 120)) ?>...</p>
            <span class="blog-card-link">Citește mai mult <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
          </div>
        </a>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Fallback - blog cards statice ca in HTML original -->
        <a href="/blog" class="blog-card">
          <div class="blog-card-thumb thumb-1">
            <div class="blog-card-thumb-icon">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
            </div>
            <span class="blog-card-category">Tur Virtual 3D</span>
          </div>
          <div class="blog-card-body">
            <span class="blog-card-date">15 Februarie 2026</span>
            <h3>Cum Tururile Virtuale 3D Transformă Industria Imobiliară</h3>
            <p>Descoperă cum tehnologia Matterport revoluționează modul în care proprietățile sunt prezentate și vândute.</p>
            <span class="blog-card-link">Citește mai mult <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
          </div>
        </a>

        <a href="/blog" class="blog-card">
          <div class="blog-card-thumb thumb-2">
            <div class="blog-card-thumb-icon">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
            </div>
            <span class="blog-card-category">Fotografie</span>
          </div>
          <div class="blog-card-body">
            <span class="blog-card-date">8 Februarie 2026</span>
            <h3>Ghidul Complet pentru Fotografia de Produs în E-Commerce</h3>
            <p>Sfaturi practice pentru fotografii de produs care cresc rata de conversie în magazinul tău online.</p>
            <span class="blog-card-link">Citește mai mult <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
          </div>
        </a>

        <a href="/blog" class="blog-card">
          <div class="blog-card-thumb thumb-3">
            <div class="blog-card-thumb-icon">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
            </div>
            <span class="blog-card-category">Social Media</span>
          </div>
          <div class="blog-card-body">
            <span class="blog-card-date">10 Ianuarie 2026</span>
            <h3>Tendințe Social Media 2026: Ce Trebuie Să Știi</h3>
            <p>Cele mai importante tendințe în social media pentru anul 2026 și cum le poți integra în strategia ta de marketing.</p>
            <span class="blog-card-link">Citește mai mult <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
          </div>
        </a>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ===== CONTACT FORM ===== -->
<section class="contact-section" id="contact-section">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Contact</span>
      <h2 class="section-title">Cere Ofertă Gratuită</h2>
      <p class="section-subtitle">Spune-ne despre proiectul tău și revenim cu o ofertă personalizată în maxim 24 de ore.</p>
    </div>

    <div class="contact-grid">
      <!-- Left: Contact Info -->
      <div class="contact-info">
        <h2>Hai să Discutăm</h2>
        <p>Suntem aici să te ajutăm cu orice întrebare legată de serviciile noastre. Contactează-ne prin oricare din metodele de mai jos sau completează formularul.</p>

        <!-- E-mail -->
        <div class="contact-detail">
          <div class="contact-detail-icon">
            <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 4l-10 9L2 4"/></svg>
          </div>
          <div>
            <span><?= htmlspecialchars(setting($settings ?? [], 'contact_email', 'office@scanbox.ro')) ?></span>
            <small>E-mail</small>
          </div>
        </div>

        <!-- Telefon -->
        <div class="contact-detail">
          <div class="contact-detail-icon">
            <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
          </div>
          <div>
            <span><?= htmlspecialchars(setting($settings ?? [], 'contact_phone', '0740 233 353')) ?></span>
            <small>Telefon</small>
          </div>
        </div>

        <!-- Adresa -->
        <div class="contact-detail">
          <div class="contact-detail-icon">
            <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
          </div>
          <div>
            <span><?= htmlspecialchars(setting($settings ?? [], 'contact_address', 'Str. Moroeni 60D, Sector 2, București')) ?></span>
            <small>Sediu</small>
          </div>
        </div>

        <!-- Program -->
        <div class="contact-detail">
          <div class="contact-detail-icon">
            <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          </div>
          <div>
            <span><?= htmlspecialchars(setting($settings ?? [], 'contact_working_hours', 'Luni - Vineri, 09:00 - 18:00')) ?></span>
            <small>Program</small>
          </div>
        </div>
      </div>

      <!-- Right: Contact Form -->
      <div class="contact-form">
        <form id="contactForm">
          <div class="form-row">
            <div class="form-group">
              <label for="name">Nume</label>
              <input type="text" id="name" name="name" placeholder="Numele tău" required>
            </div>
            <div class="form-group">
              <label for="email">E-mail</label>
              <input type="email" id="email" name="email" placeholder="adresa@email.com" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="phone">Telefon</label>
              <input type="tel" id="phone" name="phone" placeholder="07XX XXX XXX">
            </div>
            <div class="form-group">
              <label for="service">Serviciu</label>
              <select id="service" name="service" required>
                <option value="" disabled selected>Alege serviciul</option>
                <option value="Tur Virtual 3D">Tur Virtual 3D</option>
                <option value="Foto">Foto</option>
                <option value="Video">Video</option>
                <option value="Social Media">Social Media</option>
                <option value="Sport Content">Sport Content</option>
                <option value="Randare 3D">Randare 3D</option>
                <option value="Altele">Altele</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="message">Mesaj</label>
            <textarea id="message" name="message" rows="5" placeholder="Descrie pe scurt proiectul tău..." required></textarea>
          </div>
          <button type="submit" class="btn-primary" style="width: 100%; justify-content: center;">
            Trimite Mesajul
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ===== FAQ ===== -->
<section lang="ro" style="background: linear-gradient(180deg, #0D1B2A, #0D1B2A); padding: 80px 0;">
  <div class="container" style="max-width: 800px;">
    <div class="section-header" style="text-align: center; margin-bottom: 48px;">
      <span class="hero-badge" style="display: inline-block; margin-bottom: 16px;">FAQ</span>
      <h2 style="font-size: clamp(24px, 3vw, 36px); font-weight: 800; letter-spacing: -0.5px;">Întrebări Frecvente</h2>
    </div>
    <div itemscope itemtype="https://schema.org/FAQPage">
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <button class="faq-toggle">
          <span itemprop="name">Ce este Scanbox.ro?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding: 0 24px 20px; color: #94A3B8; font-size: 15px; line-height: 1.8;">
            Scanbox.ro (TRIVIT SERVICES S.R.L.) este o companie B2B din București specializată în soluții vizuale profesionale: tur virtual 3D Matterport, fotografie profesională, videografie drone 4K, randare 3D fotorealistă, social media content management și sport content. Fondată în 2018, este singurul Reseller Oficial Matterport pentru România și Republica Moldova, cu peste 150 tururi virtuale și 500 proiecte finalizate.
          </div>
        </div>
      </div>
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <button class="faq-toggle">
          <span itemprop="name">Unde se află Scanbox și în ce zone oferă servicii?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding: 0 24px 20px; color: #94A3B8; font-size: 15px; line-height: 1.8;">
            Sediul Scanbox este în Str. Moroeni 60D, Sector 2, București, România. Compania oferă servicii în toată România și Republica Moldova. Program de lucru: Luni-Vineri, 09:00-18:00. Contact: office@scanbox.ro, telefon 0740 233 353.
          </div>
        </div>
      </div>
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <button class="faq-toggle">
          <span itemprop="name">De ce să aleg Scanbox pentru servicii vizuale?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding: 0 24px 20px; color: #94A3B8; font-size: 15px; line-height: 1.8;">
            Scanbox este singura companie din România cu statut de Reseller Oficial Matterport, oferind acces direct la cele mai avansate tehnologii de scanare 3D. Cu peste 5 ani de experiență, 150+ tururi virtuale și 500+ proiecte finalizate, echipa combină expertiza tehnică cu creativitatea artistică. Livrare rapidă (48h) și echipament de ultimă generație.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
