<?php
$title = $product['name'] . ' - MaxiStore';
$breadcrumb = [
  ['label' => 'Ana Sayfa', 'url' => \Core\Helpers::baseUrl('/')],
  ['label' => $product['category_name'] ?? 'Kategori', 'url' => \Core\Helpers::baseUrl('kategori/' . ($product['category_slug'] ?? ''))],
  ['label' => $product['name']]
];
ob_start();
?>
<section class="panel product-view">
  <div class="product-media">
    <img src="<?= \Core\Helpers::asset('svg/placeholder-product.svg') ?>" alt="<?= \Core\Helpers::e($product['name']) ?>" class="product-cover">
    <div class="product-insight">
      <span class="badge">Teslimat: <?= isset($product['delivery_type']) ? \Core\Helpers::e($product['delivery_type']) : 'Dijital Kod' ?></span>
      <span class="badge badge-warning">Stok: <?= (int)($product['stock'] ?? 0) ?>+</span>
    </div>
  </div>
  <div class="product-main">
    <h1><?= \Core\Helpers::e($product['name']) ?></h1>
    <p class="product-description"><?= nl2br(\Core\Helpers::e($product['description'])) ?></p>
    <?php if (!empty($variations)): ?>
      <div class="tabs" role="tablist">
        <?php foreach ($variations as $index => $variation): $tabId = 'variation-' . $variation['id']; ?>
          <button class="tab <?= $index === 0 ? 'active' : '' ?>" data-tab-group="variations" data-tab-target="<?= $tabId ?>" type="button">
            <?= \Core\Helpers::e($variation['title']) ?>
          </button>
        <?php endforeach; ?>
      </div>
      <?php foreach ($variations as $index => $variation): $tabId = 'variation-' . $variation['id']; ?>
        <section id="<?= $tabId ?>" data-tab-panel="variations" class="variation-panel" <?= $index !== 0 ? 'hidden' : '' ?>>
          <form action="<?= \Core\Helpers::baseUrl('cart/add') ?>" method="post" class="variation-form">
            <?= \Core\Helpers::csrfField() ?>
            <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
            <input type="hidden" name="variation_id" value="<?= (int)$variation['id'] ?>">
            <div class="variation-meta">
              <span class="product-price"><?= \Core\Helpers::formatCurrency((float)$variation['price']) ?></span>
              <?php if (!empty($variation['old_price'])): ?>
                <span class="old-price"><?= \Core\Helpers::formatCurrency((float)$variation['old_price']) ?></span>
              <?php endif; ?>
              <span class="badge">Stok: <?= (int)$variation['stock'] ?></span>
            </div>
            <label class="form-group" for="qty-<?= $variation['id'] ?>">
              <span>Adet</span>
              <input class="form-control" type="number" id="qty-<?= $variation['id'] ?>" name="qty" value="1" min="1">
            </label>
            <div class="variation-actions">
              <button class="btn-primary" type="submit">Sepete Ekle</button>
              <a class="btn-muted" href="<?= \Core\Helpers::baseUrl('support') ?>">Sipariş danışmanı</a>
            </div>
          </form>
        </section>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="empty-state">Bu ürün şu anda stokta bulunmuyor.</p>
    <?php endif; ?>
    <ul class="product-highlights">
      <li><span class="icon-pill"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-shield') ?>"></use></svg></span> FraudShield™ ile işlem güvenliği</li>
      <li><span class="icon-pill"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-mail') ?>"></use></svg></span> Lisans kasası + e-posta teslimatı</li>
      <li><span class="icon-pill"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-clock') ?>"></use></svg></span> Ortalama teslimat süresi: 30 sn</li>
    </ul>
  </div>
</section>

<section class="panel vendor-strip">
  <header class="panel-header">
    <div>
      <h2>Yetkili Satıcılar</h2>
      <p>Bu ürün için doğrulanan satıcılarımız.</p>
    </div>
  </header>
  <div class="vendor-grid">
    <?php foreach ($preferredVendors as $vendor): ?>
      <article class="vendor-card vendor-card--compact">
        <h3><?= \Core\Helpers::e($vendor['name']) ?></h3>
        <p><?= number_format((float)$vendor['rating'], 2) ?> puan • <?= (int)$vendor['sales_count'] ?> satış</p>
        <span class="badge">Operasyon onaylı</span>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<section class="panel operations">
  <header class="panel-header">
    <div>
      <h2>Teslimat Akışı</h2>
      <p>Siparişinizin MaxiStore altyapısında ilerleyişi.</p>
    </div>
  </header>
  <div class="timeline">
    <div class="timeline-step">
      <span class="icon-pill"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-lightning') ?>"></use></svg></span>
      <div>
        <strong>Ödeme Onayı</strong>
        <p>Mock driver saniyeler içinde onay verir ve işlem fraud filtresine düşer.</p>
      </div>
    </div>
    <div class="timeline-step">
      <span class="icon-pill"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-code') ?>"></use></svg></span>
      <div>
        <strong>Kod Ataması</strong>
        <p>StockItem kasasından talep edilen adet kadar kod çekilir ve şifrelenir.</p>
      </div>
    </div>
    <div class="timeline-step">
      <span class="icon-pill"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-mail') ?>"></use></svg></span>
      <div>
        <strong>Teslim</strong>
        <p>Lisans kasanızda görüntülenir ve e-posta yedeği gönderilir.</p>
      </div>
    </div>
  </div>
</section>

<?php if (!empty($relatedProducts)): ?>
<section class="panel">
  <header class="panel-header">
    <div>
      <h2>Benzer Ürünler</h2>
      <p>Kategoriye göre önerilen diğer ürünler.</p>
    </div>
  </header>
  <div class="product-grid">
    <?php foreach ($relatedProducts as $related): ?>
      <article class="product-card">
        <div class="product-card-body">
          <h3><?= \Core\Helpers::e($related['name']) ?></h3>
          <div class="product-meta">
            <span class="badge">Satıcı Puanı 4.8</span>
            <span class="product-price"><?= \Core\Helpers::formatCurrency((float)($related['min_price'] ?? 0)) ?></span>
          </div>
        </div>
        <a class="btn-primary" href="<?= \Core\Helpers::baseUrl('urun/' . $related['slug']) ?>">İncele</a>
      </article>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
