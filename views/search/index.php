<?php
$title = 'Arama Sonuçları - MaxiStore';
$breadcrumb = [
  ['label' => 'Ana Sayfa', 'url' => \Core\Helpers::baseUrl('/')],
  ['label' => 'Arama']
];
ob_start();
?>
<section class="panel">
  <header class="panel-header">
    <div>
      <h1>"<?= \Core\Helpers::e($query) ?>" sonuçları</h1>
      <p><?= count($products) ?> sonuç bulundu. Sonuçlar popülerlik ve stok durumuna göre listelenmiştir.</p>
    </div>
    <div class="chip-row">
      <span class="chip chip-muted">En Çok Satan</span>
      <span class="chip chip-muted">İndirimli</span>
      <span class="chip chip-muted">Yeni Gelen</span>
    </div>
  </header>
  <div class="product-grid">
    <?php foreach ($products as $product): ?>
      <article class="product-card">
        <div class="product-card-body">
          <h3><?= \Core\Helpers::e($product['name']) ?></h3>
          <p><?= \Core\Helpers::e(mb_strimwidth($product['description'], 0, 90, '...')) ?></p>
          <div class="product-meta">
            <span class="badge">Anında teslim</span>
            <span class="product-price"><?= \Core\Helpers::formatCurrency((float)($product['min_price'] ?? 0)) ?></span>
          </div>
        </div>
        <a class="btn-primary" href="<?= \Core\Helpers::baseUrl('urun/' . $product['slug']) ?>">İncele</a>
      </article>
    <?php endforeach; ?>
  </div>
  <?php if (empty($products)): ?>
    <p class="empty-state">Sonuç bulunamadı. Popüler aramalar: Valorant VP, Windows 11 Pro, Netflix Gift Card.</p>
  <?php endif; ?>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
