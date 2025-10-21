<?php
$title = 'Ödeme - MaxiStore';
$breadcrumb = [
  ['label' => 'Ana Sayfa', 'url' => \Core\Helpers::baseUrl('/')],
  ['label' => 'Sepet', 'url' => \Core\Helpers::baseUrl('cart')],
  ['label' => 'Ödeme']
];
ob_start();
$total = array_sum(array_map(fn($item) => $item['qty'] * $item['unit_price'], $items));
$steps = [
  'cart' => 'Sepet',
  'details' => 'Bilgiler',
  'payment' => 'Ödeme',
  'complete' => 'Tamamlandı'
];
?>
<section class="card">
  <h1>Ödeme Süreci</h1>
  <div class="stepper" role="list">
    <?php foreach ($steps as $key => $label): ?>
      <div class="step <?= $step === $key ? 'active' : '' ?>" role="listitem">
        <svg width="40" height="40"><circle cx="20" cy="20" r="18"></circle></svg>
        <span><?= \Core\Helpers::e($label) ?></span>
      </div>
    <?php endforeach; ?>
  </div>
  <?php if ($step === 'complete'): ?>
    <p>Siparişiniz başarıyla alındı. Kodlarınız hesabınıza tanımlandı.</p>
    <a class="btn-primary" href="<?= \Core\Helpers::baseUrl('account') ?>">Siparişimi Gör</a>
  <?php else: ?>
    <form action="<?= \Core\Helpers::baseUrl('checkout') ?>" method="post">
      <?= \Core\Helpers::csrfField() ?>
      <div class="form-group">
        <label for="email">E-posta</label>
        <input class="form-control" type="email" name="email" id="email" required>
      </div>
      <div class="form-group">
        <label for="payment_method">Ödeme Yöntemi</label>
        <select class="form-control" name="payment_method" id="payment_method">
          <option value="manual">Kapalı Devre</option>
          <option value="iyzico_mock">Iyzico Mock</option>
          <option value="papara_mock">Papara Mock</option>
        </select>
      </div>
      <div class="card" style="margin-top:1.5rem;">
        <h2>Sipariş Özeti</h2>
        <ul style="list-style:none;padding:0;margin:0;">
          <?php foreach ($items as $item): ?>
            <li style="display:flex;justify-content:space-between;padding:0.4rem 0;">
              <span><?= \Core\Helpers::e($item['product_name']) ?> x<?= (int)$item['qty'] ?></span>
              <span>₺<?= number_format($item['qty'] * $item['unit_price'], 2) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <div style="display:flex;justify-content:space-between;padding-top:1rem;border-top:1px solid rgba(255,255,255,0.05);margin-top:1rem;">
          <strong>Genel Toplam</strong>
          <strong>₺<?= number_format($total, 2) ?></strong>
        </div>
      </div>
      <button class="btn-primary" type="submit" style="margin-top:1.5rem;">Ödemeyi Tamamla</button>
    </form>
  <?php endif; ?>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
