<?php
use Core\Helpers;
$title = 'Sipariş Detayı';
ob_start();
?>
<section class="card">
  <header class="card-title">
    <div>
      <h2>Sipariş #<?= (int)$order['id'] ?></h2>
      <p class="subtitle">Ödeme referansı: <?= Helpers::e($order['payment_ref']) ?></p>
    </div>
    <a class="btn-muted" href="<?= Helpers::baseUrl('admin/orders') ?>">Listeye Dön</a>
  </header>
  <div class="order-detail">
    <div>
      <h3>Müşteri</h3>
      <p><?= Helpers::e($order['name'] ?? 'Misafir') ?></p>
      <p class="text-dim"><?= Helpers::e($order['email'] ?? '-') ?></p>
      <p><?= Helpers::e($order['payment_method']) ?></p>
      <p><?= Helpers::formatCurrency((float)$order['total']) ?></p>
    </div>
    <div>
      <h3>Durum</h3>
      <form class="form-inline" action="<?= Helpers::baseUrl('admin/orders/' . $order['id'] . '/status') ?>" method="post">
        <?= Helpers::csrfField() ?>
        <select name="status">
          <?php foreach (['pending' => 'Beklemede', 'paid' => 'Ödendi', 'failed' => 'Başarısız', 'refunded' => 'İade'] as $value => $label): ?>
            <option value="<?= $value ?>" <?= $order['status'] === $value ? 'selected' : '' ?>><?= $label ?></option>
          <?php endforeach; ?>
        </select>
        <button class="btn-primary" type="submit">Güncelle</button>
      </form>
    </div>
  </div>
  <h3>Ürünler</h3>
  <table class="table">
    <thead>
      <tr><th>Ürün</th><th>Varyasyon</th><th>Adet</th><th>Birim Fiyat</th><th>Teslimat</th></tr>
    </thead>
    <tbody>
      <?php foreach ($order['items'] as $item): ?>
        <tr>
          <td><?= Helpers::e($item['name']) ?></td>
          <td><?= Helpers::e($item['title']) ?></td>
          <td><?= (int)$item['qty'] ?></td>
          <td><?= Helpers::formatCurrency((float)$item['unit_price']) ?></td>
          <td><pre class="payload"><?= Helpers::e($item['delivered_payload']) ?></pre></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
