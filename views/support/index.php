<?php
$title = 'Destek Merkezi - MaxiStore';
$breadcrumb = [
  ['label' => 'Ana Sayfa', 'url' => \Core\Helpers::baseUrl('/')],
  ['label' => 'Destek']
];
ob_start();
?>
<section class="panel support">
  <header class="panel-header">
    <div>
      <h1>Destek Merkezi</h1>
      <p>MaxiStore operasyon ekibi, siparişleriniz ve lisans teslimatlarınız için 7/24 hazır.</p>
    </div>
    <div class="chip-row">
      <?php foreach ($supportShortcuts as $shortcut): ?>
        <a class="chip" href="<?= \Core\Helpers::e($shortcut['anchor']) ?>"><?= \Core\Helpers::e($shortcut['label']) ?></a>
      <?php endforeach; ?>
    </div>
  </header>
  <div class="support-grid">
    <section class="card">
      <h2>Destek Talebi Oluştur</h2>
      <p>Siparişiniz ile ilgili sorularınızı iletin, uzmanlarımız ortalama 10 dakikada yanıtlasın.</p>
      <form action="<?= \Core\Helpers::baseUrl('support') ?>" method="post">
        <?= \Core\Helpers::csrfField() ?>
        <div class="form-group">
          <label for="order_id">Sipariş Seç</label>
          <select class="form-control" id="order_id" name="order_id">
            <option value="">Sipariş numarası seçin</option>
            <?php foreach ($orders as $order): ?>
              <option value="<?= (int)$order['id'] ?>">#<?= (int)$order['id'] ?> - <?= \Core\Helpers::formatCurrency((float)$order['total']) ?></option>
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
    </section>
    <aside class="card support-status">
      <h2>Operasyon Durumu</h2>
      <ul>
        <?php foreach ($serviceStatus as $status): ?>
          <li>
            <strong><?= \Core\Helpers::e($status['label']) ?></strong>
            <span><?= \Core\Helpers::e($status['status']) ?></span>
            <p><?= \Core\Helpers::e($status['description']) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
    </aside>
  </div>
</section>

<section class="panel" id="delivery">
  <header class="panel-header">
    <div>
      <h2>Teslimat Süreci</h2>
      <p>Her siparişte uygulanan güvenlik ve teslimat adımlarını öğrenin.</p>
    </div>
  </header>
  <div class="timeline">
    <div class="timeline-step">
      <span class="icon-pill"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-lightning') ?>"></use></svg></span>
      <div>
        <strong>Ödeme Onayı</strong>
        <p>Mock driver’dan gelen referans FraudShield tarafından doğrulanır.</p>
      </div>
    </div>
    <div class="timeline-step">
      <span class="icon-pill"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-code') ?>"></use></svg></span>
      <div>
        <strong>Kod Dağıtımı</strong>
        <p>StockItem kasasındaki şifreler siparişinize kilitlenir ve lisans kasasına aktarılır.</p>
      </div>
    </div>
    <div class="timeline-step">
      <span class="icon-pill"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-support') ?>"></use></svg></span>
      <div>
        <strong>Destek</strong>
        <p>Talep açmanız halinde ortalama ilk yanıt süremiz 10 dakikadır.</p>
      </div>
    </div>
  </div>
</section>

<section class="panel" id="refund">
  <header class="panel-header">
    <div>
      <h2>İade Politikası</h2>
      <p>Kodlar tüketilmediyse 14 gün içinde iade talebinde bulunabilirsiniz.</p>
    </div>
  </header>
  <div class="policy">
    <ul>
      <li>Kod tüketilmemişse iade anında onaylanır.</li>
      <li>Satıcı onayı gereken durumlarda maksimum SLA 24 saattir.</li>
      <li>İade edilen kodlar tekrar stok kasasına taşınır.</li>
    </ul>
  </div>
</section>

<section class="panel" id="security">
  <header class="panel-header">
    <div>
      <h2>Güvenlik Önerileri</h2>
      <p>Hesabınızı ve lisanslarınızı korumak için öneriler.</p>
    </div>
  </header>
  <div class="policy">
    <ul>
      <li>İki adımlı doğrulamayı etkinleştirin.</li>
      <li>Lisans kodlarını yalnızca MaxiStore lisans kasasında saklayın.</li>
      <li>Şüpheli işlemlerde destek ekibine ekran görüntüsü ile ulaşın.</li>
    </ul>
  </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
