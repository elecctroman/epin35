<?php
$title = 'Siparişler';
ob_start();
?>
<section class="card">
  <h1>Siparişler</h1>
  <table class="table">
    <thead><tr><th>#</th><th>Kullanıcı</th><th>Durum</th><th>Tutar</th><th>Ödeme</th><th>Oluşturma</th></tr></thead>
    <tbody>
      <?php foreach ($orders as $order): ?>
        <tr>
          <td>#<?= (int)$order['id'] ?></td>
          <td><?= \Core\Helpers::e($order['email']) ?></td>
          <td><?= \Core\Helpers::e($order['status']) ?></td>
          <td>₺<?= number_format($order['total'], 2) ?></td>
          <td><?= \Core\Helpers::e($order['payment_method']) ?></td>
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
