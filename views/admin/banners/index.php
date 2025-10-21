<?php
$title = 'Banner Yönetimi';
ob_start();
?>
<section class="card" style="display:grid;gap:2rem;grid-template-columns:2fr 1fr;">
  <div>
    <h1>Aktif Bannerlar</h1>
    <table class="table">
      <thead><tr><th>Başlık</th><th>Bağlantı</th><th>Sıra</th></tr></thead>
      <tbody>
        <?php foreach ($banners as $banner): ?>
          <tr>
            <td><?= \Core\Helpers::e($banner['title']) ?></td>
            <td><?= \Core\Helpers::e($banner['url']) ?></td>
            <td><?= (int)$banner['sort'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <form action="<?= \Core\Helpers::baseUrl('admin/banners') ?>" method="post">
    <?= \Core\Helpers::csrfField() ?>
    <h2>Yeni Banner</h2>
    <div class="form-group">
      <label for="title">Başlık</label>
      <input class="form-control" type="text" id="title" name="title" required>
    </div>
    <div class="form-group">
      <label for="image">Görsel</label>
      <input class="form-control" type="text" id="image" name="image" required>
    </div>
    <div class="form-group">
      <label for="url">Bağlantı</label>
      <input class="form-control" type="text" id="url" name="url">
    </div>
    <div class="form-group">
      <label for="sort">Sıra</label>
      <input class="form-control" type="number" id="sort" name="sort" value="0">
    </div>
    <label style="display:flex;align-items:center;gap:0.5rem;">
      <input type="checkbox" name="is_active" value="1" checked> Yayında
    </label>
    <button class="btn-primary" type="submit" style="margin-top:1rem;">Kaydet</button>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
