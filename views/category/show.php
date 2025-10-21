<?php
$title = $category['name'] . ' - MaxiStore';
$breadcrumb = [
  ['label' => 'Ana Sayfa', 'url' => \Core\Helpers::baseUrl('/')],
  ['label' => $category['name']]
];
ob_start();
?>
<section class="card">
  <h1><?= \Core\Helpers::e($category['name']) ?></h1>
  <p style="color:var(--text-dim);"><?= count($products) ?> sonuç bulundu. En güncel stoklar aşağıda listelenir.</p>
  <div class="grid grid-cols-4" style="margin-top:1.5rem;">
    <?php foreach ($products as $product): ?>
      <article class="product-card">
        <h3><?= \Core\Helpers::e($product['name']) ?></h3>
        <p style="color:var(--text-dim);">Dijital teslimat, güvenli ödeme.</p>
        <div class="product-meta">
          <span class="badge">Anında teslim</span>
          <span class="product-price"><?= \Core\Helpers::formatCurrency((float)($product['min_price'] ?? 0)) ?></span>
        </div>
        <a class="btn-primary" href="<?= \Core\Helpers::baseUrl('urun/' . $product['slug']) ?>">İncele</a>
      </article>
    <?php endforeach; ?>
  </div>
  <?php if (empty($products)): ?>
    <p>Bu kategoride ürün bulunamadı.</p>
  <?php endif; ?>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
