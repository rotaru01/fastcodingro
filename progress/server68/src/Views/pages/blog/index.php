<?php
/**
 * Pagina Blog - Lista articole
 *
 * Variabile disponibile (din BlogController::index):
 * @var string $title       - titlul paginii
 * @var array  $posts       - lista articolelor
 * @var array  $categories  - categoriile cu numar de articole
 * @var int    $currentPage - pagina curenta
 * @var int    $totalPages  - numarul total de pagini
 * @var int    $totalPosts  - numarul total de articole
 * @var array  $settings    - setarile site-ului
 */
$metaDescription = 'Blogul Scanbox.ro: articole și resurse utile despre tururi virtuale 3D Matterport, fotografie profesională, videografie cu dronă și conținut vizual B2B. Ghiduri practice, studii de caz și noutăți din industria vizuală profesională din România.';
?>

<?php
$heroType = 'page';
$heroBadge = 'Blog';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/></svg>';
$heroTitle = 'Blog';
$heroSubtitle = 'Articole și resurse utile despre conținut vizual profesional';
include __DIR__ . '/../../components/hero.php';
?>

<!-- ===== BLOG SECTION ===== -->
<section class="blog-section" lang="ro">
  <div class="container">
    <p style="border-left: 3px solid #04B494; padding-left: 16px; color: #CBD5E1; font-size: 15px; line-height: 1.8; margin: 0 0 40px 0;">
      Blogul Scanbox.ro oferă articole utile despre tururi virtuale 3D Matterport, fotografie profesională, videografie cu dronă și conținut vizual B2B. Ghiduri practice, studii de caz și noutăți din industria vizuală profesională din România.
    </p>

    <?php if (!empty($categories)): ?>
    <div style="display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; margin-bottom: 48px;">
      <a href="/blog" class="btn-sm <?= empty($_GET['category']) ? 'btn-primary' : 'btn-outline' ?>">Toate</a>
      <?php foreach ($categories as $cat): ?>
      <a href="/blog/categorie/<?= htmlspecialchars($cat['slug'] ?? '') ?>" class="btn-sm btn-outline">
        <?= htmlspecialchars($cat['name'] ?? '') ?>
        <?php if (!empty($cat['post_count'])): ?>
        <span style="opacity: 0.6;">(<?= (int) $cat['post_count'] ?>)</span>
        <?php endif; ?>
      </a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($posts)): ?>
    <div class="blog-grid">
      <?php foreach ($posts as $post): ?>
      <a href="/blog/<?= htmlspecialchars($post['slug'] ?? '') ?>" class="blog-card">
        <div class="blog-card-thumb">
          <?php if (!empty($post['featured_image'])): ?>
          <img src="<?= htmlspecialchars($post['featured_image']) ?>" alt="<?= htmlspecialchars($post['title'] ?? '') ?>" loading="lazy">
          <?php else: ?>
          <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:48px;opacity:0.3;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1.5"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
          </div>
          <?php endif; ?>
        </div>
        <div class="blog-card-body">
          <div class="blog-card-date">
            <?= date('d.m.Y', strtotime($post['published_at'] ?? $post['created_at'] ?? 'now')) ?>
          </div>
          <h3><?= htmlspecialchars($post['title'] ?? '') ?></h3>
          <p><?= htmlspecialchars(mb_substr(strip_tags($post['excerpt'] ?? $post['content'] ?? ''), 0, 150)) ?>...</p>
          <span class="service-link">Citește &rarr;</span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>

    <!-- Paginare -->
    <?php
    $baseUrl = '/blog';
    include __DIR__ . '/../../components/pagination.php';
    ?>

    <?php else: ?>
    <!-- Static fallback blog cards matching original HTML design -->
    <div class="blog-grid">

      <!-- Blog Card 1 -->
      <a href="#" class="blog-card">
        <div class="blog-card-thumb">
          <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:48px;opacity:0.3;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1.5"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
          </div>
        </div>
        <div class="blog-card-body">
          <div class="blog-card-date">15 Ianuarie 2025</div>
          <h3>5 Motive să alegi un tur virtual 3D ca soluție vizuală în imobiliare</h3>
          <p>Descoperă de ce tururile virtuale 3D au devenit un instrument esențial pentru agenții imobiliari și dezvoltatori, oferind experiențe imersive clienților.</p>
          <span class="service-link">Citește &rarr;</span>
        </div>
      </a>

      <!-- Blog Card 2 -->
      <a href="#" class="blog-card">
        <div class="blog-card-thumb">
          <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:48px;opacity:0.3;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
          </div>
        </div>
        <div class="blog-card-body">
          <div class="blog-card-date">28 Decembrie 2024</div>
          <h3>Fotografie imobiliară: 6 sfaturi utile pentru o ședință foto așa cum trebuie</h3>
          <p>Pregătirea spațiului, iluminarea corectă și unghiurile potrivite fac diferența între o fotografie obișnuită și una care vinde proprietatea rapid.</p>
          <span class="service-link">Citește &rarr;</span>
        </div>
      </a>

      <!-- Blog Card 3 -->
      <a href="#" class="blog-card">
        <div class="blog-card-thumb">
          <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:48px;opacity:0.3;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1.5"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
          </div>
        </div>
        <div class="blog-card-body">
          <div class="blog-card-date">10 Noiembrie 2024</div>
          <h3>Avantajele prezentărilor video în procesul de producție</h3>
          <p>Conținutul video de calitate accelerează deciziile de achiziție și oferă transparență în procesele de producție industrială.</p>
          <span class="service-link">Citește &rarr;</span>
        </div>
      </a>

      <!-- Blog Card 4 -->
      <a href="#" class="blog-card">
        <div class="blog-card-thumb">
          <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:48px;opacity:0.3;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
          </div>
        </div>
        <div class="blog-card-body">
          <div class="blog-card-date">22 Octombrie 2024</div>
          <h3>Cum te ajută un tur virtual 3D în industria evenimentelor corporate</h3>
          <p>Locațiile pentru evenimente beneficiază enorm de tururi virtuale, permițând organizatorilor să exploreze spațiile de la distanță înainte de a lua o decizie.</p>
          <span class="service-link">Citește &rarr;</span>
        </div>
      </a>

      <!-- Blog Card 5 -->
      <a href="#" class="blog-card">
        <div class="blog-card-thumb">
          <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:48px;opacity:0.3;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1.5"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
          </div>
        </div>
        <div class="blog-card-body">
          <div class="blog-card-date">5 Septembrie 2024</div>
          <h3>Utilizarea echipamentului Matterport în speologie</h3>
          <p>Explorarea și documentarea peșterilor cu tehnologie Matterport deschide noi orizonturi pentru cercetarea științifică și turismul de aventură.</p>
          <span class="service-link">Citește &rarr;</span>
        </div>
      </a>

      <!-- Blog Card 6 -->
      <a href="#" class="blog-card">
        <div class="blog-card-thumb">
          <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:48px;opacity:0.3;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
          </div>
        </div>
        <div class="blog-card-body">
          <div class="blog-card-date">18 August 2024</div>
          <h3>Matterport anunță Genesis - Generator AI</h3>
          <p>Matterport lansează Genesis, un generator AI revoluționar care transformă scanările 3D în modele optimizate automat pentru diverse industrii.</p>
          <span class="service-link">Citește &rarr;</span>
        </div>
      </a>

      <!-- Blog Card 7 -->
      <a href="#" class="blog-card">
        <div class="blog-card-thumb">
          <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:48px;opacity:0.3;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1.5"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
          </div>
        </div>
        <div class="blog-card-body">
          <div class="blog-card-date">2 Iulie 2024</div>
          <h3>Cum te ajută Matterport în imobiliare</h3>
          <p>De la vizionări virtuale la măsurători precise, Matterport oferă agenților imobiliari instrumente puternice pentru a vinde mai rapid și mai eficient.</p>
          <span class="service-link">Citește &rarr;</span>
        </div>
      </a>

      <!-- Blog Card 8 -->
      <a href="#" class="blog-card">
        <div class="blog-card-thumb">
          <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:48px;opacity:0.3;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
          </div>
        </div>
        <div class="blog-card-body">
          <div class="blog-card-date">15 Mai 2024</div>
          <h3>Importanța conservării obiectivelor turistice cu tehnologia Matterport</h3>
          <p>Digitalizarea monumentelor și a obiectivelor turistice cu Matterport asigură conservarea patrimoniului cultural pentru generațiile viitoare.</p>
          <span class="service-link">Citește &rarr;</span>
        </div>
      </a>

    </div>
    <?php endif; ?>

  </div>
</section>
