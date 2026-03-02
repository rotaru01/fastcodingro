<?php
$current_admin_page = 'blog';
$is_new = empty($post['id']);
$page_title = $is_new ? 'Articol Nou' : 'Editează Articolul';

ob_start();
?>

<div class="toolbar">
    <div>
        <h1><?= $is_new ? 'Articol Nou' : 'Editează Articolul' ?></h1>
        <p class="subtitle"><?= $is_new ? 'Creează un articol nou pe blog' : 'Modifică articolul „' . htmlspecialchars($post['title'] ?? '') . '"' ?></p>
    </div>
    <div class="btn-group">
        <a href="/admin/blog" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" fill="none" stroke-width="2" style="vertical-align:middle;margin-right:4px"><polyline points="15 18 9 12 15 6"/></svg>
            Înapoi
        </a>
        <?php if (!$is_new): ?>
            <form method="POST" action="/admin/blog/delete/<?= $post['id'] ?>" style="display:inline" onsubmit="return confirm('Sigur vrei să ștergi acest articol?')">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                <button type="submit" class="btn btn-danger">Șterge</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<form method="POST" action="<?= $is_new ? '/admin/blog/new' : '/admin/blog/edit/' . $post['id'] ?>" enctype="multipart/form-data" id="blogForm">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

    <div class="edit-grid">
        <div class="edit-main">
            <div class="card">
                <div class="form-group">
                    <label for="title">Titlu articol *</label>
                    <input type="text" id="title" name="title" placeholder="Ex: 5 Motive să alegi un tur virtual 3D"
                           value="<?= htmlspecialchars($post['title'] ?? '') ?>" required data-slug-source>
                </div>

                <div class="form-group">
                    <label for="slug">Slug (URL)</label>
                    <div class="input-prefix-group">
                        <span class="input-prefix">/blog/</span>
                        <input type="text" id="slug" name="slug" placeholder="se-genereaza-automat"
                               value="<?= htmlspecialchars($post['slug'] ?? '') ?>" data-slug-target>
                    </div>
                </div>

                <div class="form-group">
                    <label for="excerpt">Rezumat</label>
                    <textarea id="excerpt" name="excerpt" rows="3" placeholder="Descriere scurtă pentru listarea articolelor..."><?= htmlspecialchars($post['excerpt'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="content">Conținut (HTML)</label>
                    <p class="form-hint">Poți folosi HTML pentru formatare avansată. Taguri permise: h2, h3, p, a, strong, em, ul, ol, li, img, blockquote.</p>
                    <textarea id="content" name="content" rows="20" placeholder="Scrie conținutul articolului aici..."><?= htmlspecialchars($post['content'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="card">
                <h3 style="margin-bottom:16px">SEO</h3>
                <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title" placeholder="Titlul pentru motoarele de căutare"
                           value="<?= htmlspecialchars($post['meta_title'] ?? '') ?>" maxlength="70">
                    <span class="char-count" data-for="meta_title">0/70</span>
                </div>
                <div class="form-group">
                    <label for="meta_description">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="2" placeholder="Descrierea pentru motoarele de căutare" maxlength="160"><?= htmlspecialchars($post['meta_description'] ?? '') ?></textarea>
                    <span class="char-count" data-for="meta_description">0/160</span>
                </div>
            </div>
        </div>

        <div class="edit-sidebar">
            <div class="card">
                <h3 style="margin-bottom:16px">Publicare</h3>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="draft" <?= ($post['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>Ciornă</option>
                        <option value="published" <?= ($post['status'] ?? '') === 'published' ? 'selected' : '' ?>>Publicat</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="published_at">Data publicării</label>
                    <input type="datetime-local" id="published_at" name="published_at"
                           value="<?= !empty($post['published_at']) ? date('Y-m-d\TH:i', strtotime($post['published_at'])) : date('Y-m-d\TH:i') ?>">
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <?= $is_new ? 'Publică Articolul' : 'Salvează Modificările' ?>
                </button>
            </div>

            <div class="card" style="margin-top:16px">
                <h3 style="margin-bottom:16px">Categorie</h3>
                <div class="form-group">
                    <select id="category_id" name="category_id">
                        <option value="">-- Selectează --</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= ($post['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name'] ?? $cat['name_ro'] ?? '') ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="tur-virtual">Tur Virtual 3D</option>
                            <option value="fotografie">Fotografie</option>
                            <option value="videografie">Videografie</option>
                            <option value="social-media">Social Media</option>
                            <option value="matterport">Matterport</option>
                            <option value="general">General</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div class="card" style="margin-top:16px">
                <h3 style="margin-bottom:16px">Imagine principală</h3>
                <div class="form-group">
                    <label for="featured_image">URL imagine</label>
                    <input type="text" id="featured_image" name="featured_image" placeholder="https://..."
                           value="<?= htmlspecialchars($post['featured_image'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Sau încarcă un fișier</label>
                    <div class="upload-zone" id="featuredImageUpload">
                        <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" fill="none" stroke-width="1.5"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        <p>Trage imaginea aici sau click pentru a alege</p>
                        <input type="file" name="featured_image_file" accept="image/*" class="upload-input">
                    </div>
                    <?php if (!empty($post['featured_image'])): ?>
                        <div class="preview-image" style="margin-top:12px">
                            <img src="<?= htmlspecialchars($post['featured_image']) ?>" alt="Preview" style="max-width:100%;border-radius:8px">
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card" style="margin-top:16px">
                <h3 style="margin-bottom:16px">Etichete</h3>
                <div class="form-group">
                    <input type="text" id="tags" name="tags" placeholder="Separate prin virgulă"
                           value="<?= htmlspecialchars($post['tags'] ?? '') ?>">
                    <span class="form-hint">Ex: tur virtual, matterport, 3D</span>
                </div>
            </div>
        </div>
    </div>
</form>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/admin-layout.php';
?>
