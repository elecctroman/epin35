<?php
use Core\Helpers;
$title = 'Ürün Yönetimi';
ob_start();
?>
<section class="card">
  <header class="card-title">
    <div>
      <h2>Ürünler</h2>
      <p class="subtitle">Dijital e-pin ve lisans katalog yönetimi</p>
    </div>
    <a class="btn-primary" href="<?= Helpers::baseUrl('admin/products/create') ?>">Yeni Ürün</a>
  </header>
  <form class="filter-bar" method="get" action="<?= Helpers::baseUrl('admin/products') ?>">
    <input type="search" name="q" placeholder="Ürün adı veya slug" value="<?= Helpers::e($filters['search']) ?>">
    <select name="status">
      <option value="">Durum (tümü)</option>
      <option value="1" <?= $filters['status'] === '1' ? 'selected' : '' ?>>Aktif</option>
      <option value="0" <?= $filters['status'] === '0' ? 'selected' : '' ?>>Pasif</option>
    </select>
    <select name="category_id">
      <option value="">Kategori</option>
      <?php foreach ($categories as $category): ?>
        <option value="<?= (int)$category['id'] ?>" <?= (string)$filters['category_id'] === (string)$category['id'] ? 'selected' : '' ?>><?= Helpers::e($category['name']) ?></option>
      <?php endforeach; ?>
    </select>
    <button class="btn-muted" type="submit">Filtrele</button>
  </form>
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Ürün</th>
        <th>Kategori</th>
        <th>Fiyat</th>
        <th>Stok</th>
        <th>Durum</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product): ?>
        <tr>
          <td>#<?= (int)$product['id'] ?></td>
          <td>
            <strong><?= Helpers::e($product['name']) ?></strong><br>
            <small class="text-dim"><?= Helpers::e($product['slug']) ?></small>
          </td>
          <td><?= Helpers::e($product['category_name'] ?? '-') ?></td>
          <td><?= Helpers::formatCurrency((float)($product['min_price'] ?? 0)) ?></td>
          <td><?= (int)($product['total_stock'] ?? 0) ?></td>
          <td><span class="status-pill status-<?= $product['is_active'] ? 'paid' : 'failed' ?>"><?= $product['is_active'] ? 'Aktif' : 'Pasif' ?></span></td>
          <td class="table-actions">
            <a class="btn-muted" href="<?= Helpers::baseUrl('admin/products/' . $product['id'] . '/edit') ?>">Düzenle</a>
            <form method="post" action="<?= Helpers::baseUrl('admin/products/' . $product['id'] . '/toggle') ?>">
              <?= Helpers::csrfField() ?>
              <button type="submit" class="btn-muted">Durum</button>
            </form>
            <form method="post" action="<?= Helpers::baseUrl('admin/products/' . $product['id'] . '/delete') ?>" onsubmit="return confirm('Ürünü silmek istediğinize emin misiniz?');">
              <?= Helpers::csrfField() ?>
              <button type="submit" class="btn-danger">Sil</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="pagination">
    <?php for ($i = 1; $i <= $pagination['pages']; $i++): ?>
      <a class="page <?= $pagination['current'] === $i ? 'active' : '' ?>" href="<?= Helpers::baseUrl('admin/products?page=' . $i . '&q=' . urlencode($filters['search']) . '&status=' . urlencode($filters['status']) . '&category_id=' . urlencode($filters['category_id'])) ?>"><?= $i ?></a>
    <?php endfor; ?>
  </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
