<?php
$current_admin_page = 'messages';
$page_title = 'Vizualizare mesaj';

ob_start();
?>

<div class="toolbar">
    <div>
        <h1>Mesaj de la <?= htmlspecialchars($message['name'] ?? '') ?></h1>
        <p class="subtitle">Primit pe <?= date('d.m.Y la H:i', strtotime($message['created_at'])) ?></p>
    </div>
    <div class="btn-group">
        <a href="/admin/messages" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" fill="none" stroke-width="2" style="vertical-align:middle;margin-right:4px"><polyline points="15 18 9 12 15 6"/></svg>
            Înapoi la mesaje
        </a>
    </div>
</div>

<div class="message-detail-grid">
    <div class="card message-content-card">
        <div class="message-meta-row">
            <div class="message-meta-item">
                <span class="message-meta-label">Nume</span>
                <span class="message-meta-value"><?= htmlspecialchars($message['name']) ?></span>
            </div>
            <div class="message-meta-item">
                <span class="message-meta-label">Email</span>
                <span class="message-meta-value">
                    <a href="mailto:<?= htmlspecialchars($message['email']) ?>" class="table-link">
                        <?= htmlspecialchars($message['email']) ?>
                    </a>
                </span>
            </div>
            <?php if (!empty($message['phone'])): ?>
                <div class="message-meta-item">
                    <span class="message-meta-label">Telefon</span>
                    <span class="message-meta-value">
                        <a href="tel:<?= htmlspecialchars($message['phone']) ?>" class="table-link">
                            <?= htmlspecialchars($message['phone']) ?>
                        </a>
                    </span>
                </div>
            <?php endif; ?>
            <?php if (!empty($message['subject'])): ?>
                <div class="message-meta-item">
                    <span class="message-meta-label">Subiect / Serviciu</span>
                    <span class="message-meta-value"><?= htmlspecialchars($message['subject']) ?></span>
                </div>
            <?php endif; ?>
        </div>

        <div class="message-body">
            <h3>Mesaj</h3>
            <div class="message-text">
                <?= nl2br(htmlspecialchars($message['message'] ?? '')) ?>
            </div>
        </div>

        <div class="message-footer-info">
            <small class="text-muted">
                IP: <?= htmlspecialchars($message['ip_address'] ?? 'N/A') ?> |
                User Agent: <?= htmlspecialchars(mb_substr($message['user_agent'] ?? 'N/A', 0, 80)) ?>
                <?php if (!empty($message['read_at'])): ?>
                    | Citit: <?= date('d.m.Y H:i', strtotime($message['read_at'])) ?>
                <?php endif; ?>
                <?php if (!empty($message['replied_at'])): ?>
                    | Răspuns: <?= date('d.m.Y H:i', strtotime($message['replied_at'])) ?>
                <?php endif; ?>
            </small>
        </div>
    </div>

    <div class="message-actions-card">
        <div class="card">
            <h3>Status</h3>
            <?php
            $statusClass = match($message['status']) {
                'new' => 'badge-green',
                'read' => 'badge-blue',
                'replied' => 'badge-purple',
                'archived' => 'badge-gray',
                default => 'badge-gray',
            };
            $statusLabel = match($message['status']) {
                'new' => 'Nou',
                'read' => 'Citit',
                'replied' => 'Răspuns',
                'archived' => 'Arhivat',
                default => $message['status'],
            };
            ?>
            <span class="badge badge-lg <?= $statusClass ?>" style="margin-bottom:16px;display:inline-block"><?= $statusLabel ?></span>

            <div class="message-action-buttons">
                <?php if ($message['status'] === 'new'): ?>
                    <form method="POST" action="/admin/messages">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        <input type="hidden" name="action" value="mark_read">
                        <input type="hidden" name="id" value="<?= $message['id'] ?>">
                        <button type="submit" class="btn btn-primary btn-block">
                            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" fill="none" stroke-width="2" style="vertical-align:middle;margin-right:4px"><polyline points="20 6 9 17 4 12"/></svg>
                            Marchează ca citit
                        </button>
                    </form>
                <?php endif; ?>

                <?php if ($message['status'] !== 'replied'): ?>
                    <form method="POST" action="/admin/messages">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        <input type="hidden" name="action" value="mark_replied">
                        <input type="hidden" name="id" value="<?= $message['id'] ?>">
                        <button type="submit" class="btn btn-secondary btn-block">
                            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" fill="none" stroke-width="2" style="vertical-align:middle;margin-right:4px"><polyline points="9 17 4 12 9 7"/><path d="M20 18v-2a4 4 0 00-4-4H4"/></svg>
                            Marchează ca răspuns
                        </button>
                    </form>
                <?php endif; ?>

                <?php if ($message['status'] !== 'archived'): ?>
                    <form method="POST" action="/admin/messages">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        <input type="hidden" name="action" value="archive">
                        <input type="hidden" name="id" value="<?= $message['id'] ?>">
                        <button type="submit" class="btn btn-secondary btn-block">
                            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" fill="none" stroke-width="2" style="vertical-align:middle;margin-right:4px"><polyline points="21 8 21 21 3 21 3 8"/><rect x="1" y="3" width="22" height="5"/></svg>
                            Arhivează
                        </button>
                    </form>
                <?php endif; ?>

                <form method="POST" action="/admin/messages" onsubmit="return confirm('Sigur vrei să ștergi acest mesaj? Acțiunea este ireversibilă.')">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $message['id'] ?>">
                    <button type="submit" class="btn btn-danger btn-block">
                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" fill="none" stroke-width="2" style="vertical-align:middle;margin-right:4px"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                        Șterge mesajul
                    </button>
                </form>
            </div>
        </div>

        <div class="card" style="margin-top:16px">
            <h3>Notă internă</h3>
            <form method="POST" action="/admin/messages">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                <input type="hidden" name="action" value="add_note">
                <input type="hidden" name="id" value="<?= $message['id'] ?>">
                <div class="form-group">
                    <textarea name="admin_note" rows="3" placeholder="Adaugă o notă internă..."><?= htmlspecialchars($message['admin_note'] ?? '') ?></textarea>
                </div>
                <button type="submit" class="btn btn-secondary btn-block">Salvează nota</button>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/admin-layout.php';
?>
