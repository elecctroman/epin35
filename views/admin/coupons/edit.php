<?php
use Core\Helpers;
$title = 'Kupon Güncelle';
ob_start();
?>
<section class="card" style="max-width:720px;">
  <header class="card-title">
    <div>
      <h2>Kupon Düzenle</h2>
      <p class="subtitle"><?= Helpers::e($coupon['code']) ?> promosyon kodunu güncelleyin.</p>
    </div>
    <a class="btn-muted" href="<?= Helpers::baseUrl('admin/coupons') ?>">Listeye Dön</a>
  </header>
  <form class="form-grid" action="<?= Helpers::baseUrl('admin/coupons/' . $coupon['id'] . '/update') ?>" method="post">
    <?= Helpers::csrfField() ?>
    <div class="form-field">
      <label>Kod</label>
      <input type="text" name="code" value="<?= Helpers::e($coupon['code']) ?>" required>
    </div>
    <div class="form-field">
      <label>Tip</label>
      <select name="type">
        <option value="percent" <?= $coupon['type'] === 'percent' ? 'selected' : '' ?>>Yüzde</option>
        <option value="amount" <?= $coupon['type'] === 'amount' ? 'selected' : '' ?>>Tutar</option>
      </select>
    </div>
    <div class="form-field">
      <label>Değer</label>
      <input type="number" step="0.01" name="value" value="<?= Helpers::e($coupon['value']) ?>" required>
    </div>
    <div class="form-field">
      <label>Minimum Sepet</label>
      <input type="number" step="0.01" name="min_total" value="<?= Helpers::e($coupon['min_total']) ?>">
    </div>
    <div class="form-field">
      <label>Başlangıç</label>
      <input type="datetime-local" name="starts_at" value="<?= Helpers::e(str_replace(' ', 'T', substr($coupon['starts_at'], 0, 16))) ?>" required>
    </div>
    <div class="form-field">
      <label>Bitiş</label>
      <input type="datetime-local" name="ends_at" value="<?= Helpers::e(str_replace(' ', 'T', substr($coupon['ends_at'], 0, 16))) ?>" required>
    </div>
    <div class="form-field">
      <label>Kullanım Limiti</label>
      <input type="number" name="usage_limit" value="<?= Helpers::e($coupon['usage_limit']) ?>">
    </div>
    <button class="btn-primary" type="submit">Güncelle</button>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
