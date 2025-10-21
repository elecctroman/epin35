<?php
use Core\Helpers;
$title = 'Raporlar';
ob_start();
?>
<section class="card">
  <header class="card-title">
    <div>
      <h2>Satış Raporları</h2>
      <p class="subtitle">Son 30 güne ait trendler ve ödeme dağılımı.</p>
    </div>
  </header>
  <div class="reports-grid">
    <article class="card">
      <h3>Günlük Gelir</h3>
      <div class="chart" data-chart='<?= json_encode($dailySales, JSON_UNESCAPED_UNICODE) ?>'></div>
    </article>
    <article class="card">
      <h3>Durum Dağılımı</h3>
      <ul class="status-list">
        <?php foreach ($status as $name => $count): ?>
          <li><span><?= Helpers::e($name) ?></span><strong><?= (int)$count ?></strong></li>
        <?php endforeach; ?>
      </ul>
    </article>
  </div>

  <section class="card" style="margin-top:2rem;">
    <h3>Ödeme Yöntemleri</h3>
    <table class="table">
      <thead><tr><th>Yöntem</th><th>Sipariş</th><th>Ciro</th></tr></thead>
      <tbody>
        <?php foreach ($payments as $row): ?>
          <tr>
            <td><?= Helpers::e($row['payment_method']) ?></td>
            <td><?= (int)$row['total_orders'] ?></td>
            <td><?= Helpers::formatCurrency((float)$row['total_amount']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>

  <section class="card" style="margin-top:2rem;">
    <h3>En Çok Satan Ürünler</h3>
    <table class="table">
      <thead><tr><th>Ürün</th><th>Satış</th><th>Fiyat</th></tr></thead>
      <tbody>
        <?php foreach ($topProducts as $product): ?>
          <tr>
            <td><?= Helpers::e($product['name']) ?></td>
            <td><?= (int)$product['total_qty'] ?></td>
            <td><?= Helpers::formatCurrency((float)($product['min_price'] ?? 0)) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
