<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Admin') ?> — Scanbox Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body style="display:flex">
    <?php include __DIR__ . '/admin-sidebar.php'; ?>
    <div class="admin-wrapper">
        <?php include __DIR__ . '/admin-header.php'; ?>
        <div class="main">
            <?php if (!empty($flash_success)): ?>
                <div class="flash flash-success"><?= htmlspecialchars($flash_success) ?></div>
            <?php endif; ?>
            <?php if (!empty($flash_error)): ?>
                <div class="flash flash-error"><?= htmlspecialchars($flash_error) ?></div>
            <?php endif; ?>
            <?= $content ?>
        </div>
        <?php include __DIR__ . '/admin-footer.php'; ?>
    </div>
    <script src="/assets/js/admin.js" defer></script>
</body>
</html>
