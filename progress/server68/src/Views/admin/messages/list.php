<?php
$current_admin_page = 'messages';
$page_title = 'Mesaje';
$current_status = $current_status ?? 'all';

ob_start();
?>

<h1>Mesaje</h1>
<p class="subtitle">Gestionează mesajele primite din formularul de contact</p>

<div class="tabs">
    <a href="/admin/messages" class="tab <?= $current_status === 'all' ? 'active' : '' ?>">
        Toate <span class="tab-count"><?= $counts['total'] ?? 0 ?></span>
    </a>
    <a href="/admin/messages?status=new" class="tab <?= $current_status === 'new' ? 'active' : '' ?>">
        Noi <span class="tab-count"><?= $counts['new'] ?? 0 ?></span>
    </a>
    <a href="/admin/messages?status=read" class="tab <?= $current_status === 'read' ? 'active' : '' ?>">
        Citite <span class="tab-count"><?= $counts['read'] ?? 0 ?></span>
    </a>
    <a href="/admin/messages?status=replied" class="tab <?= $current_status === 'replied' ? 'active' : '' ?>">
        Răspuns <span class="tab-count"><?= $counts['replied'] ?? 0 ?></span>
    </a>
    <a href="/admin/messages?status=archived" class="tab <?= $current_status === 'archived' ? 'active' : '' ?>">
        Arhivate <span class="tab-count"><?= $counts['archived'] ?? 0 ?></span>
    </a>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th width="5%">
                    <input type="checkbox" id="selectAll" class="checkbox">
                </th>
                <th width="20%">Nume</th>
                <th width="20%">Email</th>
                <th width="20%">Serviciu / Subiect</th>
                <th width="15%">Data</th>
                <th width="10%">Status</th>
                <th width="10%">Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($messages)): ?>
                <?php foreach ($messages as $msg): ?>
                    <tr class="<?= $msg['status'] === 'new' ? 'row-unread' : '' ?>">
                        <td>
                            <input type="checkbox" class="checkbox row-select" value="<?= $msg['id'] ?>">
                        </td>
                        <td>
                            <a href="/admin/messages?action=view&id=<?= $msg['id'] ?>" class="table-link">
                                <strong><?= htmlspecialchars($msg['name']) ?></strong>
                            </a>
                        </td>
                        <td>
                            <a href="mailto:<?= htmlspecialchars($msg['email']) ?>" class="table-link-subtle">
                                <?= htmlspecialchars($msg['email']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($msg['subject'] ?? '-') ?></td>
                        <td>
                            <span class="text-muted"><?= date('d.m.Y', strtotime($msg['created_at'])) ?></span>
                            <br>
                            <small class="text-muted"><?= date('H:i', strtotime($msg['created_at'])) ?></small>
                        </td>
                        <td>
                            <?php
                            $statusClass = match($msg['status']) {
                                'new' => 'badge-green',
                                'read' => 'badge-blue',
                                'replied' => 'badge-purple',
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
                        <td>
                            <div class="action-buttons">
                                <a href="/admin/messages?action=view&id=<?= $msg['id'] ?>" class="btn btn-xs btn-secondary" title="Vizualizează">
                                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" fill="none" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                <form method="POST" action="/admin/messages" style="display:inline" onsubmit="return confirm('Sigur vrei să ștergi acest mesaj?')">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $msg['id'] ?>">
                                    <button type="submit" class="btn btn-xs btn-danger" title="Șterge">
                                        <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" fill="none" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="empty-state">Niciun mesaj găsit</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if (($total_pages ?? 1) > 1): ?>
    <div class="pagination">
        <?php if ($current_page > 1): ?>
            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $current_page - 1])) ?>" class="pagination-btn">&laquo; Anterior</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"
               class="pagination-btn <?= $i === $current_page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages): ?>
            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $current_page + 1])) ?>" class="pagination-btn">Următor &raquo;</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/admin-layout.php';
?>
