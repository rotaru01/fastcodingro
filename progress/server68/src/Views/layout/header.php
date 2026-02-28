<!DOCTYPE html>
<html lang="ro">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($title ?? 'Scanbox.ro — Soluții Vizuale Profesionale') ?></title>

<?php include __DIR__ . '/../components/seo-meta.php'; ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/style.css">

<?php if (!empty($extraCss)): ?>
<style><?= $extraCss ?></style>
<?php endif; ?>
</head>
<body>

<?php include __DIR__ . '/../components/navbar.php'; ?>
