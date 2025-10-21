<?php
$title = 'Yönetim Paneli';
ob_start();
?>
<section class="card">
  <h1>Kontrol Paneli</h1>
  <div class="grid" style="grid-template-columns:repeat(auto-fit,minmax(220px,1fr));margin-top:1.5rem;">
    <div class="card">
      <h3>Bugünkü Satış</h3>
      <strong>₺<?= number_format($metrics['today_sales'], 2) ?></strong>
    </div>
    <div class="card">
      <h3>Aktif Ürün</h3>
      <strong><?= (int)$metrics['active_products'] ?></strong>
    </div>
    <div class="card">
      <h3>Stok Uyarısı</h3>
      <strong><?= (int)$metrics['stock_alerts'] ?></strong>
    </div>
  </div>
  <h2 style="margin-top:2rem;">Son Siparişler</h2>
  <table class="table">
    <thead><tr><th>#</th><th>Müşteri</th><th>Tutar</th><th>Durum</th><th>Tarih</th></tr></thead>
    <tbody>
      <?php foreach ($orders as $order): ?>
        <tr>
          <td>#<?= (int)$order['id'] ?></td>
          <td><?= \Core\Helpers::e($order['email']) ?></td>
          <td>₺<?= number_format($order['total'], 2) ?></td>
          <td><?= \Core\Helpers::e($order['status']) ?></td>
          <td><?= \Core\Helpers::e($order['created_at']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
