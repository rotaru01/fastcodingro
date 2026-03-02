<?php
/**
 * Componenta SEO Meta Tags — Optimizata pentru GEO (Generative Engine Optimization)
 * Genereaza meta tags, Open Graph, Twitter Card, JSON-LD Schema.org
 * Optimizata pentru: Google AI Overviews, ChatGPT Search, Perplexity, Claude
 *
 * Variabile disponibile:
 * @var string $title           - titlul paginii
 * @var string $metaDescription - descrierea meta (optimizata ca citation block 40-60 cuvinte)
 * @var string $metaKeywords    - cuvinte cheie (optional)
 * @var string $ogImage         - URL imagine Open Graph (optional)
 * @var string $ogType          - tipul OG (default: 'website')
 * @var string $canonicalUrl    - URL canonical (optional, se construieste automat)
 * @var string $robotsMeta      - directiva robots (optional, default: 'index, follow')
 * @var array  $schemaOrg       - date Schema.org JSON-LD custom (optional)
 * @var string $articlePublished - data publicarii articolului ISO 8601 (optional)
 * @var string $articleModified  - data modificarii articolului ISO 8601 (optional)
 * @var string $articleSection   - sectiunea/categoria articolului (optional)
 */

$siteUrl = defined('SITE_URL') ? SITE_URL : 'https://scanbox.ro';
$title = $title ?? 'Scanbox.ro — Soluții Vizuale Profesionale | Tur Virtual 3D, Fotografie, Video';
$metaDescription = $metaDescription ?? 'Scanbox.ro — servicii profesionale de tur virtual 3D Matterport, fotografie, videografie drone, randare 3D și social media. Reseller Oficial Matterport.';
$metaKeywords = $metaKeywords ?? '';
$ogImage = $ogImage ?? $siteUrl . '/assets/images/og-default.jpg';
$ogType = $ogType ?? 'website';
$canonicalUrl = $canonicalUrl ?? $siteUrl . ($_SERVER['REQUEST_URI'] ?? '/');
$robotsMeta = $robotsMeta ?? 'index, follow';
$schemaOrg = $schemaOrg ?? [];

// Setari dinamice pentru schema.org
$_seo_s = $settings ?? [];
$_seo_email = setting($_seo_s, 'contact_email', 'office@scanbox.ro');
$_seo_phone = setting($_seo_s, 'contact_phone', '0740 233 353');
$_seo_sameAs = array_filter([
    setting($_seo_s, 'social_instagram', 'https://www.instagram.com/scanbox.ro/'),
    setting($_seo_s, 'social_facebook', 'https://www.facebook.com/scanbox.ro'),
    setting($_seo_s, 'social_tiktok', 'https://www.tiktok.com/@scanbox.ro'),
    setting($_seo_s, 'social_youtube', 'https://www.youtube.com/@scanboxintegratedvisualsol9014'),
    setting($_seo_s, 'social_linkedin', 'https://www.linkedin.com/company/scanbox-visual-solutions/'),
]);
?>

<!-- SEO Core Meta -->
<meta name="description" content="<?= htmlspecialchars($metaDescription) ?>">
<?php if ($metaKeywords): ?>
<meta name="keywords" content="<?= htmlspecialchars($metaKeywords) ?>">
<?php endif; ?>
<meta name="robots" content="<?= htmlspecialchars($robotsMeta) ?>">
<meta name="author" content="Scanbox.ro — TRIVIT SERVICES S.R.L.">
<meta name="geo.region" content="RO-B">
<meta name="geo.placename" content="București">
<meta name="geo.position" content="44.4268;26.1025">
<meta name="ICBM" content="44.4268, 26.1025">

<?php if ($canonicalUrl): ?>
<link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">
<?php endif; ?>

<!-- GEO: Hreflang pentru Romania -->
<link rel="alternate" hreflang="ro" href="<?= htmlspecialchars($canonicalUrl) ?>">
<link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($canonicalUrl) ?>">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="<?= htmlspecialchars($ogType) ?>">
<meta property="og:title" content="<?= htmlspecialchars($title) ?>">
<meta property="og:description" content="<?= htmlspecialchars($metaDescription) ?>">
<?php if ($ogImage): ?>
<meta property="og:image" content="<?= htmlspecialchars($ogImage) ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="<?= htmlspecialchars($title) ?>">
<?php endif; ?>
<?php if ($canonicalUrl): ?>
<meta property="og:url" content="<?= htmlspecialchars($canonicalUrl) ?>">
<?php endif; ?>
<meta property="og:site_name" content="Scanbox.ro">
<meta property="og:locale" content="ro_RO">

<?php if (!empty($articlePublished)): ?>
<meta property="article:published_time" content="<?= htmlspecialchars($articlePublished) ?>">
<?php endif; ?>
<?php if (!empty($articleModified)): ?>
<meta property="article:modified_time" content="<?= htmlspecialchars($articleModified) ?>">
<?php endif; ?>
<?php if (!empty($articleSection)): ?>
<meta property="article:section" content="<?= htmlspecialchars($articleSection) ?>">
<?php endif; ?>

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($title) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($metaDescription) ?>">
<?php if ($ogImage): ?>
<meta name="twitter:image" content="<?= htmlspecialchars($ogImage) ?>">
<?php endif; ?>
<meta name="twitter:site" content="@scanbox.ro">

<?php if (!empty($schemaOrg)): ?>
<!-- Schema.org JSON-LD — Custom -->
<script type="application/ld+json">
<?= json_encode($schemaOrg, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
</script>
<?php else: ?>
<!-- Schema.org JSON-LD — Organization + LocalBusiness + WebSite (Default) -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "@id": "<?= $siteUrl ?>/#organization",
      "name": "Scanbox.ro",
      "legalName": "TRIVIT SERVICES S.R.L.",
      "url": "<?= $siteUrl ?>",
      "logo": {
        "@type": "ImageObject",
        "@id": "<?= $siteUrl ?>/#logo",
        "url": "<?= $siteUrl ?>/assets/images/logo.png"
      },
      "telephone": "<?= htmlspecialchars($_seo_phone) ?>",
      "email": "<?= htmlspecialchars($_seo_email) ?>",
      "foundingDate": "2018",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Str. Moroeni 60D",
        "addressLocality": "București",
        "addressRegion": "Sector 2",
        "addressCountry": "RO"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 44.4268,
        "longitude": 26.1025
      },
      "areaServed": [
        {"@type": "Country", "name": "România"},
        {"@type": "Country", "name": "Republica Moldova"}
      ],
      "sameAs": <?= json_encode(array_values($_seo_sameAs), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>,
      "knowsAbout": [
        "Tur Virtual 3D Matterport",
        "Scanare 3D",
        "Fotografie Profesională",
        "Videografie Drone 4K",
        "Randare 3D Fotorealistă",
        "Social Media Management",
        "Content Creation",
        "Digital Twin",
        "Matterport Pro 2",
        "Matterport Pro 3"
      ],
      "hasCredential": {
        "@type": "EducationalOccupationalCredential",
        "credentialCategory": "Reseller Oficial",
        "name": "Reseller Oficial Matterport — România și Republica Moldova"
      }
    },
    {
      "@type": "LocalBusiness",
      "@id": "<?= $siteUrl ?>/#localbusiness",
      "name": "Scanbox.ro",
      "url": "<?= $siteUrl ?>",
      "telephone": "<?= htmlspecialchars($_seo_phone) ?>",
      "email": "<?= htmlspecialchars($_seo_email) ?>",
      "priceRange": "€€",
      "currenciesAccepted": "EUR, RON",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Str. Moroeni 60D",
        "addressLocality": "București",
        "addressRegion": "Sector 2",
        "addressCountry": "RO"
      },
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
        "opens": "09:00",
        "closes": "18:00"
      },
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.9",
        "reviewCount": "47",
        "bestRating": "5"
      }
    },
    {
      "@type": "WebSite",
      "@id": "<?= $siteUrl ?>/#website",
      "name": "Scanbox.ro",
      "url": "<?= $siteUrl ?>",
      "publisher": {"@id": "<?= $siteUrl ?>/#organization"},
      "inLanguage": "ro-RO",
      "potentialAction": {
        "@type": "SearchAction",
        "target": {
          "@type": "EntryPoint",
          "urlTemplate": "<?= $siteUrl ?>/blog?q={search_term_string}"
        },
        "query-input": "required name=search_term_string"
      }
    }
  ]
}
</script>
<?php endif; ?>
