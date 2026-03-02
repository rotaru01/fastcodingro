<?php
$current_admin_page = 'portfolio';
$is_new = empty($project['id']);
$page_title = $is_new ? 'Proiect Nou' : 'Editează Proiect';

ob_start();
?>

<div class="toolbar">
    <div>
        <h1><?= $is_new ? 'Proiect Nou' : 'Editează Proiect' ?></h1>
        <p class="subtitle"><?= $is_new ? 'Adaugă un proiect nou în portofoliu' : 'Modifică „' . htmlspecialchars($project['title'] ?? '') . '"' ?></p>
    </div>
    <div class="btn-group">
        <a href="/admin/portfolio" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" fill="none" stroke-width="2" style="vertical-align:middle;margin-right:4px"><polyline points="15 18 9 12 15 6"/></svg>
            Înapoi
        </a>
        <?php if (!$is_new): ?>
            <form method="POST" action="/admin/portfolio" style="display:inline" onsubmit="return confirm('Sigur vrei să ștergi acest proiect?')">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $project['id'] ?>">
                <button type="submit" class="btn btn-danger">Șterge</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<form method="POST" action="/admin/portfolio" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
    <input type="hidden" name="action" value="<?= $is_new ? 'create' : 'update' ?>">
    <?php if (!$is_new): ?>
        <input type="hidden" name="id" value="<?= $project['id'] ?>">
    <?php endif; ?>

    <div class="edit-grid">
        <div class="edit-main">
            <div class="card">
                <div class="form-group">
                    <label for="title">Titlu proiect *</label>
                    <input type="text" id="title" name="title" placeholder="Ex: Apartament Luxury - Cluj Napoca"
                           value="<?= htmlspecialchars($project['title'] ?? '') ?>" required data-slug-source>
                </div>

                <div class="form-group">
                    <label for="slug">Slug (URL)</label>
                    <div class="input-prefix-group">
                        <span class="input-prefix">/portofoliu/</span>
                        <input type="text" id="slug" name="slug" placeholder="se-genereaza-automat"
                               value="<?= htmlspecialchars($project['slug'] ?? '') ?>" data-slug-target>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Descriere</label>
                    <textarea id="description" name="description" rows="8" placeholder="Descrierea proiectului..."><?= htmlspecialchars($project['description'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="matterport_url">URL Matterport</label>
                    <input type="url" id="matterport_url" name="matterport_url" placeholder="https://my.matterport.com/show/?m=..."
                           value="<?= htmlspecialchars($project['matterport_url'] ?? '') ?>">
                </div>
            </div>

            <div class="card" style="margin-top:16px">
                <h3 style="margin-bottom:16px">Locație</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="city">Oraș</label>
                        <input type="text" id="city" name="city" placeholder="Ex: Cluj-Napoca"
                               value="<?= htmlspecialchars($project['city'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="address">Adresă</label>
                        <input type="text" id="address" name="address" placeholder="Ex: Str. Memorandumului nr. 10"
                               value="<?= htmlspecialchars($project['address'] ?? '') ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="latitude">Latitudine</label>
                        <input type="text" id="latitude" name="latitude" placeholder="Ex: 46.7712"
                               value="<?= htmlspecialchars($project['latitude'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="longitude">Longitudine</label>
                        <input type="text" id="longitude" name="longitude" placeholder="Ex: 23.6236"
                               value="<?= htmlspecialchars($project['longitude'] ?? '') ?>">
                    </div>
                </div>
                <p class="form-hint">Coordonatele sunt folosite pentru afișarea pe hartă. Poți folosi Google Maps pentru a le determina.</p>
            </div>
        </div>

        <div class="edit-sidebar">
            <div class="card">
                <h3 style="margin-bottom:16px">Publicare</h3>

                <div class="form-group">
                    <label for="category_id">Categorie *</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">-- Selectează --</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= ($project['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name_ro'] ?? $cat['name'] ?? '') ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="completed_at">Data finalizării</label>
                    <input type="date" id="completed_at" name="completed_at"
                           value="<?= !empty($project['completed_at']) ? date('Y-m-d', strtotime($project['completed_at'])) : '' ?>">
                </div>

                <div class="form-group">
                    <label class="toggle-label">
                        <input type="checkbox" name="is_featured" value="1" <?= !empty($project['is_featured']) ? 'checked' : '' ?>>
                        <span class="toggle-switch"></span>
                        Proiect featured
                    </label>
                </div>

                <div class="form-group">
                    <label class="toggle-label">
                        <input type="checkbox" name="is_active" value="1" <?= ($is_new || !empty($project['is_active'])) ? 'checked' : '' ?>>
                        <span class="toggle-switch"></span>
                        Activ (vizibil pe site)
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <?= $is_new ? 'Salvează Proiectul' : 'Actualizează' ?>
                </button>
            </div>

            <div class="card" style="margin-top:16px">
                <h3 style="margin-bottom:16px">Imagine principală</h3>
                <div class="form-group">
                    <label for="thumbnail">URL imagine</label>
                    <input type="text" id="thumbnail" name="thumbnail" placeholder="https://..."
                           value="<?= htmlspecialchars($project['thumbnail'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Sau încarcă un fișier</label>
                    <div class="upload-zone" id="thumbnailUpload">
                        <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" fill="none" stroke-width="1.5"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        <p>Trage imaginea sau click</p>
                        <input type="file" name="thumbnail_file" accept="image/*" class="upload-input">
                    </div>
                    <?php if (!empty($project['thumbnail'])): ?>
                        <div class="preview-image" style="margin-top:12px">
                            <img src="<?= htmlspecialchars($project['thumbnail']) ?>" alt="Preview" style="max-width:100%;border-radius:8px">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</form>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/admin-layout.php';
?>
