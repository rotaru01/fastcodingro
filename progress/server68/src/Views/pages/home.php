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

<!-- ===== SERVICII ===== -->
<section class="services-section" id="servicii">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        Serviciile Noastre
      </span>
      <h2 class="section-title">Ce Putem Face pentru Tine</h2>
      <p class="section-subtitle">De la tururi virtuale 3D la content pentru social media — oferim soluții complete pentru prezența ta vizuală.</p>
    </div>

    <div class="services-grid">
      <?php if (!empty($services)): ?>
        <?php foreach ($services as $service): ?>
          <?php
          $serviceTitle = $service['title'] ?? '';
          $serviceDesc = $service['short_description'] ?? $service['description'] ?? '';
          $serviceLink = '/servicii/' . ($service['slug'] ?? '#');
          $serviceColor = $service['icon_color'] ?? 'teal';
          $serviceIcon = $service['icon_svg'] ?? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/></svg>';
          include __DIR__ . '/../components/service-card.php';
          ?>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Fallback - servicii statice -->
        <?php
        $defaultServices = [
            [
                'icon' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="6" y="10" width="36" height="28" rx="3"/><circle cx="24" cy="24" r="8"/><path d="M6 14h36"/></svg>',
                'color' => 'teal',
                'title' => 'Tur Virtual 3D Matterport',
                'desc' => 'Scanări profesionale Matterport pentru prezentarea interactivă a spațiilor tale.',
                'link' => '/servicii/tur-virtual-3d',
            ],
            [
                'icon' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="8" y="6" width="32" height="36" rx="2"/><circle cx="24" cy="22" r="8"/><path d="M14 38h20"/></svg>',
                'color' => 'blue',
                'title' => 'Servicii Foto B2B',
                'desc' => 'Fotografie profesională pentru companii: corporate, produs, imobiliare.',
                'link' => '/servicii/fotografie',
            ],
            [
                'icon' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><polygon points="38 14 28 20 38 26 38 14"/><rect x="8" y="12" width="20" height="16" rx="2"/><path d="M12 36h24"/></svg>',
                'color' => 'teal',
                'title' => 'Servicii Video B2B',
                'desc' => 'Producție video completă: prezentări, interviuri, filmări cu drona.',
                'link' => '/servicii/videografie-drone',
            ],
            [
                'icon' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="6" y="14" width="36" height="24" rx="2"/><path d="M16 14V8h16v6"/><circle cx="24" cy="26" r="6"/></svg>',
                'color' => 'mixed',
                'title' => 'Social Media',
                'desc' => 'Administrare completă social media: strategie, content, creștere organică.',
                'link' => '/servicii/social-media',
            ],
            [
                'icon' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="24" cy="24" r="16"/><path d="M24 8v32M8 24h32"/><path d="M12 12l24 24M36 12L12 36"/></svg>',
                'color' => 'blue',
                'title' => 'Sport Content',
                'desc' => 'Conținut vizual dedicat pentru evenimente și branduri sportive.',
                'link' => '/sport-content',
            ],
            [
                'icon' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M8 36l12-16 8 10 12-18"/><rect x="4" y="4" width="40" height="40" rx="2"/></svg>',
                'color' => 'teal',
                'title' => 'Randare 3D',
                'desc' => 'Vizualizări fotorealiste 3D pentru arhitectură, design interior și dezvoltări imobiliare.',
                'link' => '/servicii/randare-3d',
            ],
        ];
        foreach ($defaultServices as $ds):
            $serviceIcon = $ds['icon'];
            $serviceColor = $ds['color'];
            $serviceTitle = $ds['title'];
            $serviceDesc = $ds['desc'];
            $serviceLink = $ds['link'];
            include __DIR__ . '/../components/service-card.php';
        endforeach;
        ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ===== CLIENT LOGOS ===== -->
<?php include __DIR__ . '/../components/client-carousel.php'; ?>

<!-- ===== CUM FUNCȚIONEAZĂ ===== -->
<section class="how-section" id="cum-functioneaza">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
        Proces Simplu
      </span>
      <h2 class="section-title">Cum Funcționează</h2>
      <p class="section-subtitle">Trei pași simpli de la idee la rezultate vizuale excepționale.</p>
    </div>

    <div class="steps-wrapper">
      <div class="step-item">
        <div class="step-number">01</div>
        <h3>Discuție & Planificare</h3>
        <p>Analizăm nevoile tale și stabilim obiectivele proiectului. Oferim consultanță gratuită.</p>
        <div class="step-connector"></div>
      </div>
      <div class="step-item">
        <div class="step-number">02</div>
        <h3>Producție & Creație</h3>
        <p>Echipa noastră realizează conținutul vizual folosind echipamente profesionale de ultimă generație.</p>
        <div class="step-connector"></div>
      </div>
      <div class="step-item">
        <div class="step-number">03</div>
        <h3>Livrare & Optimizare</h3>
        <p>Primești materialele finalizate, optimizate pentru platformele tale, gata de utilizare.</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== PROIECTE SPECIALE ===== -->
<?php if (!empty($featuredProjects)): ?>
<section class="special-projects">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
        Proiecte Speciale
      </span>
      <h2 class="section-title">Portofoliu Selectat</h2>
    </div>

    <div class="projects-cards">
      <?php foreach ($featuredProjects as $project): ?>
      <div class="project-card">
        <div class="project-card-thumb">
          <?php if (!empty($project['thumbnail'])): ?>
          <img src="<?= htmlspecialchars($project['thumbnail']) ?>" alt="<?= htmlspecialchars($project['title'] ?? '') ?>" loading="lazy">
          <?php else: ?>
          <svg viewBox="0 0 600 400" style="width:100%;background:#1A2B4A;">
            <rect width="600" height="400" fill="#1A2B4A"/>
            <text x="300" y="200" text-anchor="middle" dominant-baseline="middle" fill="#283868" font-size="36" font-family="Inter,sans-serif"><?= htmlspecialchars($project['title'] ?? 'SCANBOX') ?></text>
          </svg>
          <?php endif; ?>
        </div>
        <div class="project-card-info">
          <h3><?= htmlspecialchars($project['title'] ?? '') ?></h3>
          <?php if (!empty($project['description'])): ?>
          <p><?= htmlspecialchars($project['description']) ?></p>
          <?php endif; ?>
          <?php if (!empty($project['link'])): ?>
          <a href="<?= htmlspecialchars($project['link']) ?>" class="service-link" target="_blank" rel="noopener">
            Vezi Proiectul
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ===== TESTIMONIALE ===== -->
<?php include __DIR__ . '/../components/testimonial-slider.php'; ?>

<!-- ===== BLOG PREVIEW ===== -->
<?php if (!empty($recentPosts)): ?>
<section class="blog-section">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/></svg>
        Blog
      </span>
      <h2 class="section-title">Ultimele Articole</h2>
      <p class="section-subtitle">Sfaturi, studii de caz și noutăți din lumea conținutului vizual.</p>
    </div>

    <div class="blog-grid">
      <?php foreach ($recentPosts as $post): ?>
      <a href="/blog/<?= htmlspecialchars($post['slug'] ?? '') ?>" class="blog-card">
        <div class="blog-card-thumb">
          <?php if (!empty($post['featured_image'])): ?>
          <img src="<?= htmlspecialchars($post['featured_image']) ?>" alt="<?= htmlspecialchars($post['title'] ?? '') ?>" loading="lazy">
          <?php else: ?>
          <svg viewBox="0 0 400 250" style="width:100%;background:linear-gradient(135deg,#1A2B4A,#283868);">
            <rect width="400" height="250" fill="url(#grad)"/>
            <text x="200" y="125" text-anchor="middle" dominant-baseline="middle" fill="#394E75" font-size="24" font-family="Inter,sans-serif">SCANBOX</text>
          </svg>
          <?php endif; ?>
        </div>
        <div class="blog-card-body">
          <div class="blog-card-date">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <?= date('d.m.Y', strtotime($post['published_at'] ?? $post['created_at'] ?? 'now')) ?>
          </div>
          <h3><?= htmlspecialchars($post['title'] ?? '') ?></h3>
          <p><?= htmlspecialchars(mb_substr(strip_tags($post['excerpt'] ?? $post['content'] ?? ''), 0, 120)) ?>...</p>
        </div>
      </a>
      <?php endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: 40px;">
      <a href="/blog" class="btn-outline">
        Vezi Toate Articolele
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>
</section>
<?php endif; ?>
