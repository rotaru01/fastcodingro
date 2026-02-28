<?php
/**
 * Componenta Breadcrumb
 *
 * Variabile disponibile:
 * @var array $breadcrumbs - array de perechi [text, url], ultimul element fara url (pagina curenta)
 *   Exemplu: [['Acasă', '/'], ['Servicii', '/servicii'], ['Tur Virtual 3D', '']]
 */
$breadcrumbs = $breadcrumbs ?? [];
?>

<?php if (!empty($breadcrumbs)): ?>
<nav class="breadcrumb" aria-label="Breadcrumb">
  <div class="container">
    <ol class="breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
      <?php foreach ($breadcrumbs as $index => $crumb): ?>
      <li class="breadcrumb-item<?= $index === count($breadcrumbs) - 1 ? ' active' : '' ?>"
          itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <?php if ($index < count($breadcrumbs) - 1 && !empty($crumb[1])): ?>
        <a href="<?= htmlspecialchars($crumb[1]) ?>" itemprop="item">
          <span itemprop="name"><?= htmlspecialchars($crumb[0]) ?></span>
        </a>
        <svg class="breadcrumb-separator" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
        <?php else: ?>
        <span itemprop="name"><?= htmlspecialchars($crumb[0]) ?></span>
        <?php endif; ?>
        <meta itemprop="position" content="<?= $index + 1 ?>">
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</nav>
<?php endif; ?>
