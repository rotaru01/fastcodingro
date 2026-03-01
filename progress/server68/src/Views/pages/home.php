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
$heroTitle = 'Soluții Vizuale Profesionale pentru Afacerea Ta';
$heroSubtitle = 'Tur Virtual 3D Matterport <span>|</span> Fotografie <span>|</span> Videografie <span>|</span> Social Media Management';
$heroType = 'full';
$heroButtons = [
    ['text' => 'Cere Ofertă Gratuită', 'href' => '/contact', 'class' => 'btn-primary', 'icon' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>'],
    ['text' => 'Vezi Serviciile', 'href' => '#servicii', 'class' => 'btn-outline', 'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>'],
];
include __DIR__ . '/../components/hero.php';
?>

<!-- ===== STATS ===== -->
<?php
$stats = [
    ['value' => '500', 'suffix' => '+', 'label' => 'Proiecte Livrate'],
    ['value' => '150', 'suffix' => '+', 'label' => 'Clienți Mulțumiți'],
    ['value' => '7',   'suffix' => '+', 'label' => 'Ani de Experiență'],
    ['value' => '98',  'suffix' => '%', 'label' => 'Rată de Satisfacție'],
];
include __DIR__ . '/../components/counter.php';
?>

<!-- ===== SLOGAN BANNER ===== -->
<section class="content-section" style="padding: 60px 0; background: linear-gradient(180deg, #0D1B2A 0%, #152540 100%);">
  <div class="container" style="text-align: center;">
    <div class="slogan-text" style="font-size: clamp(28px, 5vw, 56px); font-weight: 800; letter-spacing: 2px; color: rgba(255,255,255,0.08); text-transform: uppercase;">
      WE ARE YOUR CONTENT CREATORS
    </div>
  </div>
</section>

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
          <p>Producție video completă: prezentări corporate, filmări cu drona 4K, interviuri, time-lapse și conținut pentru platforme digitale.</p>
          <span class="service-link">Află mai multe <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </a>

        <a href="/servicii/social-media" class="service-card">
          <div class="service-icon mixed">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
          </div>
          <h3>Social Media</h3>
          <p>Administrare completă social media: strategie, content foto & video, creștere organică și management comunitate.</p>
          <span class="service-link">Află mai multe <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </a>

        <a href="/sport-content" class="service-card">
          <div class="service-icon blue">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#5B7FBF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
          </div>
          <h3>Sport Content</h3>
          <p>Conținut vizual dedicat pentru evenimente și branduri sportive: filmări de meci, highlight-uri, conținut social media.</p>
          <span class="service-link">Află mai multe <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </a>

        <a href="/servicii/randare-3d" class="service-card">
          <div class="service-icon teal">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
          </div>
          <h3>Randare 3D</h3>
          <p>Vizualizări fotorealiste 3D pentru arhitectură, design interior și dezvoltări imobiliare. Proiecte prezentate înainte de construcție.</p>
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
            <span class="blog-card-date">1 Februarie 2026</span>
            <h3>Strategii de Social Media pentru Companii B2B în 2026</h3>
            <p>Cele mai eficiente tactici de social media pentru companii care vând către alte companii.</p>
            <span class="blog-card-link">Citește mai mult <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
          </div>
        </a>
      <?php endif; ?>
    </div>
  </div>
</section>
