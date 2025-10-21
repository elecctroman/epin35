<?php
$title = $product['name'] . ' - MaxiStore';
$breadcrumb = [
  ['label' => 'Ana Sayfa', 'url' => \Core\Helpers::baseUrl('/')],
  ['label' => $product['category_name'] ?? 'Kategori', 'url' => \Core\Helpers::baseUrl('kategori/' . ($product['category_slug'] ?? ''))],
  ['label' => $product['name']]
];
ob_start();
?>
<article class="card" style="display:grid;gap:2rem;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));">
  <div>
    <img src="<?= \Core\Helpers::asset('svg/placeholder-product.svg') ?>" alt="<?= \Core\Helpers::e($product['name']) ?>" style="width:100%;border-radius:18px;box-shadow:var(--shadow-soft);">
  </div>
  <div>
    <h1><?= \Core\Helpers::e($product['name']) ?></h1>
    <p style="color:var(--text-dim);line-height:1.7;"><?= nl2br(\Core\Helpers::e($product['description'])) ?></p>
    <div class="badge">Teslimat: <?= isset($product['delivery_type']) ? \Core\Helpers::e($product['delivery_type']) : 'Dijital Kod' ?></div>
    <?php if (!empty($variations)): ?>
      <div class="tabs" role="tablist">
        <?php foreach ($variations as $index => $variation): $tabId = 'variation-' . $variation['id']; ?>
          <button class="tab <?= $index === 0 ? 'active' : '' ?>" data-tab-group="variations" data-tab-target="<?= $tabId ?>" type="button">
            <?= \Core\Helpers::e($variation['title']) ?>
          </button>
        <?php endforeach; ?>
      </div>
      <?php foreach ($variations as $index => $variation): $tabId = 'variation-' . $variation['id']; ?>
        <section id="<?= $tabId ?>" data-tab-panel="variations" <?= $index !== 0 ? 'hidden' : '' ?>>
          <form action="<?= \Core\Helpers::baseUrl('cart/add') ?>" method="post">
            <?= \Core\Helpers::csrfField() ?>
            <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
            <input type="hidden" name="variation_id" value="<?= (int)$variation['id'] ?>">
            <div class="form-group">
              <label for="qty">Adet</label>
              <input class="form-control" type="number" id="qty" name="qty" value="1" min="1">
            </div>
            <div class="product-meta" style="margin-bottom:1rem;">
              <span class="product-price">₺<?= number_format($variation['price'], 2) ?></span>
              <?php if (!empty($variation['old_price'])): ?>
                <span style="color:var(--text-dim);text-decoration:line-through;">₺<?= number_format($variation['old_price'], 2) ?></span>
              <?php endif; ?>
              <span>Stok: <?= (int)$variation['stock'] ?></span>
            </div>
            <button class="btn-primary" type="submit">Sepete Ekle</button>
          </form>
        </section>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="alert alert-info">Bu ürün şu anda stokta bulunmuyor.</p>
    <?php endif; ?>
  </div>
</article>

<?php if (!empty($variations)): ?>
<section style="margin-top:3rem;">
  <div class="card">
    <h2>Benzer Ürünler</h2>
    <div class="grid grid-cols-4" style="margin-top:1.5rem;">
      <?php foreach (array_slice($variations, 0, 4) as $variation): ?>
        <article class="product-card">
          <h3><?= \Core\Helpers::e($product['name']) ?> - <?= \Core\Helpers::e($variation['title']) ?></h3>
          <div class="product-meta">
            <span class="badge">Satıcı Puanı 4.8</span>
            <span class="product-price">₺<?= number_format($variation['price'], 2) ?></span>
          </div>
          <a class="btn-primary" href="<?= \Core\Helpers::baseUrl('urun/' . $product['slug']) ?>">İncele</a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
