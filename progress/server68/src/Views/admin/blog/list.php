<?php
$current_admin_page = 'blog';
$page_title = 'Articole Blog';
$current_status = $current_status ?? 'all';

ob_start();
?>

<div class="toolbar">
    <div>
        <h1>Articole Blog</h1>
        <p class="subtitle">Gestionează articolele publicate pe blog</p>
    </div>
    <a href="/admin/blog/new" class="btn btn-primary">+ Articol Nou</a>
</div>

<div class="tabs">
    <a href="/admin/blog" class="tab <?= $current_status === 'all' ? 'active' : '' ?>">
        Toate <span class="tab-count"><?= $counts['total'] ?? 0 ?></span>
    </a>
    <a href="/admin/blog?status=published" class="tab <?= $current_status === 'published' ? 'active' : '' ?>">
        Publicate <span class="tab-count"><?= $counts['published'] ?? 0 ?></span>
    </a>
    <a href="/admin/blog?status=draft" class="tab <?= $current_status === 'draft' ? 'active' : '' ?>">
        Ciorne <span class="tab-count"><?= $counts['draft'] ?? 0 ?></span>
    </a>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th width="35%">Titlu</th>
                <th width="15%">Categorie</th>
                <th width="10%">Status</th>
                <th width="15%">Data publicării</th>
                <th width="10%">Vizualizări</th>
                <th width="15%">Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td>
                            <div class="post-cell">
                                <?php if (!empty($post['featured_image'])): ?>
                                    <img src="<?= htmlspecialchars($post['featured_image']) ?>" alt="" class="post-thumb">
                                <?php endif; ?>
                                <div>
                                    <a href="/admin/blog/edit/<?= $post['id'] ?>" class="table-link">
                                        <strong><?= htmlspecialchars($post['title']) ?></strong>
                                    </a>
                                    <?php if (!empty($post['excerpt'])): ?>
                                        <small class="text-muted d-block"><?= htmlspecialchars(mb_substr($post['excerpt'], 0, 60)) ?>...</small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($post['category_name'] ?? $post['category'] ?? '-') ?></td>
                        <td>
                            <?php
                            $statusClass = $post['status'] === 'published' ? 'badge-green' : 'badge-yellow';
                            $statusLabel = $post['status'] === 'published' ? 'Publicat' : 'Ciornă';
                            ?>
                            <span class="badge <?= $statusClass ?>"><?= $statusLabel ?></span>
                        </td>
                        <td>
                            <?php if (!empty($post['published_at'])): ?>
                                <?= date('d.m.Y', strtotime($post['published_at'])) ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="text-muted"><?= $post['views_count'] ?? 0 ?></span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="/admin/blog/edit/<?= $post['id'] ?>" class="btn btn-xs btn-secondary" title="Editează">
                                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" fill="none" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <?php if ($post['status'] === 'published'): ?>
                                    <a href="/blog/<?= htmlspecialchars($post['slug']) ?>" target="_blank" class="btn btn-xs btn-secondary" title="Vezi pe site">
                                        <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" fill="none" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                    </a>
                                <?php endif; ?>
                                <form method="POST" action="/admin/blog/delete/<?= $post['id'] ?>" style="display:inline" onsubmit="return confirm('Sigur vrei să ștergi articolul „<?= htmlspecialchars(addslashes($post['title'])) ?>"?')">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
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
                    <td colspan="6" class="empty-state">
                        Niciun articol găsit. <a href="/admin/blog/new" class="table-link">Creează primul articol</a>.
                    </td>
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
