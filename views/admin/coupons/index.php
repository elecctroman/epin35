<?php
use Core\Helpers;
$title = 'Kupon Yönetimi';
ob_start();
?>
<section class="card">
  <header class="card-title">
    <div>
      <h2>Kuponlar</h2>
      <p class="subtitle">Promosyon kodlarını yönetin.</p>
    </div>
  </header>
  <table class="table">
    <thead>
      <tr><th>Kod</th><th>Tip</th><th>Değer</th><th>Min. Tutar</th><th>Başlangıç</th><th>Bitiş</th><th>Limit</th><th></th></tr>
    </thead>
    <tbody>
      <?php foreach ($coupons as $coupon): ?>
        <tr>
          <td><?= Helpers::e($coupon['code']) ?></td>
          <td><?= Helpers::e($coupon['type']) ?></td>
          <td><?= Helpers::e($coupon['value']) ?></td>
          <td><?= Helpers::e($coupon['min_total']) ?></td>
          <td><?= Helpers::e($coupon['starts_at']) ?></td>
          <td><?= Helpers::e($coupon['ends_at']) ?></td>
          <td><?= Helpers::e($coupon['usage_limit']) ?></td>
          <td class="table-actions">
            <a class="btn-muted" href="<?= Helpers::baseUrl('admin/coupons/' . $coupon['id'] . '/edit') ?>">Düzenle</a>
            <form method="post" action="<?= Helpers::baseUrl('admin/coupons/' . $coupon['id'] . '/delete') ?>" onsubmit="return confirm('Kuponu silmek istiyor musunuz?');">
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
    <h3>Yeni Kupon Oluştur</h3>
  </header>
  <form class="form-grid" action="<?= Helpers::baseUrl('admin/coupons') ?>" method="post">
    <?= Helpers::csrfField() ?>
    <div class="form-field">
      <label>Kod</label>
      <input type="text" name="code" required>
    </div>
    <div class="form-field">
      <label>Tip</label>
      <select name="type">
        <option value="percent">Yüzde</option>
        <option value="amount">Tutar</option>
      </select>
    </div>
    <div class="form-field">
      <label>Değer</label>
      <input type="number" step="0.01" name="value" required>
    </div>
    <div class="form-field">
      <label>Minimum Sepet</label>
      <input type="number" step="0.01" name="min_total">
    </div>
    <div class="form-field">
      <label>Başlangıç</label>
      <input type="datetime-local" name="starts_at" required>
    </div>
    <div class="form-field">
      <label>Bitiş</label>
      <input type="datetime-local" name="ends_at" required>
    </div>
    <div class="form-field">
      <label>Kullanım Limiti</label>
      <input type="number" name="usage_limit">
    </div>
    <button class="btn-primary" type="submit">Kupon Kaydet</button>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
