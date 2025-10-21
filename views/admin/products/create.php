<?php
use Core\Helpers;
$title = 'Yeni Ürün';
ob_start();
?>
<section class="card">
  <header class="card-title">
    <div>
      <h2>Yeni Ürün Oluştur</h2>
      <p class="subtitle">Ürün bilgileri ve stok kodlarını tanımlayın</p>
    </div>
    <a class="btn-muted" href="<?= Helpers::baseUrl('admin/products') ?>">Listeye Dön</a>
  </header>
  <form class="form-grid" action="<?= Helpers::baseUrl('admin/products') ?>" method="post">
    <?= Helpers::csrfField() ?>
    <div class="form-field">
      <label for="name">Ürün Adı</label>
      <input type="text" id="name" name="name" required>
    </div>
    <div class="form-field">
      <label for="slug">Slug</label>
      <input type="text" id="slug" name="slug" required>
    </div>
    <div class="form-field">
      <label for="category_id">Kategori</label>
      <select id="category_id" name="category_id" required>
        <option value="">Seçiniz</option>
        <?php foreach ($categories as $category): ?>
          <option value="<?= (int)$category['id'] ?>"><?= Helpers::e($category['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-field">
      <label for="cover">Kapak Görseli URL</label>
      <input type="text" id="cover" name="cover" placeholder="https://...">
    </div>
    <div class="form-field form-field-full">
      <label for="description">Ürün Açıklaması</label>
      <textarea id="description" name="description" rows="5" required></textarea>
    </div>
    <label class="form-switch">
      <input type="checkbox" name="is_active" value="1" checked>
      <span>Ürün yayında olsun</span>
    </label>

    <div class="form-field-full">
      <h3>Varyasyonlar</h3>
      <p class="subtitle">Her varyasyon için fiyat, stok ve isteğe bağlı stok kodlarını girin.</p>
      <div class="variation-list" data-variation-list>
        <div class="variation-item" data-variation>
          <div class="form-field">
            <label>Başlık</label>
            <input type="text" name="variation_title[]" placeholder="Örn: 60 UC" required>
          </div>
          <div class="form-field">
            <label>Fiyat (₺)</label>
            <input type="number" step="0.01" min="0" name="variation_price[]" required>
          </div>
          <div class="form-field">
            <label>Eski Fiyat</label>
            <input type="number" step="0.01" name="variation_old_price[]">
          </div>
          <div class="form-field">
            <label>Stok Adedi</label>
            <input type="number" min="0" name="variation_stock[]" value="0">
          </div>
          <div class="form-field">
            <label>SKU</label>
            <input type="text" name="variation_sku[]" placeholder="MS-001">
          </div>
          <div class="form-field form-field-full">
            <label>Stok Kodları (her satır bir kod)</label>
            <textarea name="variation_codes[]" rows="3" placeholder="ABCD-1234-XYZ
EFGH-5678-IJK"></textarea>
          </div>
          <button class="btn-muted" type="button" data-remove-variation>Varyasyonu Kaldır</button>
        </div>
      </div>
      <button class="btn-outline" type="button" data-add-variation>Yeni Varyasyon Ekle</button>
    </div>

    <button class="btn-primary" type="submit">Ürünü Kaydet</button>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
