<?php
$current_admin_page = 'portfolio';
$page_title = 'Portofoliu';
$current_category = $current_category ?? '';

ob_start();
?>

<div class="toolbar">
    <div>
        <h1>Portofoliu</h1>
        <p class="subtitle">Gestionează proiectele din portofoliu</p>
    </div>
    <a href="/admin/portfolio?action=edit" class="btn btn-primary">+ Proiect Nou</a>
</div>

<?php if (!empty($categories)): ?>
    <div class="tabs">
        <a href="/admin/portfolio" class="tab <?= empty($current_category) ? 'active' : '' ?>">Toate</a>
        <?php foreach ($categories as $cat): ?>
            <a href="/admin/portfolio?category=<?= $cat['id'] ?>" class="tab <?= $current_category == $cat['id'] ? 'active' : '' ?>">
                <?= htmlspecialchars($cat['name_ro'] ?? $cat['name'] ?? '') ?>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th width="30%">Titlu</th>
                <th width="15%">Categorie</th>
                <th width="12%">Oraș</th>
                <th width="8%">Featured</th>
                <th width="8%">Status</th>
                <th width="12%">Data</th>
                <th width="15%">Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($projects)): ?>
                <?php foreach ($projects as $project): ?>
                    <tr>
                        <td>
                            <div class="post-cell">
                                <?php if (!empty($project['thumbnail'])): ?>
                                    <img src="<?= htmlspecialchars($project['thumbnail']) ?>" alt="" class="post-thumb">
                                <?php endif; ?>
                                <div>
                                    <a href="/admin/portfolio?action=edit&id=<?= $project['id'] ?>" class="table-link">
                                        <strong><?= htmlspecialchars($project['title']) ?></strong>
                                    </a>
                                    <?php if (!empty($project['slug'])): ?>
                                        <small class="text-muted d-block">/portofoliu/<?= htmlspecialchars($project['slug']) ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($project['category_name'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($project['city'] ?? '-') ?></td>
                        <td>
                            <?php if (!empty($project['is_featured'])): ?>
                                <span class="badge badge-yellow">Featured</span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($project['is_active'])): ?>
                                <span class="badge badge-green">Activ</span>
                            <?php else: ?>
                                <span class="badge badge-gray">Inactiv</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($project['completion_date'])): ?>
                                <?= date('d.m.Y', strtotime($project['completion_date'])) ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="/admin/portfolio?action=edit&id=<?= $project['id'] ?>" class="btn btn-xs btn-secondary" title="Editează">
                                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" fill="none" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <?php if (!empty($project['matterport_url'])): ?>
                                    <a href="<?= htmlspecialchars($project['matterport_url']) ?>" target="_blank" class="btn btn-xs btn-secondary" title="Matterport">
                                        <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" fill="none" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                    </a>
                                <?php endif; ?>
                                <form method="POST" action="/admin/portfolio" style="display:inline" onsubmit="return confirm('Sigur vrei să ștergi proiectul „<?= htmlspecialchars(addslashes($project['title'])) ?>"?')">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $project['id'] ?>">
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
                    <td colspan="7" class="empty-state">
                        Niciun proiect găsit. <a href="/admin/portfolio?action=edit" class="table-link">Adaugă primul proiect</a>.
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
