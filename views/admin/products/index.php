<?php
$title = 'Ürün Yönetimi';
ob_start();
?>
<section class="card">
  <div style="display:flex;justify-content:space-between;align-items:center;">
    <h1>Ürünler</h1>
    <a class="btn-primary" href="<?= \Core\Helpers::baseUrl('admin/products/create') ?>">Yeni Ürün</a>
  </div>
  <table class="table">
    <thead><tr><th>#</th><th>Adı</th><th>Slug</th><th>Durum</th><th>Oluşturuldu</th></tr></thead>
    <tbody>
      <?php foreach ($products as $product): ?>
        <tr>
          <td><?= (int)$product['id'] ?></td>
          <td><?= \Core\Helpers::e($product['name']) ?></td>
          <td><?= \Core\Helpers::e($product['slug']) ?></td>
          <td><?= $product['is_active'] ? 'Aktif' : 'Pasif' ?></td>
          <td><?= \Core\Helpers::e($product['created_at']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
