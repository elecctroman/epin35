<?php $title = 'Sayfa bulunamadı'; ob_start(); ?>
<div class="card" style="text-align:center;">
  <h1>404</h1>
  <p>Aradığınız sayfa bulunamadı.</p>
  <a class="btn-primary" href="<?= \Core\Helpers::baseUrl('/') ?>">Ana sayfaya dön</a>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layouts/main.php'; ?>
