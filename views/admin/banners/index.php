<?php
use Core\Helpers;
$title = 'Banner Yönetimi';
ob_start();
?>
<section class="card">
  <header class="card-title">
    <div>
      <h2>Bannerlar</h2>
      <p class="subtitle">Ana sayfa promosyon görselleri.</p>
    </div>
  </header>
  <table class="table">
    <thead>
      <tr><th>Başlık</th><th>Adres</th><th>Sıra</th><th>Durum</th><th></th></tr>
    </thead>
    <tbody>
      <?php foreach ($banners as $banner): ?>
        <tr>
          <td><?= Helpers::e($banner['title']) ?></td>
          <td><?= Helpers::e($banner['url']) ?></td>
          <td><?= (int)$banner['sort'] ?></td>
          <td><span class="status-pill status-<?= $banner['is_active'] ? 'paid' : 'failed' ?>"><?= $banner['is_active'] ? 'Aktif' : 'Pasif' ?></span></td>
          <td class="table-actions">
            <form class="form-inline" method="post" action="<?= Helpers::baseUrl('admin/banners/' . $banner['id'] . '/update') ?>">
              <?= Helpers::csrfField() ?>
              <input type="hidden" name="title" value="<?= Helpers::e($banner['title']) ?>">
              <input type="text" name="url" value="<?= Helpers::e($banner['url']) ?>">
              <input type="text" name="image" value="<?= Helpers::e($banner['image']) ?>">
              <input type="number" name="sort" value="<?= (int)$banner['sort'] ?>">
              <label class="form-switch inline"><input type="checkbox" name="is_active" value="1" <?= $banner['is_active'] ? 'checked' : '' ?>><span>Aktif</span></label>
              <button class="btn-muted" type="submit">Güncelle</button>
            </form>
            <form method="post" action="<?= Helpers::baseUrl('admin/banners/' . $banner['id'] . '/delete') ?>" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
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
    <h3>Yeni Banner</h3>
  </header>
  <form class="form-grid" action="<?= Helpers::baseUrl('admin/banners') ?>" method="post">
    <?= Helpers::csrfField() ?>
    <div class="form-field">
      <label>Başlık</label>
      <input type="text" name="title" required>
    </div>
    <div class="form-field">
      <label>Görsel URL</label>
      <input type="text" name="image" required>
    </div>
    <div class="form-field">
      <label>Yönlendirme URL</label>
      <input type="text" name="url" value="#">
    </div>
    <div class="form-field">
      <label>Sıra</label>
      <input type="number" name="sort" value="0">
    </div>
    <label class="form-switch">
      <input type="checkbox" name="is_active" value="1" checked>
      <span>Aktif</span>
    </label>
    <button class="btn-primary" type="submit">Banner Ekle</button>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
