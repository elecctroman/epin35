<?php
$title = $category['name'] . ' - MaxiStore';
$breadcrumb = [
  ['label' => 'Ana Sayfa', 'url' => \Core\Helpers::baseUrl('/')],
  ['label' => $category['name']]
];
$filterSuggestions = ['Anında Teslim', 'Stokta Var', 'İndirimli', 'Yeni Satıcı'];
ob_start();
?>
<section class="panel">
  <header class="panel-header">
    <div>
      <h1><?= \Core\Helpers::e($category['name']) ?></h1>
      <p><?= count($products) ?> sonuç bulundu. Filtreleri kullanarak aradığınız dijital ürünü saniyeler içinde bulun.</p>
    </div>
    <div class="chip-row">
      <?php foreach ($filterSuggestions as $filter): ?>
        <span class="chip chip-muted"><?= \Core\Helpers::e($filter) ?></span>
      <?php endforeach; ?>
    </div>
  </header>
  <div class="category-toolbar">
    <form class="category-search" action="<?= \Core\Helpers::baseUrl('search') ?>" method="get">
      <input type="hidden" name="category" value="<?= (int)$category['id'] ?>">
      <input type="search" name="q" placeholder="Ürün adı veya satıcı" aria-label="Kategori içinde ara">
      <button type="submit">Ara</button>
    </form>
    <div class="view-switcher">
      <span>Liste Görünümü</span>
      <span class="switch" role="presentation"></span>
      <span>Grid</span>
    </div>
  </div>
  <div class="product-grid">
    <?php foreach ($products as $product): ?>
      <article class="product-card">
        <div class="product-card-body">
          <h3><?= \Core\Helpers::e($product['name']) ?></h3>
          <p>Dijital teslimat, güvenli ödeme ve otomatik lisans kasası entegrasyonu.</p>
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
    <p class="empty-state">Bu kategoride şu an stok yok. Destek ekibimizle iletişime geçerek yeni stok talep edebilirsiniz.</p>
  <?php endif; ?>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
