<?php
$activePage = 'admin';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaxiStore Yönetim Paneli</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body class="admin-body">
    <aside class="admin-sidebar">
        <div class="admin-brand">
            <img src="../assets/brand/logo.svg" alt="MaxiStore" />
            <span>MaxiStore Admin</span>
        </div>
        <nav class="admin-nav">
            <a href="#" class="admin-nav__link is-active">Gösterge Paneli</a>
            <a href="#" class="admin-nav__link">Siparişler</a>
            <a href="#" class="admin-nav__link">Ürünler</a>
            <a href="#" class="admin-nav__link">Kampanyalar</a>
            <a href="#" class="admin-nav__link">Destek Talepleri</a>
            <a href="#" class="admin-nav__link">Ayarlar</a>
        </nav>
    </aside>
    <main class="admin-main">
        <header class="admin-header">
            <h1>Gösterge Paneli</h1>
            <div class="admin-header__actions">
                <button class="button button--ghost">Önizleme</button>
                <button class="button button--primary">Yeni Ürün</button>
            </div>
        </header>
        <section class="stat-grid">
            <article class="stat-card">
                <span class="stat-card__label">Bugünkü Ciro</span>
                <span class="stat-card__value">₺18.540</span>
                <span class="product-card__meta">Dün: ₺16.200</span>
            </article>
            <article class="stat-card">
                <span class="stat-card__label">Aktif Sipariş</span>
                <span class="stat-card__value">126</span>
                <span class="product-card__meta">Son 24 saat</span>
            </article>
            <article class="stat-card">
                <span class="stat-card__label">Yeni Kullanıcı</span>
                <span class="stat-card__value">284</span>
                <span class="product-card__meta">%8 artış</span>
            </article>
            <article class="stat-card">
                <span class="stat-card__label">Çözülmemiş Destek</span>
                <span class="stat-card__value">12</span>
                <span class="product-card__meta">3 kritik</span>
            </article>
        </section>
        <section class="dashboard-panels">
            <article class="account-card">
                <h2>12 Aylık Trend</h2>
                <img src="https://images.unsplash.com/photo-1556740749-887f6717d7e4?auto=format&fit=crop&w=900&q=80" alt="Trend Grafik">
            </article>
            <article class="account-card">
                <h2>Anlık Satışlar</h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <span class="timeline-item__title">PUBG Mobile 1800 UC</span>
                        <span class="product-card__meta">2 dakika önce • ₺600</span>
                    </div>
                    <div class="timeline-item">
                        <span class="timeline-item__title">Valorant 1.900 VP</span>
                        <span class="product-card__meta">5 dakika önce • ₺490</span>
                    </div>
                    <div class="timeline-item">
                        <span class="timeline-item__title">Adobe Creative Cloud</span>
                        <span class="product-card__meta">12 dakika önce • ₺299</span>
                    </div>
                </div>
            </article>
        </section>
        <section class="dashboard-panels">
            <article class="account-card">
                <h2>Stok Durumu</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ürün</th>
                            <th>Stok</th>
                            <th>Durum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>PUBG Mobile 60 UC</td>
                            <td>560</td>
                            <td><span class="badge badge--success">Sağlıklı</span></td>
                        </tr>
                        <tr>
                            <td>Valorant 1.150 VP</td>
                            <td>120</td>
                            <td><span class="badge badge--warning">Düşük</span></td>
                        </tr>
                        <tr>
                            <td>Netflix Premium</td>
                            <td>35</td>
                            <td><span class="badge badge--danger">Kritik</span></td>
                        </tr>
                    </tbody>
                </table>
            </article>
            <article class="account-card">
                <h2>Son Destek Talepleri</h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <span class="timeline-item__title">#5241 - Kod teslim edilmedi</span>
                        <span class="product-card__meta">Kritik • 2 dk önce</span>
                    </div>
                    <div class="timeline-item">
                        <span class="timeline-item__title">#5239 - Hesap girişi</span>
                        <span class="product-card__meta">Normal • 7 dk önce</span>
                    </div>
                    <div class="timeline-item">
                        <span class="timeline-item__title">#5235 - İade talebi</span>
                        <span class="product-card__meta">Normal • 15 dk önce</span>
                    </div>
                </div>
            </article>
        </section>
    </main>
</body>
</html>
