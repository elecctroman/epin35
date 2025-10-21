<?php
use Core\Helpers;
$title = 'Sipariş Yönetimi';
ob_start();
?>
<section class="card">
  <header class="card-title">
    <div>
      <h2>Siparişler</h2>
      <p class="subtitle">Ödeme ve teslimat akışını buradan yönetin.</p>
    </div>
  </header>
  <form class="filter-bar" method="get" action="<?= Helpers::baseUrl('admin/orders') ?>">
    <input type="search" name="q" placeholder="E-posta veya referans" value="<?= Helpers::e($filters['search']) ?>">
    <select name="status">
      <option value="">Durum</option>
      <option value="pending" <?= $filters['status'] === 'pending' ? 'selected' : '' ?>>Beklemede</option>
      <option value="paid" <?= $filters['status'] === 'paid' ? 'selected' : '' ?>>Ödendi</option>
      <option value="failed" <?= $filters['status'] === 'failed' ? 'selected' : '' ?>>Başarısız</option>
      <option value="refunded" <?= $filters['status'] === 'refunded' ? 'selected' : '' ?>>İade</option>
    </select>
    <button class="btn-muted" type="submit">Filtrele</button>
  </form>
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Müşteri</th>
        <th>Durum</th>
        <th>Tutar</th>
        <th>Ödeme</th>
        <th>Tarih</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($orders as $order): ?>
        <tr>
          <td>#<?= (int)$order['id'] ?></td>
          <td><?= Helpers::e($order['email'] ?? 'Misafir') ?></td>
          <td><span class="status-pill status-<?= Helpers::e($order['status']) ?>"><?= Helpers::e($order['status']) ?></span></td>
          <td><?= Helpers::formatCurrency((float)$order['total']) ?></td>
          <td><?= Helpers::e($order['payment_method']) ?></td>
          <td><?= Helpers::e(date('d.m.Y H:i', strtotime($order['created_at']))) ?></td>
          <td><a class="btn-muted" href="<?= Helpers::baseUrl('admin/orders/' . $order['id']) ?>">Detay</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="pagination">
    <?php for ($i = 1; $i <= $pagination['pages']; $i++): ?>
      <a class="page <?= $pagination['current'] === $i ? 'active' : '' ?>" href="<?= Helpers::baseUrl('admin/orders?page=' . $i . '&q=' . urlencode($filters['search']) . '&status=' . urlencode($filters['status'])) ?>"><?= $i ?></a>
    <?php endfor; ?>
  </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
