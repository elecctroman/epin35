<?php
use Core\Helpers;
$title = 'Ürün Düzenle';
ob_start();
?>
<section class="card">
  <header class="card-title">
    <div>
      <h2><?= Helpers::e($product['name']) ?></h2>
      <p class="subtitle">Ürünü güncelleyin, varyasyon ve stokları yönetin.</p>
    </div>
    <a class="btn-muted" href="<?= Helpers::baseUrl('admin/products') ?>">Listeye Dön</a>
  </header>
  <form class="form-grid" action="<?= Helpers::baseUrl('admin/products/' . $product['id'] . '/update') ?>" method="post">
    <?= Helpers::csrfField() ?>
    <div class="form-field">
      <label for="name">Ürün Adı</label>
      <input type="text" id="name" name="name" value="<?= Helpers::e($product['name']) ?>" required>
    </div>
    <div class="form-field">
      <label for="slug">Slug</label>
      <input type="text" id="slug" name="slug" value="<?= Helpers::e($product['slug']) ?>" required>
    </div>
    <div class="form-field">
      <label for="category_id">Kategori</label>
      <select id="category_id" name="category_id" required>
        <?php foreach ($categories as $category): ?>
          <option value="<?= (int)$category['id'] ?>" <?= (int)$category['id'] === (int)$product['category_id'] ? 'selected' : '' ?>><?= Helpers::e($category['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-field">
      <label for="cover">Kapak Görseli URL</label>
      <input type="text" id="cover" name="cover" value="<?= Helpers::e($product['cover']) ?>">
    </div>
    <div class="form-field form-field-full">
      <label for="description">Ürün Açıklaması</label>
      <textarea id="description" name="description" rows="5" required><?= Helpers::e($product['description']) ?></textarea>
    </div>
    <label class="form-switch">
      <input type="checkbox" name="is_active" value="1" <?= $product['is_active'] ? 'checked' : '' ?>>
      <span>Ürün yayında</span>
    </label>

    <div class="form-field-full">
      <h3>Varyasyonlar</h3>
      <div class="variation-list" data-variation-list>
        <?php foreach ($variations as $variation): ?>
          <div class="variation-item" data-variation>
            <input type="hidden" name="variation_id[]" value="<?= (int)$variation['id'] ?>">
            <div class="form-field">
              <label>Başlık</label>
              <input type="text" name="variation_title[]" value="<?= Helpers::e($variation['title']) ?>" required>
            </div>
            <div class="form-field">
              <label>Fiyat (₺)</label>
              <input type="number" step="0.01" min="0" name="variation_price[]" value="<?= Helpers::e($variation['price']) ?>" required>
            </div>
            <div class="form-field">
              <label>Eski Fiyat</label>
              <input type="number" step="0.01" name="variation_old_price[]" value="<?= Helpers::e($variation['old_price']) ?>">
            </div>
            <div class="form-field">
              <label>Stok Adedi</label>
              <input type="number" min="0" name="variation_stock[]" value="<?= Helpers::e($variation['stock']) ?>">
            </div>
            <div class="form-field">
              <label>SKU</label>
              <input type="text" name="variation_sku[]" value="<?= Helpers::e($variation['sku']) ?>">
            </div>
            <div class="form-field form-field-full">
              <label>Yeni Stok Kodları</label>
              <textarea name="variation_codes[]" rows="3" placeholder="Yeni kodları her satıra bir adet girin."></textarea>
              <small class="text-dim">Mevcut kodlar gizlendi. Yeni eklenen kodlar stoklara eklenir.</small>
            </div>
            <button class="btn-muted" type="button" data-remove-variation>Varyasyonu Kaldır</button>
          </div>
        <?php endforeach; ?>
      </div>
      <button class="btn-outline" type="button" data-add-variation>Yeni Varyasyon Ekle</button>
    </div>

    <button class="btn-primary" type="submit">Değişiklikleri Kaydet</button>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
