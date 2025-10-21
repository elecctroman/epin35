<?php
use Core\Helpers;
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="index,follow">
  <meta name="description" content="MaxiStore dijital ürün mağazası - oyun kodları, lisanslar ve e-pinler anında teslim.">
  <title><?= Helpers::e($title ?? 'MaxiStore - Dijital Ürün Mağazası') ?></title>
  <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" as="style" onload="this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"></noscript>
  <link rel="stylesheet" href="<?= Helpers::asset('css/main.css') ?>">
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'><rect rx='12' width='64' height='64' fill='%233b82f6'/><text x='32' y='42' font-family='Inter' font-size='28' text-anchor='middle' fill='white'>M</text></svg>">
  <meta property="og:title" content="MaxiStore Dijital Mağaza">
  <meta property="og:description" content="Oyun kodları, yazılım lisansları ve daha fazlası anında teslim.">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= Helpers::baseUrl() ?>">
</head>
<body>
  <?php include __DIR__ . '/../partials/header.php'; ?>
  <main>
    <div class="container">
      <?php if (!empty($breadcrumb)): ?>
        <nav class="breadcrumb" aria-label="İçerik yolu">
          <?php foreach ($breadcrumb as $item): ?>
            <?php if (!empty($item['url'])): ?>
              <a href="<?= Helpers::e($item['url']) ?>"><?= Helpers::e($item['label']) ?></a>
              <span>/</span>
            <?php else: ?>
              <span><?= Helpers::e($item['label']) ?></span>
            <?php endif; ?>
          <?php endforeach; ?>
        </nav>
      <?php endif; ?>
      <?php foreach (Helpers::getFlash() as $flash): ?>
        <div class="alert alert-<?= Helpers::e($flash['type']) ?>"><?= Helpers::e($flash['message']) ?></div>
      <?php endforeach; ?>
      <?= $content ?>
    </div>
  </main>
  <?php include __DIR__ . '/../partials/footer.php'; ?>
  <script src="<?= Helpers::asset('js/app.js') ?>" defer></script>
</body>
</html>
