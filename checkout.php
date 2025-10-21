<?php
$activePage = 'home';
include 'includes/site-header.php';
?>
<section class="account-page">
    <div class="account-card">
        <h1>Ödeme Bilgileri</h1>
        <form action="#" method="post" class="account-form">
            <div class="form-field">
                <label for="fullname">Ad Soyad</label>
                <input type="text" id="fullname" placeholder="Adınızı girin">
            </div>
            <div class="form-field">
                <label for="card">Kart Numarası</label>
                <input type="text" id="card" placeholder="0000 0000 0000 0000">
            </div>
            <div class="form-field">
                <label for="expiry">Son Kullanma Tarihi</label>
                <input type="text" id="expiry" placeholder="AA/YY">
            </div>
            <div class="form-field">
                <label for="cvc">CVC</label>
                <input type="text" id="cvc" placeholder="000">
            </div>
            <button class="button button--primary" type="submit">Ödemeyi Tamamla</button>
        </form>
    </div>
    <div class="product-panel">
        <h2>Sipariş Özeti</h2>
        <div class="panel__list">
            <span>PUBG Mobile 1800 UC</span>
            <span>Miktar: 1</span>
            <span>Toplam: 600 TL</span>
        </div>
        <div class="support-card">
            <span class="badge badge--success">Güvenli Ödeme</span>
            <p class="product-card__meta">3D Secure destekli ödeme sistemleri ile bilgileriniz güvende.</p>
        </div>
    </div>
</section>
<?php include 'includes/site-footer.php'; ?>
