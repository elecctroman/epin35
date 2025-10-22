<?php
$title = 'Hesabım - MaxiStore';
$breadcrumb = [
  ['label' => 'Ana Sayfa', 'url' => \Core\Helpers::baseUrl('/')],
  ['label' => 'Hesabım']
];
ob_start();
?>
<section class="panel account">
  <header class="panel-header">
    <div>
      <h1>Merhaba, <?= \Core\Helpers::e($user['name'] ?: $user['email']) ?></h1>
      <p>Hesabınız için güvenlik, sipariş ve lisans detaylarını buradan yönetin.</p>
    </div>
    <a class="btn-muted" href="<?= \Core\Helpers::baseUrl('logout') ?>">Çıkış Yap</a>
  </header>
  <div class="account-grid">
    <section class="card">
      <h2>Son Siparişler</h2>
      <table class="table">
        <thead><tr><th>#</th><th>Durum</th><th>Tutar</th><th>Tarih</th></tr></thead>
        <tbody>
          <?php foreach ($orders as $order): ?>
            <tr>
              <td>#<?= (int)$order['id'] ?></td>
              <td><span class="status-pill status-<?= \Core\Helpers::e($order['status']) ?>"><?= \Core\Helpers::e($order['status']) ?></span></td>
              <td><?= \Core\Helpers::formatCurrency((float)$order['total']) ?></td>
              <td><?= \Core\Helpers::e(date('d.m.Y H:i', strtotime($order['created_at']))) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
    <section class="card">
      <h2>Lisans Kasası</h2>
      <?php if (empty($licenseVault)): ?>
        <p class="empty-state">Henüz teslim edilmiş bir lisansınız yok.</p>
      <?php else: ?>
        <ul class="vault-list">
          <?php foreach ($licenseVault as $item): $payload = json_decode($item['delivered_payload'] ?? '', true); $codes = $payload['codes'] ?? []; ?>
            <li>
              <div>
                <strong><?= \Core\Helpers::e($item['name']) ?> • <?= \Core\Helpers::e($item['title']) ?></strong>
                <small>#<?= (int)$item['order_id'] ?> • <?= \Core\Helpers::e(date('d.m.Y H:i', strtotime($item['created_at']))) ?></small>
              </div>
              <?php foreach ($codes as $code): ?>
                <div class="code-line">
                  <code><?= \Core\Helpers::e($code) ?></code>
                  <button type="button" class="btn-muted" data-copy="<?= \Core\Helpers::e($code) ?>">Kopyala</button>
                </div>
              <?php endforeach; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </section>
    <section class="card security-card">
      <h2>Güvenlik</h2>
      <p>İki adımlı doğrulama: <?= $user['twofa_secret'] ? 'Aktif' : 'Pasif' ?></p>
      <ul>
        <li>Hesap oturumları 30 dakikalık pasiflikte sonlandırılır.</li>
        <li>Şüpheli girişlerde fraud ekibine otomatik bildirim gider.</li>
      </ul>
      <a class="btn-muted" href="<?= \Core\Helpers::baseUrl('support') ?>">Güvenlik Destek Talebi Aç</a>
    </section>
    <section class="card">
      <h2>Destek Talepleri</h2>
      <ul class="ticket-feed">
        <?php foreach ($tickets as $ticket): ?>
          <li>
            <h4><?= \Core\Helpers::e($ticket['subject']) ?></h4>
            <span class="status-pill status-<?= \Core\Helpers::e($ticket['status']) ?>"><?= \Core\Helpers::e($ticket['status']) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </section>
  </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
