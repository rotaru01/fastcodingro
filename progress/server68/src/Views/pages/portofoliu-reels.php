<?php
/**
 * Pagina Portofoliu Reels
 */
$metaDescription = 'Portofoliul video Scanbox.ro: o selecție din cele mai recente proiecte video in format scurt (Reels) realizate pentru clienți din imobiliare, HoReCa, sport și retail. Conținut dinamic pentru Instagram, TikTok și Facebook.';
$schemaJsonLd = '
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CollectionPage",
  "name": "Portofoliu Reels — Scanbox.ro",
  "description": "O selecție din cele mai recente proiecte video în format scurt realizate de Scanbox.ro.",
  "url": "https://scanbox.ro/portofoliu-reels.html",
  "publisher": {
    "@type": "Organization",
    "name": "Scanbox.ro",
    "url": "https://scanbox.ro"
  }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type": "ListItem", "position": 1, "name": "Acasă", "item": "https://scanbox.ro"},
    {"@type": "ListItem", "position": 2, "name": "Portofoliu Reels", "item": "https://scanbox.ro/portofoliu-reels.html"}
  ]
}
</script>
';
?>

<?php
$heroType = 'page';
$heroBadge = 'Portofoliu Video';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>';
$heroTitle = 'Portofoliu Reels';
$heroSubtitle = 'O selecție din cele mai recente proiecte video în format scurt';
include __DIR__ . '/../components/hero.php';
?>

<!-- ===== REELS GRID ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 50%, #152540 100%); padding: 80px 0 100px;">
  <div class="container">
    <?php
      $galleryItems = $reelsItems ?? [];
      $galleryTitle = '';
      $galleryColumns = '3';
      include __DIR__ . '/../components/gallery-grid.php';
    ?>

    <!-- Back link -->
    <div style="text-align: center; margin-top: 60px;">
      <a href="/servicii/social-media" class="btn-outline">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Înapoi la Social Media
      </a>
    </div>
  </div>
</section>
