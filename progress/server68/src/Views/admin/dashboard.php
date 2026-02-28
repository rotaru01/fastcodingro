<?php
$current_admin_page = 'dashboard';
$page_title = 'Dashboard';

ob_start();
?>

<h1>Dashboard</h1>
<p class="subtitle">Bun venit în panoul de administrare Scanbox.ro</p>

<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon stat-icon-teal">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </div>
        <div class="stat-info">
            <div class="label">Mesaje necitite</div>
            <div class="value"><?= $stats['unread_messages'] ?? 0 ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon-blue">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="2"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
        </div>
        <div class="stat-info">
            <div class="label">Proiecte portofoliu</div>
            <div class="value"><?= $stats['total_projects'] ?? 0 ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon-purple">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="2"><path d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
        </div>
        <div class="stat-info">
            <div class="label">Articole blog</div>
            <div class="value"><?= $stats['total_posts'] ?? 0 ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon-orange">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
        </div>
        <div class="stat-info">
            <div class="label">Imagini galerie</div>
            <div class="value"><?= $stats['total_gallery_images'] ?? 0 ?></div>
        </div>
    </div>
</div>

<div class="actions-row">
    <a href="/admin/blog/new" class="action-btn primary">+ Articol Nou</a>
    <a href="/admin/gallery" class="action-btn secondary">+ Galerie</a>
    <a href="/admin/portfolio" class="action-btn secondary">+ Proiect Nou</a>
    <a href="/admin/messages" class="action-btn secondary">Mesaje</a>
</div>

<div class="dashboard-grid">
    <div class="table-card">
        <div class="table-card-header">
            <h3>Mesaje recente</h3>
            <a href="/admin/messages" class="btn btn-sm btn-secondary">Vezi toate</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nume</th>
                    <th>Email</th>
                    <th>Subiect</th>
                    <th>Data</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recent_messages)): ?>
                    <?php foreach ($recent_messages as $msg): ?>
                        <tr>
                            <td>
                                <a href="/admin/messages?action=view&id=<?= $msg['id'] ?>" class="table-link">
                                    <?= htmlspecialchars($msg['name']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($msg['email']) ?></td>
                            <td><?= htmlspecialchars($msg['subject'] ?? '-') ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($msg['created_at'])) ?></td>
                            <td>
                                <?php
                                $statusClass = match($msg['status']) {
                                    'new' => 'badge-green',
                                    'read' => 'badge-blue',
                                    'replied' => 'badge-gray',
                                    'archived' => 'badge-gray',
                                    default => 'badge-gray',
                                };
                                $statusLabel = match($msg['status']) {
                                    'new' => 'Nou',
                                    'read' => 'Citit',
                                    'replied' => 'Răspuns',
                                    'archived' => 'Arhivat',
                                    default => $msg['status'],
                                };
                                ?>
                                <span class="badge <?= $statusClass ?>"><?= $statusLabel ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="empty-state">Niciun mesaj încă</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <h3>Activitate recentă</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Acțiune</th>
                    <th>Element</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recent_activity)): ?>
                    <?php foreach ($recent_activity as $activity): ?>
                        <tr>
                            <td>
                                <span class="badge <?= $activity['badge_class'] ?? 'badge-gray' ?>">
                                    <?= htmlspecialchars($activity['action']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($activity['item']) ?></td>
                            <td><?= htmlspecialchars($activity['date']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="empty-state">Nicio activitate recentă</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout/admin-layout.php';
?>
