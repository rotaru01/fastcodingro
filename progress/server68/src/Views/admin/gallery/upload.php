<?php
$current_admin_page = 'gallery';
$page_title = 'Gestionare Galerie: ' . htmlspecialchars($gallery['name'] ?? '');

ob_start();
?>

<div class="toolbar">
    <div>
        <h1><?= htmlspecialchars($gallery['name'] ?? 'Galerie') ?></h1>
        <p class="subtitle"><?= count($items ?? []) ?> imagini in galerie</p>
    </div>
    <div class="btn-group">
        <a href="/admin/gallery" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" fill="none" stroke-width="2" style="vertical-align:middle;margin-right:4px"><polyline points="15 18 9 12 15 6"/></svg>
            Înapoi la galerii
        </a>
    </div>
</div>

<div class="card" style="margin-bottom:24px">
    <h3 style="margin-bottom:16px">Încarcă imagini</h3>
    <form method="POST" action="/admin/gallery" enctype="multipart/form-data" id="uploadForm">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
        <input type="hidden" name="action" value="upload_image">
        <input type="hidden" name="gallery_id" value="<?= $gallery['id'] ?>">

        <div class="upload-zone upload-zone-large" id="galleryUploadZone">
            <svg viewBox="0 0 24 24" width="48" height="48" stroke="currentColor" fill="none" stroke-width="1.5"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            <p>Trage imaginile aici sau click pentru a selecta</p>
            <small class="text-muted">JPG, PNG, WebP - max 5 MB per fișier</small>
            <input type="file" name="images[]" accept="image/jpeg,image/png,image/webp,image/gif" multiple class="upload-input" id="galleryFileInput">
        </div>

        <div id="uploadPreview" class="upload-preview-grid" style="display:none"></div>

        <div class="form-row" style="margin-top:16px">
            <div class="form-group">
                <label for="image_title">Titlu (opțional)</label>
                <input type="text" id="image_title" name="title" placeholder="Titlul imaginii">
            </div>
            <div class="form-group">
                <label for="image_alt">Text alternativ (SEO)</label>
                <input type="text" id="image_alt" name="alt_text" placeholder="Descriere pentru SEO">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" id="uploadBtn" disabled>Încarcă imaginile</button>
    </form>
</div>

<div class="card">
    <div class="table-card-header">
        <h3>Imagini în galerie</h3>
        <span class="text-muted"><?= count($items ?? []) ?> elemente</span>
    </div>

    <div class="gallery-items-grid sortable-container" id="galleryItemsGrid" data-type="gallery" data-gallery-id="<?= $gallery['id'] ?>">
        <?php if (!empty($items)): ?>
            <?php foreach ($items as $item): ?>
                <div class="gallery-manage-item" data-id="<?= $item['id'] ?>" draggable="true">
                    <div class="drag-handle" title="Trage pentru reordonare">
                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" fill="none" stroke-width="2"><circle cx="9" cy="5" r="1"/><circle cx="9" cy="12" r="1"/><circle cx="9" cy="19" r="1"/><circle cx="15" cy="5" r="1"/><circle cx="15" cy="12" r="1"/><circle cx="15" cy="19" r="1"/></svg>
                    </div>
                    <?php
                    $imgSrc = $item['thumbnail_path'] ?? $item['file_path'] ?? $item['url'] ?? '';
                    if (!empty($imgSrc) && !str_starts_with($imgSrc, 'http') && !str_starts_with($imgSrc, '/')) {
                        $imgSrc = '/uploads/' . $imgSrc;
                    }
                    ?>
                    <?php if (!empty($imgSrc)): ?>
                        <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($item['alt_text'] ?? $item['title'] ?? '') ?>" class="gallery-manage-thumb">
                    <?php else: ?>
                        <div class="gallery-manage-thumb gallery-manage-no-img">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="#94A3B8" fill="none" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                        </div>
                    <?php endif; ?>
                    <div class="gallery-manage-info">
                        <p class="gallery-manage-title"><?= htmlspecialchars($item['title'] ?? $item['original_filename'] ?? 'Fără titlu') ?></p>
                        <small class="text-muted"><?= htmlspecialchars($item['alt_text'] ?? '') ?></small>
                    </div>
                    <form method="POST" action="/admin/gallery" style="display:inline" onsubmit="return confirm('Sigur vrei să ștergi această imagine?')">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        <input type="hidden" name="action" value="delete_image">
                        <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                        <input type="hidden" name="gallery_id" value="<?= $gallery['id'] ?>">
                        <button type="submit" class="btn btn-xs btn-danger" title="Șterge imaginea">
                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" fill="none" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state-card" style="grid-column:1/-1">
                <p>Nicio imagine în galerie</p>
                <small class="text-muted">Folosește zona de upload de mai sus pentru a adăuga imagini</small>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/admin-layout.php';
?>
