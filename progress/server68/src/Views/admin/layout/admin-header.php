<?php
$admin_name = $_SESSION['admin_name'] ?? 'Administrator';
?>
<header class="admin-header">
    <div class="admin-header-left">
        <h2 class="admin-header-title"><?= htmlspecialchars($page_title ?? 'Dashboard') ?></h2>
    </div>
    <div class="admin-header-right">
        <div class="admin-user">
            <div class="admin-avatar"><?= strtoupper(mb_substr($admin_name, 0, 1)) ?></div>
            <span class="admin-user-name"><?= htmlspecialchars($admin_name) ?></span>
        </div>
        <a href="/admin/logout" class="btn btn-sm btn-secondary" title="Deconectare">
            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" fill="none" stroke-width="2" style="vertical-align:middle"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Ieșire
        </a>
    </div>
</header>
