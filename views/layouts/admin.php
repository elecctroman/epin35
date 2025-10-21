<?php
use Core\Helpers;
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= Helpers::e($title ?? 'MaxiStore Yönetim') ?></title>
  <link rel="stylesheet" href="<?= Helpers::asset('css/main.css') ?>">
</head>
<body>
  <div class="container" style="padding:2rem 0 4rem;">
    <header style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
      <div class="brand"><span class="brand-logo">M</span><span>MaxiStore Admin</span></div>
      <nav class="nav-actions">
        <a class="nav-button" href="<?= Helpers::baseUrl('admin') ?>">Dashboard</a>
        <a class="nav-button" href="<?= Helpers::baseUrl('/') ?>">Siteye Dön</a>
      </nav>
    </header>
    <?= $content ?>
  </div>
</body>
</html>
