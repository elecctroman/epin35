<?php
$title = 'Genel Ayarlar';
ob_start();
?>
<section class="card" style="display:grid;gap:2rem;">
  <h1>Site Ayarları</h1>
  <form action="<?= \Core\Helpers::baseUrl('admin/settings') ?>" method="post">
    <?= \Core\Helpers::csrfField() ?>
    <div class="card">
      <h2>Marka</h2>
      <div class="form-group">
        <label for="branding[name]">Marka Adı</label>
        <input class="form-control" type="text" id="branding[name]" name="branding[name]" value="<?= \Core\Helpers::e($branding['name'] ?? 'MaxiStore') ?>">
      </div>
      <div class="form-group">
        <label for="branding[primary_color]">Ana Renk</label>
        <input class="form-control" type="color" id="branding[primary_color]" name="branding[primary_color]" value="<?= \Core\Helpers::e($branding['primary_color'] ?? '#3b82f6') ?>">
      </div>
    </div>
    <div class="card">
      <h2>E-posta</h2>
      <div class="form-group">
        <label for="mail[host]">SMTP Host</label>
        <input class="form-control" type="text" id="mail[host]" name="mail[host]" value="<?= \Core\Helpers::e($mail['host'] ?? '') ?>">
      </div>
      <div class="form-group">
        <label for="mail[user]">Kullanıcı</label>
        <input class="form-control" type="text" id="mail[user]" name="mail[user]" value="<?= \Core\Helpers::e($mail['user'] ?? '') ?>">
      </div>
    </div>
    <div class="card">
      <h2>Ödeme</h2>
      <div class="form-group">
        <label for="payment[iyzico_key]">Iyzico API Anahtarı</label>
        <input class="form-control" type="text" id="payment[iyzico_key]" name="payment[iyzico_key]" value="<?= \Core\Helpers::e($payment['iyzico_key'] ?? '') ?>">
      </div>
    </div>
    <button class="btn-primary" type="submit">Kaydet</button>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
