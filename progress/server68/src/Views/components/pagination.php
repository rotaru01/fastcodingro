<?php
/**
 * Componenta Pagination
 *
 * Variabile disponibile:
 * @var int    $currentPage - pagina curenta
 * @var int    $totalPages  - numarul total de pagini
 * @var string $baseUrl     - URL-ul de baza (ex: '/blog')
 * @var string $queryParam  - parametrul query string (default: 'page')
 */
$currentPage = $currentPage ?? 1;
$totalPages = $totalPages ?? 1;
$baseUrl = $baseUrl ?? '/blog';
$queryParam = $queryParam ?? 'page';

/**
 * Construieste URL-ul pentru o pagina specifica,
 * pastrand ceilalti parametri din query string.
 */
function buildPageUrl(string $baseUrl, int $page, string $queryParam): string
{
    $params = $_GET;
    $params[$queryParam] = $page;
    return $baseUrl . '?' . http_build_query($params);
}
?>

<?php if ($totalPages > 1): ?>
<nav class="pagination" aria-label="Paginare">
  <div class="pagination-list">
    <?php if ($currentPage > 1): ?>
    <a href="<?= htmlspecialchars(buildPageUrl($baseUrl, $currentPage - 1, $queryParam)) ?>"
       class="pagination-btn pagination-prev" aria-label="Pagina anterioară">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
    </a>
    <?php endif; ?>

    <?php
    $start = max(1, $currentPage - 2);
    $end = min($totalPages, $currentPage + 2);

    if ($start > 1): ?>
    <a href="<?= htmlspecialchars(buildPageUrl($baseUrl, 1, $queryParam)) ?>" class="pagination-btn">1</a>
    <?php if ($start > 2): ?>
    <span class="pagination-dots">...</span>
    <?php endif; ?>
    <?php endif; ?>

    <?php for ($i = $start; $i <= $end; $i++): ?>
    <a href="<?= htmlspecialchars(buildPageUrl($baseUrl, $i, $queryParam)) ?>"
       class="pagination-btn<?= $i === $currentPage ? ' active' : '' ?>"
       <?= $i === $currentPage ? 'aria-current="page"' : '' ?>>
      <?= $i ?>
    </a>
    <?php endfor; ?>

    <?php if ($end < $totalPages): ?>
    <?php if ($end < $totalPages - 1): ?>
    <span class="pagination-dots">...</span>
    <?php endif; ?>
    <a href="<?= htmlspecialchars(buildPageUrl($baseUrl, $totalPages, $queryParam)) ?>" class="pagination-btn"><?= $totalPages ?></a>
    <?php endif; ?>

    <?php if ($currentPage < $totalPages): ?>
    <a href="<?= htmlspecialchars(buildPageUrl($baseUrl, $currentPage + 1, $queryParam)) ?>"
       class="pagination-btn pagination-next" aria-label="Pagina următoare">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
    </a>
    <?php endif; ?>
  </div>
</nav>
<?php endif; ?>
