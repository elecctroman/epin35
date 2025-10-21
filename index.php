<?php
$activePage = 'home';
include 'includes/site-header.php';
?>
<section class="hero">
    <div>
        <span class="hero__badge">Dijital Ürünlerde %100 Güven</span>
        <h1 class="hero__title">Oyun Para Birimleri &amp; Lisanslarda Anında Teslimat</h1>
        <p class="hero__text">MaxiStore ile PUBG Mobile UC, Valorant VP, Steam cüzdan kodları ve onlarca premium yazılım aboneliğini saniyeler içinde satın alın.</p>
        <div class="hero__cta">
            <a href="#featured" class="button button--primary">Popüler Ürünleri Gör</a>
            <a href="support.php" class="button button--ghost">Canlı Destek</a>
        </div>
    </div>
    <div class="hero__visual">
        <div class="product-card hero-card">
            <div class="product-card__image">
                <img src="https://images.unsplash.com/photo-1618005198919-d3d4b5a92eee?auto=format&fit=crop&w=600&q=80" alt="PUBG Mobile" />
            </div>
            <span class="badge product-card__badge">En Popüler</span>
            <div>
                <h3 class="product-card__title">PUBG Mobile 1800 UC</h3>
                <p class="product-card__meta">Anında teslim • Kod ile teslimat</p>
            </div>
            <div class="product-card__price">600 TL</div>
            <a href="product.php" class="product-card__button">Hemen Satın Al</a>
        </div>
    </div>
</section>
<section id="featured">
    <div class="section-title">
        <h2>Popüler Kategoriler</h2>
        <a href="#">Tümü</a>
    </div>
    <div class="product-grid">
        <?php
        $featured = [
            ['title' => 'PUBG Mobile 60 UC', 'price' => '60 TL'],
            ['title' => 'PUBG Mobile 325 UC', 'price' => '300 TL'],
            ['title' => 'PUBG Mobile 1800 UC', 'price' => '600 TL'],
            ['title' => 'PUBG Mobile 3850 UC', 'price' => '1.150 TL'],
            ['title' => 'Valorant 1.150 VP', 'price' => '320 TL'],
            ['title' => 'Valorant 1.900 VP', 'price' => '490 TL'],
            ['title' => 'Steam Cüzdan 250 TL', 'price' => '250 TL'],
            ['title' => 'Riot Gift Card 650 TL', 'price' => '650 TL'],
        ];
        foreach ($featured as $item): ?>
        <article class="product-card">
            <div class="product-card__image">
                <img src="https://images.unsplash.com/photo-1585079542156-2755d9c8a094?auto=format&fit=crop&w=600&q=80" alt="<?= $item['title']; ?>">
            </div>
            <h3 class="product-card__title"><?= $item['title']; ?></h3>
            <p class="product-card__meta">MaxiStore Garantisi • 5 Dakika Teslimat</p>
            <div class="product-card__price"><?= $item['price']; ?></div>
            <a href="product.php" class="product-card__button">Satın Al</a>
        </article>
        <?php endforeach; ?>
    </div>
</section>
<section>
    <div class="section-title">
        <h2>Premium Yazılım Lisansları</h2>
        <a href="#">Tüm Yazılımlar</a>
    </div>
    <div class="product-grid">
        <?php
        $software = [
            ['title' => 'Adobe Creative Cloud 1 Ay', 'price' => '299 TL'],
            ['title' => 'Microsoft Office 365 1 Yıl', 'price' => '449 TL'],
            ['title' => 'Canva Pro 1 Yıl', 'price' => '379 TL'],
            ['title' => 'Elementor Pro 1 Yıl', 'price' => '259 TL'],
        ];
        foreach ($software as $item): ?>
        <article class="product-card">
            <div class="product-card__image">
                <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80" alt="<?= $item['title']; ?>">
            </div>
            <h3 class="product-card__title"><?= $item['title']; ?></h3>
            <p class="product-card__meta">Global lisans • 7/24 destek</p>
            <div class="product-card__price"><?= $item['price']; ?></div>
            <a href="product.php" class="product-card__button">Hemen Al</a>
        </article>
        <?php endforeach; ?>
    </div>
</section>
<section>
    <div class="section-title">
        <h2>MaxiStore Avantajları</h2>
    </div>
    <div class="product-grid">
        <article class="product-card">
            <h3 class="product-card__title">Anında Teslimat</h3>
            <p class="product-card__meta">Ödeme onayınızdan sonra otomatik olarak ürün teslim edilir.</p>
        </article>
        <article class="product-card">
            <h3 class="product-card__title">Maxi Güvence</h3>
            <p class="product-card__meta">Tüm ürünlerimiz MaxiStore güvencesiyle korunur.</p>
        </article>
        <article class="product-card">
            <h3 class="product-card__title">7/24 Destek</h3>
            <p class="product-card__meta">Canlı destek ekibimiz her zaman hazır.</p>
        </article>
    </div>
</section>
<?php include 'includes/site-footer.php'; ?>
