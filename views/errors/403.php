<?php $title = 'Erişim engellendi'; ob_start(); ?>
<div class="card" style="text-align:center;">
  <h1>403</h1>
  <p>Bu sayfayı görüntülemek için yetkiniz yok.</p>
  <a class="btn-primary" href="<?= \Core\Helpers::baseUrl('/') ?>">Ana sayfaya dön</a>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layouts/main.php'; ?>
