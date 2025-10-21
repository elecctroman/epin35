<?php
$title = 'Yeni Ürün';
ob_start();
?>
<section class="card" style="max-width:640px;">
  <h1>Yeni Ürün Oluştur</h1>
  <form action="<?= \Core\Helpers::baseUrl('admin/products') ?>" method="post">
    <?= \Core\Helpers::csrfField() ?>
    <div class="form-group">
      <label for="name">Ürün Adı</label>
      <input class="form-control" type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
      <label for="slug">Slug</label>
      <input class="form-control" type="text" id="slug" name="slug" required>
    </div>
    <div class="form-group">
      <label for="category_id">Kategori</label>
      <select class="form-control" id="category_id" name="category_id" required>
        <?php foreach ($categories as $category): ?>
          <option value="<?= (int)$category['id'] ?>"><?= \Core\Helpers::e($category['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label for="cover">Kapak Görseli URL</label>
      <input class="form-control" type="text" id="cover" name="cover">
    </div>
    <div class="form-group">
      <label for="description">Açıklama</label>
      <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
    </div>
    <label style="display:flex;align-items:center;gap:0.5rem;">
      <input type="checkbox" name="is_active" value="1"> Yayında olsun
    </label>
    <button class="btn-primary" type="submit" style="margin-top:1rem;">Kaydet</button>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
