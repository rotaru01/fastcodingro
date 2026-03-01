<?php
/**
 * Componenta Counter / Stats
 */
$stats = $stats ?? [
    ['value' => '500', 'suffix' => '+', 'label' => 'Proiecte Livrate'],
    ['value' => '150', 'suffix' => '+', 'label' => 'Clienți Mulțumiți'],
    ['value' => '7',   'suffix' => '+', 'label' => 'Ani de Experiență'],
    ['value' => '98',  'suffix' => '%', 'label' => 'Rată de Satisfacție'],
];
?>

<?php if (!empty($stats)): ?>
<!-- ===== STATS COUNTER ===== -->
<section class="stats-section">
  <div class="container">
    <div class="stats-grid">
      <?php foreach ($stats as $stat): ?>
      <div class="stat-item">
        <div class="stat-number" data-count="<?= htmlspecialchars($stat['value'] ?? '0') ?>">0</div>
        <div class="stat-label"><?= htmlspecialchars($stat['label'] ?? '') ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
