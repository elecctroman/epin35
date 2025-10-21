<?php
$title = 'Giriş Yap - MaxiStore';
$breadcrumb = [
  ['label' => 'Ana Sayfa', 'url' => \Core\Helpers::baseUrl('/')],
  ['label' => 'Giriş Yap']
];
ob_start();
?>
<section class="card" style="max-width:420px;margin:0 auto;">
  <h1>MaxiStore Hesabına Giriş Yap</h1>
  <form action="<?= \Core\Helpers::baseUrl('login') ?>" method="post">
    <?= \Core\Helpers::csrfField() ?>
    <div class="form-group">
      <label for="email">E-posta</label>
      <input class="form-control" type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
      <label for="password">Şifre</label>
      <input class="form-control" type="password" id="password" name="password" required>
    </div>
    <button class="btn-primary" type="submit">Giriş Yap</button>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
