<?php
$current_admin_page = 'clients';
$page_title = 'Clienți & Parteneri';

ob_start();
?>

<div class="toolbar">
    <div>
        <h1>Clienți & Parteneri</h1>
        <p class="subtitle">Gestionează logo-urile clienților și partenerilor afișate pe site</p>
    </div>
</div>

<div class="card" style="margin-bottom:24px">
    <h3 style="margin-bottom:16px">Adaugă client / partener</h3>
    <form method="POST" action="/admin/clients" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
        <input type="hidden" name="action" value="create">

        <div class="form-row">
            <div class="form-group">
                <label for="name">Nume companie *</label>
                <input type="text" id="name" name="name" placeholder="Numele companiei" required>
            </div>
            <div class="form-group">
                <label for="website_url">Website (opțional)</label>
                <input type="url" id="website_url" name="website_url" placeholder="https://...">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="type">Tip</label>
                <select id="type" name="type">
                    <option value="client">Client</option>
                    <option value="partner">Partener</option>
                </select>
            </div>
            <div class="form-group">
                <label for="logo_url">URL logo</label>
                <input type="text" id="logo_url" name="logo_url" placeholder="https://...">
            </div>
        </div>

        <div class="form-group">
            <label>Sau încarcă logo</label>
            <div class="upload-zone" id="logoUploadZone">
                <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" fill="none" stroke-width="1.5"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                <p>Trage logo-ul aici sau click pentru a selecta</p>
                <small class="text-muted">PNG sau SVG recomandat, fundal transparent</small>
                <input type="file" name="logo_file" accept="image/*" class="upload-input">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Adaugă</button>
    </form>
</div>

<div class="tabs" style="margin-bottom:24px">
    <button class="tab active" onclick="filterClients('all')">Toți</button>
    <button class="tab" onclick="filterClients('client')">Clienți</button>
    <button class="tab" onclick="filterClients('partner')">Parteneri</button>
</div>

<div class="clients-grid" id="clientsGrid">
    <?php if (!empty($clients)): ?>
        <?php foreach ($clients as $client): ?>
            <div class="client-card" data-type="<?= htmlspecialchars($client['type'] ?? 'client') ?>">
                <div class="client-card-logo">
                    <?php if (!empty($client['logo_url'])): ?>
                        <img src="<?= htmlspecialchars($client['logo_url']) ?>" alt="<?= htmlspecialchars($client['name']) ?>">
                    <?php elseif (!empty($client['logo_path'])): ?>
                        <img src="<?= htmlspecialchars($client['logo_path']) ?>" alt="<?= htmlspecialchars($client['name']) ?>">
                    <?php else: ?>
                        <div class="client-card-placeholder">
                            <?= strtoupper(mb_substr($client['name'], 0, 2)) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="client-card-info">
                    <p class="client-card-name"><?= htmlspecialchars($client['name']) ?></p>
                    <span class="badge <?= $client['type'] === 'partner' ? 'badge-blue' : 'badge-gray' ?>">
                        <?= $client['type'] === 'partner' ? 'Partener' : 'Client' ?>
                    </span>
                    <?php if (!empty($client['website_url'])): ?>
                        <a href="<?= htmlspecialchars($client['website_url']) ?>" target="_blank" class="client-card-link">
                            <svg viewBox="0 0 24 24" width="12" height="12" stroke="currentColor" fill="none" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="client-card-actions">
                    <form method="POST" action="/admin/clients" style="display:inline">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        <input type="hidden" name="action" value="toggle_active">
                        <input type="hidden" name="id" value="<?= $client['id'] ?>">
                        <button type="submit" class="btn btn-xs <?= !empty($client['is_active']) ? 'btn-green' : 'btn-secondary' ?>">
                            <?= !empty($client['is_active']) ? 'Activ' : 'Inactiv' ?>
                        </button>
                    </form>
                    <form method="POST" action="/admin/clients" style="display:inline" onsubmit="return confirm('Sigur vrei să ștergi „<?= htmlspecialchars(addslashes($client['name'])) ?>"?')">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $client['id'] ?>">
                        <button type="submit" class="btn btn-xs btn-danger" title="Șterge">
                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" fill="none" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state-card" style="grid-column:1/-1">
            <p>Niciun client sau partener adăugat încă</p>
            <small class="text-muted">Folosește formularul de mai sus pentru a adăuga</small>
        </div>
    <?php endif; ?>
</div>

<script>
function filterClients(type) {
    document.querySelectorAll('.tabs .tab').forEach(t => t.classList.remove('active'));
    event.target.classList.add('active');
    document.querySelectorAll('.client-card').forEach(card => {
        if (type === 'all' || card.dataset.type === type) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/admin-layout.php';
?>
