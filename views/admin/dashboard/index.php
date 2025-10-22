<?php
use Core\Helpers;
$title = 'Kontrol Paneli';
ob_start();
?>
<section class="admin-grid">
  <article class="card metric-card">
    <h3>Bugünkü Satış</h3>
    <strong><?= Helpers::formatCurrency($metrics['today_sales'] ?? 0) ?></strong>
    <span>Güncel canlı satış hacmi</span>
  </article>
  <article class="card metric-card">
    <h3>Bu Ay</h3>
    <strong><?= Helpers::formatCurrency($metrics['month_sales'] ?? 0) ?></strong>
    <span>Ay toplam ciro</span>
  </article>
  <article class="card metric-card">
    <h3>Aktif Ürün</h3>
    <strong><?= (int)($metrics['active_products'] ?? 0) ?></strong>
    <span>Mağazada yayında</span>
  </article>
  <article class="card metric-card">
    <h3>Bekleyen Sipariş</h3>
    <strong><?= (int)($metrics['pending_orders'] ?? 0) ?></strong>
    <span>Onay bekleyen işlemler</span>
  </article>
  <article class="card metric-card">
    <h3>Ortalama Sepet</h3>
    <strong><?= Helpers::formatCurrency($metrics['average_ticket'] ?? 0) ?></strong>
    <span>Müşteri başına gelir</span>
  </article>
  <article class="card metric-card warning">
    <h3>Stok Uyarısı</h3>
    <strong><?= (int)($metrics['stock_alerts'] ?? 0) ?></strong>
    <span>Kritik stok seviyesi</span>
  </article>
</section>

<section class="admin-grid" style="margin-top:2rem;grid-template-columns:2fr 1fr;">
  <article class="card">
    <header class="card-title">
      <h2>Gelir Eğrisi</h2>
      <span>Son 10 gün</span>
    </header>
    <div class="chart" data-chart='<?= json_encode($timeline, JSON_UNESCAPED_UNICODE) ?>'></div>
  </article>
  <article class="card">
    <header class="card-title">
      <h2>Durum Dağılımı</h2>
      <span>Sipariş adetleri</span>
    </header>
    <ul class="status-list">
      <?php foreach ($statusBreakdown as $status => $total): ?>
        <li><span><?= Helpers::e(ucfirst($status)) ?></span><strong><?= (int)$total ?></strong></li>
      <?php endforeach; ?>
    </ul>
  </article>
</section>

<section class="admin-grid" style="margin-top:2rem;grid-template-columns:2fr 1fr;">
  <article class="card">
    <header class="card-title">
      <h2>Son Siparişler</h2>
      <a class="btn-muted" href="<?= Helpers::baseUrl('admin/orders') ?>">Tümünü Gör</a>
    </header>
    <table class="table">
      <thead>
        <tr><th>#</th><th>Müşteri</th><th>Tutar</th><th>Durum</th><th>Tarih</th></tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $order): ?>
          <tr>
            <td>#<?= (int)$order['id'] ?></td>
            <td><?= Helpers::e($order['email'] ?? 'Misafir') ?></td>
            <td><?= Helpers::formatCurrency((float)$order['total']) ?></td>
            <td><span class="status-pill status-<?= Helpers::e($order['status']) ?>"><?= Helpers::e($order['status']) ?></span></td>
            <td><?= Helpers::e(date('d.m.Y H:i', strtotime($order['created_at']))) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </article>
  <article class="card">
    <header class="card-title">
      <h2>Destek Kuyruğu</h2>
      <a class="btn-muted" href="<?= Helpers::baseUrl('admin/tickets') ?>">Panele Git</a>
    </header>
    <ul class="ticket-feed">
      <?php foreach ($tickets as $ticket): ?>
        <li>
          <h4><?= Helpers::e($ticket['subject']) ?></h4>
          <p><?= Helpers::e($ticket['email'] ?? 'Misafir') ?></p>
          <span class="status-pill status-<?= Helpers::e($ticket['status']) ?>"><?= Helpers::e($ticket['status']) ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
  </article>
</section>

<section class="card" style="margin-top:2rem;">
  <header class="card-title">
    <h2>En Çok Satan 5 Ürün</h2>
    <span>Kümülatif satış adeti</span>
  </header>
  <table class="table">
    <thead>
      <tr><th>Ürün</th><th>Fiyat</th><th>Satış</th></tr>
    </thead>
    <tbody>
      <?php foreach ($topProducts as $product): ?>
        <tr>
          <td><?= Helpers::e($product['name']) ?></td>
          <td><?= Helpers::formatCurrency((float)($product['min_price'] ?? 0)) ?></td>
          <td><?= (int)($product['total_qty'] ?? 0) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
