<?php
$title = 'MaxiStore - Dijital Lisans ve E-PIN Mağazası';
ob_start();
?>
<section class="hero hero-grid">
  <div class="hero-card hero-main">
    <span class="badge">Anında Teslimat</span>
    <h1>MaxiStore ile oyun kodu, lisans ve hesap teslimatında pro seviye deneyim</h1>
    <p>7/24 fraud koruması, otomatik stok dağıtımı ve güvenilir satıcı ağı ile dijital alışverişinizi saniyeler içinde tamamlayın.</p>
    <div class="hero-actions">
      <a class="cta" href="#popular">Kampanyalara Git</a>
      <a class="btn-outline" href="<?= \Core\Helpers::baseUrl('support') ?>">Canlı destek</a>
    </div>
    <div class="hero-metrics">
      <div>
        <small>Bugünkü Ciro</small>
        <strong><?= \Core\Helpers::formatCurrency((float)($storeMetrics['today_sales'] ?? 0)) ?></strong>
        <span>%98 anında teslim</span>
      </div>
      <div>
        <small>Aktif Ürün</small>
        <strong><?= (int)($storeMetrics['active_products'] ?? 0) ?></strong>
        <span>Yeni eklenen katalog</span>
      </div>
      <div>
        <small>Bekleyen Sipariş</small>
        <strong><?= (int)($storeMetrics['pending_orders'] ?? 0) ?></strong>
        <span>Operasyon kontrolünde</span>
      </div>
    </div>
    <div class="chart chart-mini" data-chart='<?= json_encode($revenueSparkline, JSON_UNESCAPED_UNICODE) ?>'></div>
  </div>
  <div class="hero-side">
    <div class="hero-ticker" data-marquee>
      <span>Yeni</span>
      <span>Valorant VP kampanyası başladı</span>
      <span>Kurumsal lisans teklifleri için sales@maxistore.com</span>
      <span>Shopier mock ödemeleri 3 dakikada onaylanır</span>
    </div>
    <?php foreach ($banners as $banner): ?>
      <article class="card hero-banner">
        <h3><?= \Core\Helpers::e($banner['title']) ?></h3>
        <p><?= \Core\Helpers::e('Kampanya Linki: ' . $banner['url']) ?></p>
        <a class="btn-primary" href="<?= \Core\Helpers::e($banner['url']) ?>">Kampanyayı Gör</a>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<section class="panel" id="popular">
  <header class="panel-header">
    <div>
      <h2>Popüler Ürünler</h2>
      <p>En çok satan paketler ve lisanslar bu hafta %12'ye varan indirimle.</p>
    </div>
    <div class="panel-actions">
      <button class="chip" type="button" data-scroll-target="premium">Premium Lisanslar</button>
      <button class="chip" type="button" data-scroll-target="operations">Operasyon Süreci</button>
    </div>
  </header>
  <div class="product-grid">
    <?php foreach ($popularProducts as $product): ?>
      <article class="product-card product-card--featured">
        <img data-lazy="<?= \Core\Helpers::asset('img/placeholder-product.svg') ?>" alt="<?= \Core\Helpers::e($product['name']) ?>">
        <div class="product-card-body">
          <h3><?= \Core\Helpers::e($product['name']) ?></h3>
          <p><?= \Core\Helpers::e(mb_strimwidth($product['description'], 0, 90, '...')) ?></p>
          <div class="product-meta">
            <span class="badge">Anında teslim</span>
            <span class="product-price"><?= \Core\Helpers::formatCurrency((float)($product['min_price'] ?? 0)) ?></span>
          </div>
        </div>
        <a class="btn-primary" href="<?= \Core\Helpers::baseUrl('urun/' . $product['slug']) ?>">Hemen Al</a>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<section class="panel panel-split" id="categories">
  <div>
    <h2>Popüler Kategoriler</h2>
    <p>Oyun paraları, yazılım lisansları ve hesap satışlarında yüksek stok.</p>
    <div class="category-pills">
      <?php foreach ($categories as $category): ?>
        <a class="category-pill" href="<?= \Core\Helpers::baseUrl('kategori/' . $category['slug']) ?>">
          <span class="icon-pill"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-controller') ?>"></use></svg></span>
          <div>
            <strong><?= \Core\Helpers::e($category['name']) ?></strong>
            <small>Özel fiyatlar &amp; anlık stok</small>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
  <aside class="panel-highlight">
    <h3>7/24 Maxi Güven</h3>
    <ul>
      <li>Gerçek zamanlı kod doğrulama</li>
      <li>FraudShield™ risk motoru</li>
      <li>Her siparişte otomatik yedek mail</li>
    </ul>
  </aside>
</section>

<section class="panel" id="premium">
  <header class="panel-header">
    <div>
      <h2>Premium Yazılım Lisansları</h2>
      <p>Kurumsal ekipler için sertifikalı global lisans dağıtımı.</p>
    </div>
    <a class="btn-muted" href="#">Teklif al</a>
  </header>
  <div class="product-grid">
    <?php foreach ($premiumProducts as $product): ?>
      <article class="product-card">
        <div class="product-card-body">
          <h3><?= \Core\Helpers::e($product['name']) ?></h3>
          <p>Kurumsal abonelik ve güvenli lisans yenileme desteği.</p>
          <div class="product-meta">
            <span class="badge badge-warning">%15 indirim</span>
            <span class="product-price"><?= \Core\Helpers::formatCurrency((float)($product['min_price'] ?? 0)) ?></span>
          </div>
        </div>
        <a class="btn-primary" href="<?= \Core\Helpers::baseUrl('urun/' . $product['slug']) ?>">Satın Al</a>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<section class="panel vendor-strip">
  <header class="panel-header">
    <div>
      <h2>Yetkili Satıcı Ağı</h2>
      <p>Performansı doğrulanan satıcılarımızla pro seviye teslimat.</p>
    </div>
  </header>
  <div class="vendor-grid">
    <?php foreach ($vendors as $vendor): ?>
      <article class="vendor-card">
        <h3><?= \Core\Helpers::e($vendor['name']) ?></h3>
        <p><?= number_format((float)$vendor['rating'], 2) ?> puan • <?= (int)$vendor['sales_count'] ?> satış</p>
        <span class="badge">Satıcı doğrulandı</span>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<section class="panel operations" id="operations">
  <header class="panel-header">
    <div>
      <h2>MaxiStore Operasyon Süreci</h2>
      <p>Siparişiniz saniyeler içinde kontrol edilir, onaylanır ve teslim edilir.</p>
    </div>
  </header>
  <div class="timeline">
    <div class="timeline-step">
      <span class="icon-pill"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-shield') ?>"></use></svg></span>
      <div>
        <strong>Fraud Analizi</strong>
        <p>Ödeme mock servislerinden gelen referans saniyeler içinde doğrulanır.</p>
      </div>
    </div>
    <div class="timeline-step">
      <span class="icon-pill"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-code') ?>"></use></svg></span>
      <div>
        <strong>Stok Dağıtımı</strong>
        <p>Şifreler, StockItem kasasından kilitli olarak çekilir ve siparişe işlenir.</p>
      </div>
    </div>
    <div class="timeline-step">
      <span class="icon-pill"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-mail') ?>"></use></svg></span>
      <div>
        <strong>Çok Kanallı Teslimat</strong>
        <p>Hesabım &gt; Lisans Kasası ve e-posta ile aynı anda teslimat yapılır.</p>
      </div>
    </div>
    <div class="timeline-step">
      <span class="icon-pill"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-support') ?>"></use></svg></span>
      <div>
        <strong>Destek &amp; SLA</strong>
        <p>Talep oluşturduğunuzda ortalama ilk yanıt süresi 10 dakika.</p>
      </div>
    </div>
  </div>
</section>

<section class="panel faq">
  <header class="panel-header">
    <div>
      <h2>Merak Ettikleriniz</h2>
      <p>Mağaza deneyiminizi kusursuz hale getirmek için sık sorulan sorular.</p>
    </div>
  </header>
  <div class="accordion" data-accordion>
    <?php $faqs = [
      ['q' => 'Kodlar ne kadar sürede teslim edilir?', 'a' => 'Ödeme onayı alındıktan sonra 30 saniye içinde kodlar hesabınızda görünür. Ayrı bir e-posta da gönderilir.'],
      ['q' => 'Hangi ödeme yöntemlerini destekliyorsunuz?', 'a' => 'Manual mock, Iyzico mock, Papara mock ve Shopier mock driverları sorunsuz çalışır. Gerçek entegrasyonlar için hazır altyapı sunarız.'],
      ['q' => 'İade politikası nedir?', 'a' => 'Kullanılmamış kodlar için 14 gün içinde iade talebi oluşturabilirsiniz. Kodlar tüketilmediyse iade anında onaylanır.'],
    ]; ?>
    <?php foreach ($faqs as $index => $faq): $id = 'faq-' . $index; ?>
      <div class="accordion-item">
        <button class="accordion-trigger" type="button" data-accordion-toggle aria-controls="<?= $id ?>">
          <span><?= \Core\Helpers::e($faq['q']) ?></span>
          <svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-chevron') ?>"></use></svg>
        </button>
        <div class="accordion-panel" id="<?= $id ?>" hidden>
          <p><?= \Core\Helpers::e($faq['a']) ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="panel cta">
  <div class="cta-inner">
    <div>
      <h2>Toplu lisans ihtiyacınız mı var?</h2>
      <p>Kurumsal MaxiStore çözüm uzmanları ile hemen görüşün. Anında teklif ve özel dashboard erişimi sağlayın.</p>
    </div>
    <a class="btn-primary" href="mailto:sales@maxistore.com">Satış ekibine yaz</a>
  </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
