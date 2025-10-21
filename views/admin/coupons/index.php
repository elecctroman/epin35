<?php
$title = 'Kuponlar';
ob_start();
?>
<section class="card" style="display:grid;gap:2rem;grid-template-columns:2fr 1fr;">
  <div>
    <h1>Kupon Yönetimi</h1>
    <table class="table">
      <thead><tr><th>Kod</th><th>Tip</th><th>Değer</th><th>Başlangıç</th><th>Bitiş</th></tr></thead>
      <tbody>
        <?php foreach ($coupons as $coupon): ?>
          <tr>
            <td><?= \Core\Helpers::e($coupon['code']) ?></td>
            <td><?= \Core\Helpers::e($coupon['type']) ?></td>
            <td><?= \Core\Helpers::e($coupon['value']) ?></td>
            <td><?= \Core\Helpers::e($coupon['starts_at']) ?></td>
            <td><?= \Core\Helpers::e($coupon['ends_at']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <form action="<?= \Core\Helpers::baseUrl('admin/coupons') ?>" method="post">
    <?= \Core\Helpers::csrfField() ?>
    <h2>Yeni Kupon</h2>
    <div class="form-group">
      <label for="code">Kod</label>
      <input class="form-control" type="text" id="code" name="code" required>
    </div>
    <div class="form-group">
      <label for="type">Tip</label>
      <select class="form-control" id="type" name="type">
        <option value="percent">Yüzde</option>
        <option value="amount">Tutar</option>
      </select>
    </div>
    <div class="form-group">
      <label for="value">Değer</label>
      <input class="form-control" type="number" step="0.01" id="value" name="value" required>
    </div>
    <div class="form-group">
      <label for="starts_at">Başlangıç</label>
      <input class="form-control" type="datetime-local" id="starts_at" name="starts_at" required>
    </div>
    <div class="form-group">
      <label for="ends_at">Bitiş</label>
      <input class="form-control" type="datetime-local" id="ends_at" name="ends_at" required>
    </div>
    <div class="form-group">
      <label for="usage_limit">Kullanım Limiti</label>
      <input class="form-control" type="number" id="usage_limit" name="usage_limit">
    </div>
    <button class="btn-primary" type="submit">Oluştur</button>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
