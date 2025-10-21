<?php
$activePage = 'home';
include 'includes/site-header.php';
?>
<section>
    <div class="section-title">
        <h1>Sepetim</h1>
        <p class="product-card__meta">Ödeme adımına geçmeden önce siparişinizi kontrol edin.</p>
    </div>
    <div class="dashboard-grid">
        <div class="account-card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Ürün</th>
                        <th>Adet</th>
                        <th>Birim Fiyat</th>
                        <th>Toplam</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>PUBG Mobile 1800 UC</td>
                        <td>1</td>
                        <td>600 TL</td>
                        <td>600 TL</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="product-panel">
            <h2>Ödeme Özeti</h2>
            <div class="panel__list">
                <span>Ara Toplam: 600 TL</span>
                <span>Hizmet Bedeli: 0 TL</span>
                <span>Toplam: 600 TL</span>
            </div>
            <a href="checkout.php" class="product-panel__button">Ödemeye Geç</a>
        </div>
    </div>
</section>
<?php include 'includes/site-footer.php'; ?>
