<?php
$title = 'Kategoriler';
ob_start();
?>
<section class="card" style="display:grid;gap:2rem;grid-template-columns:2fr 1fr;">
  <div>
    <h1>Kategori Listesi</h1>
    <table class="table">
      <thead><tr><th>#</th><th>Adı</th><th>Slug</th><th>Sıra</th></tr></thead>
      <tbody>
        <?php foreach ($categories as $category): ?>
          <tr>
            <td><?= (int)$category['id'] ?></td>
            <td><?= \Core\Helpers::e($category['name']) ?></td>
            <td><?= \Core\Helpers::e($category['slug']) ?></td>
            <td><?= (int)$category['sort'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <form action="<?= \Core\Helpers::baseUrl('admin/categories') ?>" method="post">
    <?= \Core\Helpers::csrfField() ?>
    <h2>Yeni Kategori</h2>
    <div class="form-group">
      <label for="name">Adı</label>
      <input class="form-control" type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
      <label for="slug">Slug</label>
      <input class="form-control" type="text" id="slug" name="slug" required>
    </div>
    <div class="form-group">
      <label for="sort">Sıra</label>
      <input class="form-control" type="number" id="sort" name="sort" value="0">
    </div>
    <button class="btn-primary" type="submit">Kaydet</button>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
