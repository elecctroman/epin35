<?php
$title = 'Sepetiniz - MaxiStore';
$breadcrumb = [
  ['label' => 'Ana Sayfa', 'url' => \Core\Helpers::baseUrl('/')],
  ['label' => 'Sepet']
];
ob_start();
$total = array_sum(array_map(fn($item) => $item['qty'] * $item['unit_price'], $items));
?>
<section class="card">
  <h1>Sepetiniz</h1>
  <?php if (empty($items)): ?>
    <p>Sepetinizde ürün yok.</p>
    <a class="btn-primary" href="<?= \Core\Helpers::baseUrl('/') ?>">Alışverişe Başla</a>
  <?php else: ?>
    <table class="table" aria-describedby="cart-summary">
      <thead>
        <tr>
          <th>Ürün</th>
          <th>Varyant</th>
          <th>Adet</th>
          <th>Birim Fiyat</th>
          <th>Toplam</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $item): ?>
          <tr>
            <td><?= \Core\Helpers::e($item['product_name']) ?></td>
            <td><?= \Core\Helpers::e($item['variation_title']) ?></td>
            <td><?= (int)$item['qty'] ?></td>
            <td>₺<?= number_format($item['unit_price'], 2) ?></td>
            <td>₺<?= number_format($item['unit_price'] * $item['qty'], 2) ?></td>
            <td>
              <form action="<?= \Core\Helpers::baseUrl('cart/remove/' . $item['id']) ?>" method="post">
                <?= \Core\Helpers::csrfField() ?>
                <button class="btn-muted" type="submit">Kaldır</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div id="cart-summary" style="margin-top:1.5rem;display:flex;justify-content:space-between;align-items:center;">
      <strong>Genel Toplam: ₺<?= number_format($total, 2) ?></strong>
      <a class="btn-primary" href="<?= \Core\Helpers::baseUrl('checkout') ?>">Ödemeye Geç</a>
    </div>
  <?php endif; ?>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
