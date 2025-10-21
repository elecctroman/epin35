<?php
$title = 'Arama Sonuçları - MaxiStore';
$breadcrumb = [
  ['label' => 'Ana Sayfa', 'url' => \Core\Helpers::baseUrl('/')],
  ['label' => 'Arama']
];
ob_start();
?>
<section class="card">
  <h1>Arama Sonuçları</h1>
  <p style="color:var(--text-dim);">"<?= \Core\Helpers::e($query) ?>" için sonuçlar gösteriliyor.</p>
  <div class="grid grid-cols-4" style="margin-top:1.5rem;">
    <?php foreach ($products as $product): ?>
      <article class="product-card">
        <h3><?= \Core\Helpers::e($product['name']) ?></h3>
        <p style="color:var(--text-dim);"><?= \Core\Helpers::e(mb_strimwidth($product['description'], 0, 90, '...')) ?></p>
        <a class="btn-primary" href="<?= \Core\Helpers::baseUrl('urun/' . $product['slug']) ?>">İncele</a>
      </article>
    <?php endforeach; ?>
  </div>
  <?php if (empty($products)): ?>
    <p>Sonuç bulunamadı. Başka kelimeler deneyin.</p>
  <?php endif; ?>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
