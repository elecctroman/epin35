<?php
$title = 'Destek Merkezi - MaxiStore';
$breadcrumb = [
  ['label' => 'Ana Sayfa', 'url' => \Core\Helpers::baseUrl('/')],
  ['label' => 'Destek']
];
ob_start();
?>
<section class="card" style="display:grid;gap:2rem;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));">
  <div>
    <h1>Destek Talebi Oluştur</h1>
    <p style="color:var(--text-dim);">Siparişiniz ile ilgili sorularınız varsa hemen iletin, destek ekibimiz dakikalar içinde dönüş yapsın.</p>
    <form action="<?= \Core\Helpers::baseUrl('support') ?>" method="post">
      <?= \Core\Helpers::csrfField() ?>
      <div class="form-group">
        <label for="order_id">Sipariş Seç</label>
        <select class="form-control" id="order_id" name="order_id">
          <option value="">Sipariş numarası seçin</option>
          <?php foreach ($orders as $order): ?>
            <option value="<?= (int)$order['id'] ?>">#<?= (int)$order['id'] ?> - ₺<?= number_format($order['total'], 2) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="subject">Konu</label>
        <input class="form-control" type="text" id="subject" name="subject" required>
      </div>
      <div class="form-group">
        <label for="message">Mesajınız</label>
        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
      </div>
      <button class="btn-primary" type="submit">Talep Oluştur</button>
    </form>
  </div>
  <aside class="card" style="background:linear-gradient(150deg, rgba(59,130,246,0.22), transparent), var(--surface);">
    <h2>Yardım Merkezi</h2>
    <ul style="list-style:none;padding:0;margin:0;">
      <li style="padding:0.6rem 0;">• Kod teslimatı nasıl gerçekleşir?</li>
      <li style="padding:0.6rem 0;">• Mock ödeme onayı ne kadar sürer?</li>
      <li style="padding:0.6rem 0;">• İade süreçlerinde dikkat edilmesi gerekenler?</li>
    </ul>
  </aside>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
