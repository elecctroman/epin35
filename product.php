<?php
$activePage = 'home';
include 'includes/site-header.php';
?>
<section class="product-detail">
    <div>
        <img src="https://images.unsplash.com/photo-1618005198919-d3d4b5a92eee?auto=format&fit=crop&w=900&q=80" alt="PUBG Mobile 1800 UC" class="product-visual">
        <div class="tabs">
            <button class="tab is-active" data-tab="info">Ürün Bilgisi</button>
            <button class="tab" data-tab="reviews">Yorumlar</button>
            <button class="tab" data-tab="faq">Sık Sorulanlar</button>
        </div>
        <section class="panel" data-tab-panel="info">
            <h2 class="panel__title">PUBG Mobile 1800 UC Hakkında</h2>
            <ul class="panel__list">
                <li>Satış yöntemi: Kod ile anında teslim</li>
                <li>Bölge: Global • Tüm sunucular</li>
                <li>Garanti: 30 gün MaxiStore koruması</li>
                <li>Ek not: Kodlar sadece resmi mağazada kullanılabilir.</li>
            </ul>
        </section>
        <section class="panel" data-tab-panel="reviews" hidden>
            <h2 class="panel__title">Müşteri Yorumları</h2>
            <p class="product-card__meta">Henüz yorum yapılmadı. İlk yorumu sen yaz!</p>
        </section>
        <section class="panel" data-tab-panel="faq" hidden>
            <h2 class="panel__title">Sık Sorulan Sorular</h2>
            <ul class="panel__list">
                <li>Kodlar ne kadar sürede teslim edilir? — Ödeme sonrası 60 saniye içinde.</li>
                <li>İade koşulları neler? — Kullanılmamış kodlar 14 gün içinde iade edilebilir.</li>
            </ul>
        </section>
    </div>
    <aside>
        <div class="product-panel">
            <div class="product-panel__header">
                <div>
                    <h1>PUBG Mobile 1800 UC</h1>
                    <p class="product-card__meta">Global Kod • Resmi Mağaza</p>
                </div>
                <span class="badge badge--success">Stokta</span>
            </div>
            <div>
                <p class="product-card__meta">Anında teslimat • MaxiStore güvencesi</p>
                <div class="product-panel__price">600 TL</div>
            </div>
            <a href="checkout.php" class="product-panel__button">Satın Al ve Anında Teslim Al</a>
            <div class="product-panel__list">
                <article class="offer-card">
                    <div>
                        <div class="offer-card__seller">MaxiStore</div>
                        <div class="offer-card__badge">%98 Memnuniyet</div>
                    </div>
                    <div class="offer-card__price">600 TL</div>
                    <a href="checkout.php" class="offer-card__action">Satın Al</a>
                </article>
                <article class="offer-card">
                    <div>
                        <div class="offer-card__seller">HızlıSatıcı</div>
                        <div class="offer-card__badge">10.540 satış</div>
                    </div>
                    <div class="offer-card__price">605 TL</div>
                    <a href="#" class="offer-card__action">Sepete Ekle</a>
                </article>
            </div>
        </div>
    </aside>
</section>
<?php include 'includes/site-footer.php'; ?>
