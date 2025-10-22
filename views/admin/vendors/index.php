<?php
use Core\Helpers;
$title = 'Satıcı Yönetimi';
ob_start();
?>
<section class="card">
  <header class="card-title">
    <div>
      <h2>Satıcılar</h2>
      <p class="subtitle">Pazaryeri satıcı performansını yönetin.</p>
    </div>
  </header>
  <table class="table">
    <thead>
      <tr><th>Ad</th><th>Puan</th><th>Satış</th><th></th></tr>
    </thead>
    <tbody>
      <?php foreach ($vendors as $vendor): ?>
        <tr>
          <td><?= Helpers::e($vendor['name']) ?></td>
          <td><?= Helpers::e($vendor['rating']) ?></td>
          <td><?= (int)$vendor['sales_count'] ?></td>
          <td class="table-actions">
            <form class="form-inline" method="post" action="<?= Helpers::baseUrl('admin/vendors/' . $vendor['id'] . '/update') ?>">
              <?= Helpers::csrfField() ?>
              <input type="hidden" name="name" value="<?= Helpers::e($vendor['name']) ?>">
              <input type="number" step="0.1" name="rating" value="<?= Helpers::e($vendor['rating']) ?>">
              <input type="number" name="sales_count" value="<?= (int)$vendor['sales_count'] ?>">
              <button class="btn-muted" type="submit">Kaydet</button>
            </form>
            <form method="post" action="<?= Helpers::baseUrl('admin/vendors/' . $vendor['id'] . '/delete') ?>" onsubmit="return confirm('Satıcıyı silmek istediğinize emin misiniz?');">
              <?= Helpers::csrfField() ?>
              <button class="btn-danger" type="submit">Sil</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>

<section class="card" style="margin-top:2rem;">
  <header class="card-title">
    <h3>Yeni Satıcı</h3>
  </header>
  <form class="form-grid" method="post" action="<?= Helpers::baseUrl('admin/vendors') ?>">
    <?= Helpers::csrfField() ?>
    <div class="form-field">
      <label>Ad</label>
      <input type="text" name="name" required>
    </div>
    <div class="form-field">
      <label>Puan</label>
      <input type="number" step="0.1" name="rating" value="5.0">
    </div>
    <div class="form-field">
      <label>Satış</label>
      <input type="number" name="sales_count" value="0">
    </div>
    <button class="btn-primary" type="submit">Satıcı Ekle</button>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
