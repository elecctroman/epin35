<?php
$title = 'Sepetiniz - MaxiStore';
$breadcrumb = [
  ['label' => 'Ana Sayfa', 'url' => \Core\Helpers::baseUrl('/')],
  ['label' => 'Sepet']
];
ob_start();
$total = array_sum(array_map(fn($item) => $item['qty'] * $item['unit_price'], $items));
?>
<section class="panel cart-view">
  <header class="panel-header">
    <div>
      <h1>Sepetiniz</h1>
      <p>Ödemeye geçmeden önce ürünlerinizi ve stok bilgilerini kontrol edin.</p>
    </div>
    <a class="btn-muted" href="<?= \Core\Helpers::baseUrl('/') ?>">Alışverişe Devam Et</a>
  </header>
  <?php if (empty($items)): ?>
    <p class="empty-state">Sepetinizde ürün yok. Kampanyalı ürünleri keşfetmek için ana sayfaya dönebilirsiniz.</p>
  <?php else: ?>
    <div class="cart-grid">
      <div class="cart-items">
        <table class="table" aria-describedby="cart-summary">
          <thead>
            <tr>
              <th>Ürün</th>
              <th>Varyant</th>
              <th>Adet</th>
              <th>Birim</th>
              <th>Toplam</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($items as $item): ?>
              <tr>
                <td><a href="<?= \Core\Helpers::baseUrl('urun/' . $item['product_slug']) ?>"><?= \Core\Helpers::e($item['product_name']) ?></a></td>
                <td><?= \Core\Helpers::e($item['variation_title']) ?></td>
                <td><?= (int)$item['qty'] ?></td>
                <td><?= \Core\Helpers::formatCurrency((float)$item['unit_price']) ?></td>
                <td><?= \Core\Helpers::formatCurrency((float)$item['unit_price'] * $item['qty']) ?></td>
                <td>
                  <form action="<?= \Core\Helpers::baseUrl('cart/remove/' . $item['id']) ?>" method="post">
                    <?= \Core\Helpers::csrfField() ?>
                    <button class="btn-muted" type="submit">Kaldır</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <aside class="cart-summary" id="cart-summary">
        <h2>Sipariş Özeti</h2>
        <dl>
          <div>
            <dt>Ürün Toplamı</dt>
            <dd><?= \Core\Helpers::formatCurrency((float)$total) ?></dd>
          </div>
          <div>
            <dt>Teslimat Ücreti</dt>
            <dd>Ücretsiz (Dijital)</dd>
          </div>
          <div>
            <dt>Mock Ödeme</dt>
            <dd>Iyzico / Papara / Shopier</dd>
          </div>
        </dl>
        <div class="cart-total">
          <span>Genel Toplam</span>
          <strong><?= \Core\Helpers::formatCurrency((float)$total) ?></strong>
        </div>
        <a class="btn-primary" href="<?= \Core\Helpers::baseUrl('checkout') ?>">Ödemeye Geç</a>
        <p class="cart-note">Mock ödemeleriniz saniyeler içinde onaylanır. FraudShield kontrolü otomatik uygulanır.</p>
      </aside>
    </div>
  <?php endif; ?>
</section>

<section class="panel" aria-label="Önerilen ürünler">
  <header class="panel-header">
    <div>
      <h2>Sepetinize Ekleyebileceğiniz Ürünler</h2>
      <p>Benzer müşterilerin tercih ettiği popüler ürünler.</p>
    </div>
  </header>
  <div class="product-grid">
    <?php foreach ($recommendations as $product): ?>
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
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
