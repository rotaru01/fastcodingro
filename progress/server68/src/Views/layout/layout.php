<!DOCTYPE html>
<html lang="ro" prefix="og: https://ogp.me/ns#">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($title ?? 'Scanbox.ro — Soluții Vizuale Profesionale') ?></title>

<?php include __DIR__ . '/../components/seo-meta.php'; ?>

<!-- GEO: Semnale pentru AI crawlers -->
<meta name="generator" content="Scanbox.ro MVC">
<meta name="theme-color" content="#0D1B2A">
<link rel="icon" type="image/x-icon" href="/favicon.ico">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/images/icons/favicon-32.png">
<link rel="icon" type="image/png" sizes="192x192" href="/assets/images/icons/favicon-192.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<meta name="format-detection" content="telephone=yes">
<link rel="alternate" type="application/rss+xml" title="Scanbox.ro Blog" href="/blog/feed">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" onload="this.onload=null;this.rel='stylesheet'">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
<link rel="stylesheet" href="/assets/css/style.css?v=<?= APP_VERSION ?>">

<?php if (!empty($extraCss)): ?>
<style><?= $extraCss ?></style>
<?php endif; ?>

<?php
// GEO: Schema.org JSON-LD structurat per pagina
if (!empty($schemaJsonLd)):
    echo $schemaJsonLd;
endif;
?>
</head>
<body>

<?php include __DIR__ . '/../components/navbar.php'; ?>

<main id="main-content">
<?= $content ?>
</main>

<?php include __DIR__ . '/../components/cta-banner.php'; ?>
<?php include __DIR__ . '/footer.php'; ?>

<script src="/assets/js/main.js?v=<?= APP_VERSION ?>" defer></script>

<?php if (!empty($extraJs)): ?>
<script><?= $extraJs ?></script>
<?php endif; ?>

<?php if (!empty($extraScripts)): ?>
<?= $extraScripts ?>
<?php endif; ?>

</body>
</html>
