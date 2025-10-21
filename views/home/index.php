<?php
$title = 'MaxiStore - Dijital Lisans ve E-PIN Mağazası';
ob_start();
?>
<section class="hero">
  <div class="hero-card">
    <span class="badge">Anında Teslimat</span>
    <h1>MaxiStore ile oyun ve yazılım keyfini anında başlat</h1>
    <p>Binlerce lisans, e-pin ve oyun içi para paketi tek çatı altında. Güvenli ödeme, anında teslimat ve 7/24 destek.</p>
    <a class="cta" href="#popular">Hemen keşfet</a>
  </div>
  <div class="hero-aside">
    <?php foreach ($banners as $banner): ?>
      <article class="card" style="background:linear-gradient(135deg, rgba(59,130,246,0.18), transparent), var(--surface);">
        <h3><?= \Core\Helpers::e($banner['title']) ?></h3>
        <p><?= \Core\Helpers::e($banner['url']) ?></p>
        <a class="btn-primary" href="<?= \Core\Helpers::e($banner['url']) ?>">Kampanyaya Git</a>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<section id="popular" style="margin-top:3rem;">
  <div class="card">
    <div class="card-title">
      <h2>Popüler Ürünler</h2>
      <a class="btn-muted" href="#">Tümünü gör</a>
    </div>
    <div class="grid grid-cols-4">
      <?php foreach ($popularProducts as $product): ?>
        <article class="product-card">
          <img data-lazy="<?= \Core\Helpers::asset('img/placeholder-product.svg') ?>" alt="<?= \Core\Helpers::e($product['name']) ?>" style="width:100%;border-radius:12px;background:rgba(255,255,255,0.02);height:140px;object-fit:cover;">
          <h3><?= \Core\Helpers::e($product['name']) ?></h3>
          <p style="color:var(--text-dim);"><?= \Core\Helpers::e(mb_strimwidth($product['description'], 0, 80, '...')) ?></p>
          <div class="product-meta">
            <span class="badge">Anında teslim</span>
            <span class="product-price"><?= \Core\Helpers::formatCurrency((float)($product['min_price'] ?? 0)) ?></span>
          </div>
          <a class="btn-primary" href="<?= \Core\Helpers::baseUrl('urun/' . $product['slug']) ?>">Hemen Al</a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section style="margin-top:3rem;">
  <div class="card">
    <div class="card-title">
      <h2>Popüler Kategoriler</h2>
      <a class="btn-muted" href="#">Tüm kategoriler</a>
    </div>
    <div class="grid grid-cols-4">
      <?php foreach ($categories as $category): ?>
        <article class="card" style="padding:1.2rem;background:linear-gradient(160deg, rgba(37,99,235,0.16), transparent), var(--surface);">
          <h3><?= \Core\Helpers::e($category['name']) ?></h3>
          <p style="color:var(--text-dim);">Sınırlı süreli fırsatlar sizi bekliyor.</p>
          <a class="btn-muted" href="<?= \Core\Helpers::baseUrl('kategori/' . $category['slug']) ?>">Keşfet</a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section style="margin-top:3rem;">
  <div class="card">
    <div class="card-title">
      <h2>Premium Yazılım Lisansları</h2>
      <span style="color:var(--text-dim);">Global anahtarlar, güvenli teslimat</span>
    </div>
    <div class="grid grid-cols-4">
      <?php foreach ($premiumProducts as $product): ?>
        <article class="product-card">
          <h3><?= \Core\Helpers::e($product['name']) ?></h3>
          <p style="color:var(--text-dim);">Kurumsal abonelik ve güvenli lisans yenileme desteği.</p>
          <div class="product-meta">
            <span class="badge badge-warning">%15 indirim</span>
            <span class="product-price"><?= \Core\Helpers::formatCurrency((float)($product['min_price'] ?? 0)) ?></span>
          </div>
          <a class="btn-primary" href="<?= \Core\Helpers::baseUrl('urun/' . $product['slug']) ?>">Satın Al</a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="advantages">
  <article class="card advantage-card">
    <h3>7/24 Canlı Destek</h3>
    <p>Uzman destek ekibimiz tüm sipariş süreçlerinde yanınızda.</p>
  </article>
  <article class="card advantage-card">
    <h3>Güvenli Ödeme</h3>
    <p>Iyzico, Papara ve Shopier entegrasyonlarına hazır mock altyapı.</p>
  </article>
  <article class="card advantage-card">
    <h3>Anında Teslim</h3>
    <p>Stok kodları otomatik olarak hesabınıza düşer ve e-posta ile gönderilir.</p>
  </article>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
