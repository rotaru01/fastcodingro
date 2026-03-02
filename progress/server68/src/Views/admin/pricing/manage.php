<?php
$current_admin_page = 'pricing';
$page_title = 'Tarife';
$current_service = $current_service ?? '';
$editing = $editing ?? null;

$service_tabs = [
    'social-media'      => 'Social Media',
    'tur-virtual-3d'    => 'Tur Virtual 3D',
    'fotografie'        => 'Fotografie',
    'videografie-drone' => 'Videografie & Drone',
    'randare-3d'        => 'Randare 3D',
    'sport-content'     => 'Sport Content',
];

ob_start();
?>

<div class="toolbar">
    <div>
        <h1>Tarife</h1>
        <p class="subtitle">Gestionează pachetele de prețuri pentru fiecare serviciu</p>
    </div>
</div>

<div class="tabs">
    <a href="/admin/pricing" class="tab <?= empty($current_service) ? 'active' : '' ?>">Toate</a>
    <?php foreach ($service_tabs as $slug => $label): ?>
        <a href="/admin/pricing?service=<?= $slug ?>" class="tab <?= $current_service === $slug ? 'active' : '' ?>">
            <?= $label ?>
        </a>
    <?php endforeach; ?>
</div>

<div class="card" style="margin-bottom:24px" id="packageForm">
    <h3 style="margin-bottom:16px"><?= $editing ? 'Editează pachet' : 'Adaugă pachet nou' ?></h3>
    <form method="POST" action="/admin/pricing">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
        <input type="hidden" name="action" value="<?= $editing ? 'update' : 'create' ?>">
        <?php if ($editing): ?>
            <input type="hidden" name="id" value="<?= (int)$editing['id'] ?>">
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group">
                <label for="pkg_name">Nume pachet *</label>
                <input type="text" id="pkg_name" name="name" placeholder="Ex: Pachet Standard" required
                    value="<?= htmlspecialchars($editing['name'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="pkg_service">Serviciu *</label>
                <select id="pkg_service" name="service_page" required>
                    <option value="">-- Selectează --</option>
                    <?php foreach ($service_tabs as $slug => $label): ?>
                        <option value="<?= $slug ?>"
                            <?= ($editing ? ($editing['service_page'] ?? '') : $current_service) === $slug ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="pkg_price">Preț</label>
                <input type="text" id="pkg_price" name="price" placeholder="Ex: 499"
                    value="<?= htmlspecialchars($editing['price'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="pkg_currency">Monedă</label>
                <select id="pkg_currency" name="currency">
                    <option value="RON" <?= ($editing['currency'] ?? 'RON') === 'RON' ? 'selected' : '' ?>>RON</option>
                    <option value="EUR" <?= ($editing['currency'] ?? 'RON') === 'EUR' ? 'selected' : '' ?>>EUR</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="pkg_price_note">Notă preț</label>
            <input type="text" id="pkg_price_note" name="price_note" placeholder="Ex: de la, pe lună, per proiect"
                value="<?= htmlspecialchars($editing['price_note'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="pkg_features">Caracteristici (una pe linie)</label>
            <textarea id="pkg_features" name="features" rows="6" placeholder="Scanare 3D completă&#10;Imagini HDR&#10;Tur virtual interactiv&#10;Hosting 1 an inclus"><?= htmlspecialchars($editing['features_text'] ?? '') ?></textarea>
            <span class="form-hint">Scrie fiecare caracteristică pe o linie separată. Prefixează cu ~ pentru a marca ca neinclusă.</span>
        </div>

        <div class="form-inline">
            <div class="form-group">
                <label class="toggle-label">
                    <input type="checkbox" name="is_featured" value="1" <?= !empty($editing['is_featured']) ? 'checked' : '' ?>>
                    <span class="toggle-switch"></span>
                    Pachet recomandat
                </label>
            </div>
            <div style="display:flex;gap:8px;flex-shrink:0">
                <?php if ($editing): ?>
                    <a href="/admin/pricing<?= !empty($current_service) ? '?service=' . urlencode($current_service) : '' ?>" class="btn btn-secondary">Anulează</a>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary"><?= $editing ? 'Salvează modificări' : 'Adaugă pachet' ?></button>
            </div>
        </div>
    </form>
</div>

<?php if (!empty($packages)): ?>
    <?php
    $grouped = [];
    foreach ($packages as $pkg) {
        $svc = $pkg['service_page'] ?? 'other';
        $grouped[$svc][] = $pkg;
    }
    ?>
    <?php foreach ($grouped as $serviceSlug => $servicePackages): ?>
        <div class="card" style="margin-bottom:24px">
            <div class="table-card-header">
                <h3><?= htmlspecialchars($service_tabs[$serviceSlug] ?? ucfirst($serviceSlug)) ?></h3>
                <span class="text-muted"><?= count($servicePackages) ?> pachete</span>
            </div>

            <div class="pricing-packages-grid">
                <?php foreach ($servicePackages as $pkg): ?>
                    <div class="pricing-manage-card <?= !empty($pkg['is_featured']) ? 'pricing-featured' : '' ?> <?= empty($pkg['is_active']) ? 'pricing-inactive' : '' ?> <?= $editing && (int)$editing['id'] === (int)$pkg['id'] ? 'pricing-editing' : '' ?>">
                        <?php if (!empty($pkg['is_featured'])): ?>
                            <div class="pricing-featured-badge">Recomandat</div>
                        <?php endif; ?>

                        <h4 class="pricing-manage-name"><?= htmlspecialchars($pkg['name']) ?></h4>
                        <?php if (!empty($pkg['price']) && (float)$pkg['price'] > 0): ?>
                        <div class="pricing-manage-price">
                            <?php if (!empty($pkg['price_note'])): ?>
                                <span class="pricing-note"><?= htmlspecialchars($pkg['price_note']) ?></span>
                            <?php endif; ?>
                            <span class="pricing-amount"><?= htmlspecialchars($pkg['price']) ?></span>
                            <span class="pricing-currency"><?= htmlspecialchars($pkg['currency'] ?? 'RON') ?></span>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($pkg['features'])): ?>
                            <ul class="pricing-manage-features">
                                <?php
                                $features = is_string($pkg['features'])
                                    ? (json_decode($pkg['features'], true) ?? explode("\n", $pkg['features']))
                                    : (array)$pkg['features'];
                                foreach ($features as $feature):
                                    $feature = trim($feature);
                                    if (empty($feature)) continue;
                                    $excluded = str_starts_with($feature, '~');
                                    if ($excluded) $feature = ltrim($feature, '~');
                                ?>
                                    <li class="<?= $excluded ? 'feature-excluded' : '' ?>">
                                        <?= $excluded ? '<span class="feature-x">&#10005;</span>' : '<span class="feature-check">&#10003;</span>' ?>
                                        <?= htmlspecialchars($feature) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <div class="pricing-manage-actions">
                            <a href="/admin/pricing?edit=<?= $pkg['id'] ?><?= !empty($current_service) ? '&service=' . urlencode($current_service) : '' ?>#packageForm" class="btn btn-xs btn-secondary" title="Editează">
                                <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" fill="none" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <form method="POST" action="/admin/pricing" style="display:inline">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                <input type="hidden" name="action" value="toggle_featured">
                                <input type="hidden" name="id" value="<?= $pkg['id'] ?>">
                                <button type="submit" class="btn btn-xs <?= !empty($pkg['is_featured']) ? 'btn-yellow' : 'btn-secondary' ?>" title="Toggle featured">
                                    &#9733;
                                </button>
                            </form>
                            <form method="POST" action="/admin/pricing" style="display:inline">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                <input type="hidden" name="action" value="toggle_active">
                                <input type="hidden" name="id" value="<?= $pkg['id'] ?>">
                                <button type="submit" class="btn btn-xs <?= !empty($pkg['is_active']) ? 'btn-green' : 'btn-secondary' ?>">
                                    <?= !empty($pkg['is_active']) ? 'Activ' : 'Inactiv' ?>
                                </button>
                            </form>
                            <form method="POST" action="/admin/pricing" style="display:inline" onsubmit="return confirm('Sigur vrei să ștergi pachetul „<?= htmlspecialchars(addslashes($pkg['name'])) ?>"?')">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $pkg['id'] ?>">
                                <button type="submit" class="btn btn-xs btn-danger" title="Șterge">
                                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" fill="none" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="card">
        <div class="empty-state-card">
            <p>Niciun pachet de prețuri adăugat încă</p>
            <small class="text-muted">Folosește formularul de mai sus pentru a crea pachete</small>
        </div>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/admin-layout.php';
?>
