<?php
$current_admin_page = 'testimonials';
$page_title = 'Testimoniale';

ob_start();
?>

<div class="toolbar">
    <div>
        <h1>Testimoniale</h1>
        <p class="subtitle">Gestionează testimonialele clienților afișate pe site</p>
    </div>
</div>

<div class="card" style="margin-bottom:24px">
    <h3 style="margin-bottom:16px">Adaugă testimonial nou</h3>
    <form method="POST" action="/admin/testimonials">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
        <input type="hidden" name="action" value="create">

        <div class="form-row">
            <div class="form-group">
                <label for="author_name">Nume autor *</label>
                <input type="text" id="author_name" name="author_name" placeholder="Numele clientului" required>
            </div>
            <div class="form-group">
                <label for="author_role">Rol / Funcție</label>
                <input type="text" id="author_role" name="author_role" placeholder="Ex: Director General">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="company">Companie</label>
                <input type="text" id="company" name="company" placeholder="Numele companiei">
            </div>
            <div class="form-group">
                <label for="photo_url">URL foto autor</label>
                <input type="text" id="photo_url" name="photo_url" placeholder="https://...">
            </div>
        </div>

        <div class="form-group">
            <label for="quote">Testimonial *</label>
            <textarea id="quote" name="quote" rows="3" placeholder="Ce a spus clientul despre serviciile noastre..." required></textarea>
        </div>

        <div class="form-inline">
            <div class="form-group">
                <label for="rating">Rating</label>
                <select id="rating" name="rating">
                    <option value="5">5 stele</option>
                    <option value="4">4 stele</option>
                    <option value="3">3 stele</option>
                    <option value="2">2 stele</option>
                    <option value="1">1 stea</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-bottom:16px;flex-shrink:0">Adaugă testimonial</button>
        </div>
    </form>
</div>

<div class="sortable-container" id="testimonialsList" data-type="testimonial">
    <?php if (!empty($testimonials)): ?>
        <?php foreach ($testimonials as $testimonial): ?>
            <div class="testimonial-manage-item" data-id="<?= $testimonial['id'] ?>">
                <div class="drag-handle" title="Trage pentru reordonare">
                    <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" fill="none" stroke-width="2"><circle cx="9" cy="5" r="1"/><circle cx="9" cy="12" r="1"/><circle cx="9" cy="19" r="1"/><circle cx="15" cy="5" r="1"/><circle cx="15" cy="12" r="1"/><circle cx="15" cy="19" r="1"/></svg>
                </div>

                <div class="testimonial-manage-content">
                    <div class="testimonial-manage-header">
                        <?php if (!empty($testimonial['photo_url'])): ?>
                            <img src="<?= htmlspecialchars($testimonial['photo_url']) ?>" alt="" class="testimonial-avatar">
                        <?php else: ?>
                            <div class="testimonial-avatar testimonial-avatar-placeholder">
                                <?= strtoupper(mb_substr($testimonial['author_name'] ?? 'A', 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                        <div>
                            <strong><?= htmlspecialchars($testimonial['author_name'] ?? '') ?></strong>
                            <span class="text-muted">
                                <?= htmlspecialchars($testimonial['author_role'] ?? '') ?>
                                <?php if (!empty($testimonial['company'])): ?>
                                    la <?= htmlspecialchars($testimonial['company']) ?>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>

                    <div class="testimonial-stars">
                        <?php
                        $rating = (int)($testimonial['rating'] ?? 5);
                        for ($i = 1; $i <= 5; $i++) {
                            echo $i <= $rating ? '<span class="star-filled">&#9733;</span>' : '<span class="star-empty">&#9734;</span>';
                        }
                        ?>
                    </div>

                    <p class="testimonial-quote">&bdquo;<?= htmlspecialchars($testimonial['quote'] ?? '') ?>&rdquo;</p>
                </div>

                <div class="testimonial-manage-actions">
                    <form method="POST" action="/admin/testimonials" style="display:inline">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        <input type="hidden" name="action" value="toggle_active">
                        <input type="hidden" name="id" value="<?= $testimonial['id'] ?>">
                        <button type="submit" class="btn btn-xs <?= !empty($testimonial['is_active']) ? 'btn-green' : 'btn-secondary' ?>" title="<?= !empty($testimonial['is_active']) ? 'Activ' : 'Inactiv' ?>">
                            <?= !empty($testimonial['is_active']) ? 'Activ' : 'Inactiv' ?>
                        </button>
                    </form>

                    <form method="POST" action="/admin/testimonials" style="display:inline" onsubmit="return confirm('Sigur vrei să ștergi acest testimonial?')">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $testimonial['id'] ?>">
                        <button type="submit" class="btn btn-xs btn-danger" title="Șterge">
                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" fill="none" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state-card">
            <p>Niciun testimonial adăugat încă</p>
            <small class="text-muted">Folosește formularul de mai sus pentru a adăuga primul testimonial</small>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/admin-layout.php';
?>
