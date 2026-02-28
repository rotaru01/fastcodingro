<?php
/**
 * Componenta FAQ cu Schema.org FAQPage markup
 * GEO: FAQ schema are o rata de citare de 67% in raspunsurile AI
 *
 * Variabile:
 * @var array  $faqItems     - array de ['question' => '...', 'answer' => '...']
 * @var string $faqTitle     - titlul sectiunii (optional, default: 'Întrebări Frecvente')
 * @var string $faqSubtitle  - subtitlu (optional)
 */
$faqTitle = $faqTitle ?? 'Întrebări Frecvente';
$faqSubtitle = $faqSubtitle ?? 'Răspunsuri la cele mai comune întrebări despre serviciile noastre.';
$faqItems = $faqItems ?? [];

if (empty($faqItems)) return;
?>

<!-- ===== FAQ Section — GEO Optimized ===== -->
<section class="faq-section" style="padding: 80px 0;" itemscope itemtype="https://schema.org/FAQPage">
  <div class="container" style="max-width: 900px; margin: 0 auto; padding: 0 24px;">
    <div class="section-header" style="text-align: center; margin-bottom: 48px;">
      <span style="display: inline-block; padding: 6px 16px; background: rgba(4,180,148,0.1); border-radius: 20px; font-size: 13px; font-weight: 600; color: #04B494; margin-bottom: 16px;">FAQ</span>
      <h2 style="font-size: 32px; font-weight: 700;"><?= htmlspecialchars($faqTitle) ?></h2>
      <?php if ($faqSubtitle): ?>
      <p style="color: #94A3B8; margin-top: 12px; font-size: 16px;"><?= htmlspecialchars($faqSubtitle) ?></p>
      <?php endif; ?>
    </div>

    <div class="faq-list">
      <?php foreach ($faqItems as $i => $item): ?>
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" style="margin-bottom: 16px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); border-radius: 16px; overflow: hidden;">
        <button class="faq-toggle" onclick="this.parentElement.classList.toggle('open')" aria-expanded="false" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; background: none; border: none; color: #fff; font-family: 'Inter', sans-serif; font-size: 16px; font-weight: 600; text-align: left; cursor: pointer; transition: color 0.3s;">
          <span itemprop="name"><?= htmlspecialchars($item['question']) ?></span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-left: 16px; transition: transform 0.3s;"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" style="max-height: 0; overflow: hidden; transition: max-height 0.4s ease, padding 0.3s;">
          <div itemprop="text" style="padding: 0 24px 20px; color: #CBD5E1; font-size: 15px; line-height: 1.8;">
            <?= htmlspecialchars($item['answer']) ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- FAQ JSON-LD Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    <?php foreach ($faqItems as $i => $item): ?>
    {
      "@type": "Question",
      "name": <?= json_encode($item['question'], JSON_UNESCAPED_UNICODE) ?>,
      "acceptedAnswer": {
        "@type": "Answer",
        "text": <?= json_encode($item['answer'], JSON_UNESCAPED_UNICODE) ?>
      }
    }<?= $i < count($faqItems) - 1 ? ',' : '' ?>

    <?php endforeach; ?>
  ]
}
</script>

<style>
.faq-item.open .faq-toggle svg { transform: rotate(180deg); }
.faq-item.open .faq-toggle { color: #04B494; }
.faq-item.open .faq-answer { max-height: 500px; }
.faq-toggle:hover { color: #04B494; }
</style>
