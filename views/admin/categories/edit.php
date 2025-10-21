<?php
use Core\Helpers;
$title = 'Kategori Güncelle';
ob_start();
?>
<section class="card" style="max-width:640px;">
  <header class="card-title">
    <div>
      <h2>Kategori Düzenle</h2>
      <p class="subtitle"><?= Helpers::e($category['name']) ?> kategorisini güncelleyin.</p>
    </div>
    <a class="btn-muted" href="<?= Helpers::baseUrl('admin/categories') ?>">Listeye Dön</a>
  </header>
  <form class="form-grid" action="<?= Helpers::baseUrl('admin/categories/' . $category['id'] . '/update') ?>" method="post">
    <?= Helpers::csrfField() ?>
    <div class="form-field">
      <label>Adı</label>
      <input type="text" name="name" value="<?= Helpers::e($category['name']) ?>" required>
    </div>
    <div class="form-field">
      <label>Slug</label>
      <input type="text" name="slug" value="<?= Helpers::e($category['slug']) ?>" required>
    </div>
    <div class="form-field">
      <label>Üst Kategori</label>
      <select name="parent_id">
        <option value="">Yok</option>
        <?php foreach ($categories as $option): ?>
          <option value="<?= (int)$option['id'] ?>" <?= (int)$option['id'] === (int)$category['parent_id'] ? 'selected' : '' ?>><?= Helpers::e($option['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-field">
      <label>Sıra</label>
      <input type="number" name="sort" value="<?= Helpers::e($category['sort']) ?>">
    </div>
    <button class="btn-primary" type="submit">Kaydet</button>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
