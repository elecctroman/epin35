<?php
$activePage = 'home';
$query = $_GET['q'] ?? '';
include 'includes/site-header.php';
?>
<section>
    <div class="section-title">
        <h2>"<?= htmlspecialchars($query); ?>" için sonuçlar</h2>
        <span class="product-card__meta">Toplam 6 sonuç</span>
    </div>
    <div class="product-grid">
        <?php
        $results = [
            ['title' => 'PUBG Mobile 60 UC', 'price' => '60 TL'],
            ['title' => 'PUBG Mobile 325 UC', 'price' => '300 TL'],
            ['title' => 'PUBG Mobile 1800 UC', 'price' => '600 TL'],
            ['title' => 'PUBG Mobile 3850 UC', 'price' => '1.150 TL'],
            ['title' => 'PUBG Mobile 8100 UC', 'price' => '2.200 TL'],
            ['title' => 'PUBG Mobile Royal Pass', 'price' => '120 TL'],
        ];
        foreach ($results as $item): ?>
        <article class="product-card">
            <div class="product-card__image">
                <img src="https://images.unsplash.com/photo-1545239351-1141bd82e8a6?auto=format&fit=crop&w=600&q=80" alt="<?= $item['title']; ?>">
            </div>
            <h3 class="product-card__title"><?= $item['title']; ?></h3>
            <p class="product-card__meta">MaxiStore güvencesi • 4.9 / 5</p>
            <div class="product-card__price"><?= $item['price']; ?></div>
            <a href="product.php" class="product-card__button">Satın Al</a>
        </article>
        <?php endforeach; ?>
    </div>
</section>
<?php include 'includes/site-footer.php'; ?>
