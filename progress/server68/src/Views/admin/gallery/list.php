<?php
$current_admin_page = 'gallery';
$page_title = 'Galerii';

ob_start();
?>

<div class="toolbar">
    <div>
        <h1>Galerii</h1>
        <p class="subtitle">Gestionează galeriile foto și video</p>
    </div>
</div>

<div class="card" style="margin-bottom:24px">
    <h3 style="margin-bottom:16px">Adaugă galerie nouă</h3>
    <form method="POST" action="/admin/gallery" class="form-inline">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
        <input type="hidden" name="action" value="create_gallery">
        <div class="form-group">
            <label for="gallery_name">Nume galerie</label>
            <input type="text" id="gallery_name" name="name" placeholder="Ex: Portofoliu Fotografie" required>
        </div>
        <div class="form-group">
            <label for="gallery_slug">Slug</label>
            <input type="text" id="gallery_slug" name="slug" placeholder="portofoliu-fotografie" data-slug-target>
        </div>
        <div class="form-group">
            <label for="gallery_page">Pagină asociată</label>
            <select id="gallery_page" name="page">
                <option value="">-- Selectează --</option>
                <option value="home">Pagina principală</option>
                <option value="fotografie">Fotografie</option>
                <option value="videografie">Videografie</option>
                <option value="tur-virtual">Tur Virtual 3D</option>
                <option value="social-media">Social Media</option>
                <option value="sport">Sport Content</option>
                <option value="randare-3d">Randare 3D</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-bottom:16px;flex-shrink:0">Creează</button>
    </form>
</div>

<div class="galleries-grid">
    <?php if (!empty($galleries)): ?>
        <?php foreach ($galleries as $gallery): ?>
            <div class="gallery-card">
                <div class="gallery-card-header">
                    <div class="gallery-card-icon">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                    </div>
                    <div>
                        <h3><?= htmlspecialchars($gallery['name']) ?></h3>
                        <p class="text-muted"><?= $gallery['item_count'] ?? 0 ?> imagini</p>
                    </div>
                </div>
                <?php if (!empty($gallery['page'])): ?>
                    <p class="gallery-card-page">
                        <span class="badge badge-gray"><?= htmlspecialchars($gallery['page']) ?></span>
                    </p>
                <?php endif; ?>
                <div class="gallery-card-actions">
                    <a href="/admin/gallery?action=manage&id=<?= $gallery['id'] ?>" class="btn btn-sm btn-primary">Gestionează</a>
                    <form method="POST" action="/admin/gallery" style="display:inline" onsubmit="return confirm('Sigur vrei să ștergi galeria „<?= htmlspecialchars(addslashes($gallery['name'])) ?>" și toate imaginile din ea?')">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        <input type="hidden" name="action" value="delete_gallery">
                        <input type="hidden" name="id" value="<?= $gallery['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Șterge</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state-card">
            <svg viewBox="0 0 24 24" width="48" height="48" stroke="#94A3B8" fill="none" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
            <p>Nicio galerie creată încă</p>
            <small class="text-muted">Folosește formularul de mai sus pentru a crea prima galerie</small>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/admin-layout.php';
?>
