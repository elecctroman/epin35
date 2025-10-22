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
<section class="panel checkout">
  <header class="panel-header">
    <div>
      <h1>Ödeme Süreci</h1>
      <p>Mock ödeme altyapısı ile saniyeler içinde onaylanan güvenli alışveriş.</p>
    </div>
  </header>
  <div class="stepper" role="list">
    <?php foreach ($steps as $key => $label): ?>
      <div class="step <?= $step === $key ? 'active' : '' ?>" role="listitem">
        <svg width="40" height="40"><circle cx="20" cy="20" r="18"></circle></svg>
        <span><?= \Core\Helpers::e($label) ?></span>
      </div>
    <?php endforeach; ?>
  </div>
  <?php if ($step === 'complete'): ?>
    <div class="success-card">
      <h2>Teşekkürler!</h2>
      <p>Siparişiniz başarıyla alındı. Kodlarınız Hesabım &gt; Lisans Kasası bölümünde görüntülenebilir.</p>
      <a class="btn-primary" href="<?= \Core\Helpers::baseUrl('account') ?>">Siparişimi Gör</a>
    </div>
  <?php else: ?>
    <div class="checkout-grid">
      <form action="<?= \Core\Helpers::baseUrl('checkout') ?>" method="post" class="checkout-form">
        <?= \Core\Helpers::csrfField() ?>
        <div class="form-group">
          <label for="email">E-posta</label>
          <input class="form-control" type="email" name="email" id="email" required placeholder="ornek@mail.com">
        </div>
        <div class="form-group">
          <label for="payment_method">Ödeme Yöntemi</label>
          <select class="form-control" name="payment_method" id="payment_method">
            <option value="manual">Kapalı Devre</option>
            <option value="iyzico_mock">Iyzico Mock</option>
            <option value="papara_mock">Papara Mock</option>
          </select>
        </div>
        <div class="form-group">
          <label for="notes">Sipariş Notu <small>(isteğe bağlı)</small></label>
          <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Teslimat notunuz..."></textarea>
        </div>
        <button class="btn-primary" type="submit">Ödemeyi Tamamla</button>
        <p class="security-note"><span class="icon-pill"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-shield') ?>"></use></svg></span> FraudShield, tüm ödemeleri otomatik olarak doğrular.</p>
      </form>
      <aside class="checkout-summary">
        <h2>Sipariş Özeti</h2>
        <ul>
          <?php foreach ($items as $item): ?>
            <li>
              <div>
                <strong><?= \Core\Helpers::e($item['product_name']) ?></strong>
                <span><?= \Core\Helpers::e($item['variation_title']) ?> x<?= (int)$item['qty'] ?></span>
              </div>
              <span><?= \Core\Helpers::formatCurrency((float)$item['qty'] * $item['unit_price']) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <div class="checkout-total">
          <span>Genel Toplam</span>
          <strong><?= \Core\Helpers::formatCurrency((float)$total) ?></strong>
        </div>
        <div class="payment-badges">
          <span>Iyzico Mock</span>
          <span>Papara Mock</span>
          <span>Shopier Mock</span>
        </div>
      </aside>
    </div>
  <?php endif; ?>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
