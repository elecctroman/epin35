<?php
$activePage = 'account';
include 'includes/site-header.php';
?>
<section class="account-page">
    <div class="account-card">
        <h1>Hesabım</h1>
        <p class="product-card__meta">Bilgilerinizi güncelleyin, siparişlerinizi takip edin.</p>
        <form action="#" method="post" class="account-form">
            <div class="form-field">
                <label for="name">Ad Soyad</label>
                <input type="text" id="name" value="Demo Kullanıcı">
            </div>
            <div class="form-field">
                <label for="email">E-posta</label>
                <input type="email" id="email" value="demo@maxistore.com">
            </div>
            <div class="form-field">
                <label for="phone">Telefon</label>
                <input type="tel" id="phone" value="0 (552) 555 00 55">
            </div>
            <div class="form-field">
                <label for="password">Şifre</label>
                <input type="password" id="password" value="********">
            </div>
            <button class="button button--primary" type="submit">Bilgilerimi Güncelle</button>
        </form>
    </div>
    <div class="account-card">
        <h2>Son Siparişlerim</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Ürün</th>
                    <th>Tarih</th>
                    <th>Durum</th>
                    <th>Tutar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>PUBG Mobile 1800 UC</td>
                    <td>02.11.2025</td>
                    <td><span class="badge badge--success">Teslim edildi</span></td>
                    <td>600 TL</td>
                </tr>
                <tr>
                    <td>Valorant 1.900 VP</td>
                    <td>28.10.2025</td>
                    <td><span class="badge badge--warning">İşleniyor</span></td>
                    <td>490 TL</td>
                </tr>
                <tr>
                    <td>Adobe Creative Cloud</td>
                    <td>15.10.2025</td>
                    <td><span class="badge badge--danger">İade sürecinde</span></td>
                    <td>299 TL</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
<?php include 'includes/site-footer.php'; ?>
