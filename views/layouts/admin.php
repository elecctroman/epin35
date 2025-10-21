<?php
use Core\Helpers;
$flashes = Helpers::getFlash('admin');
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= Helpers::e($title ?? 'MaxiStore Yönetim') ?></title>
  <link rel="stylesheet" href="<?= Helpers::asset('css/main.css') ?>">
</head>
<body class="admin-body">
  <div class="admin-shell">
    <aside class="admin-sidebar">
      <div class="admin-brand">
        <span class="brand-logo">M</span>
        <div>
          <strong>MaxiStore</strong>
          <small>Kontrol Merkezi</small>
        </div>
      </div>
      <nav class="admin-nav">
        <a class="admin-nav-item <?= Helpers::activeNav('/admin') ?>" href="<?= Helpers::baseUrl('admin') ?>">Dashboard</a>
        <p class="admin-nav-label">Mağaza Yönetimi</p>
        <a class="admin-nav-item <?= Helpers::activeNav('/admin/products') ?>" href="<?= Helpers::baseUrl('admin/products') ?>">Ürünler</a>
        <a class="admin-nav-item <?= Helpers::activeNav('/admin/categories') ?>" href="<?= Helpers::baseUrl('admin/categories') ?>">Kategoriler</a>
        <a class="admin-nav-item <?= Helpers::activeNav('/admin/orders') ?>" href="<?= Helpers::baseUrl('admin/orders') ?>">Siparişler</a>
        <a class="admin-nav-item <?= Helpers::activeNav('/admin/users') ?>" href="<?= Helpers::baseUrl('admin/users') ?>">Kullanıcılar</a>
        <a class="admin-nav-item <?= Helpers::activeNav('/admin/coupons') ?>" href="<?= Helpers::baseUrl('admin/coupons') ?>">Kuponlar</a>
        <a class="admin-nav-item <?= Helpers::activeNav('/admin/vendors') ?>" href="<?= Helpers::baseUrl('admin/vendors') ?>">Satıcılar</a>
        <a class="admin-nav-item <?= Helpers::activeNav('/admin/banners') ?>" href="<?= Helpers::baseUrl('admin/banners') ?>">Bannerlar</a>
        <p class="admin-nav-label">Destek ve Analiz</p>
        <a class="admin-nav-item <?= Helpers::activeNav('/admin/tickets') ?>" href="<?= Helpers::baseUrl('admin/tickets') ?>">Destek Talepleri</a>
        <a class="admin-nav-item <?= Helpers::activeNav('/admin/reports') ?>" href="<?= Helpers::baseUrl('admin/reports') ?>">Raporlar</a>
        <p class="admin-nav-label">Ayarlar</p>
        <a class="admin-nav-item <?= Helpers::activeNav('/admin/settings') ?>" href="<?= Helpers::baseUrl('admin/settings') ?>">Genel Ayarlar</a>
        <a class="admin-nav-item" href="<?= Helpers::baseUrl('/') ?>">Mağazaya Dön</a>
      </nav>
    </aside>
    <main class="admin-main">
      <header class="admin-topbar">
        <div>
          <h1><?= Helpers::e($title ?? 'MaxiStore Yönetim') ?></h1>
          <p class="subtitle">Profesyonel dijital mağaza operasyon kontrolü</p>
        </div>
        <div class="admin-user">
          <span class="badge">Yönetici</span>
          <a class="btn-muted" href="<?= Helpers::baseUrl('logout') ?>">Çıkış</a>
        </div>
      </header>
      <?php if (!empty($flashes)): ?>
        <div class="flash-stack">
          <?php foreach ($flashes as $flash): ?>
            <div class="flash flash-<?= Helpers::e($flash['type']) ?>"><?= Helpers::e($flash['message']) ?></div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <div class="admin-content">
        <?= $content ?>
      </div>
    </main>
  </div>
  <script src="<?= Helpers::asset('js/app.js') ?>" defer></script>
</body>
</html>
