<?php
$title = 'Hesabım - MaxiStore';
$breadcrumb = [
  ['label' => 'Ana Sayfa', 'url' => \Core\Helpers::baseUrl('/')],
  ['label' => 'Hesabım']
];
ob_start();
?>
<section class="card" style="display:grid;gap:2rem;">
  <div>
    <h1>Hoş geldin, <?= \Core\Helpers::e($user['name'] ?: $user['email']) ?></h1>
    <p style="color:var(--text-dim);">İki adımlı doğrulama: <?= $user['twofa_secret'] ? 'Aktif' : 'Pasif' ?></p>
  </div>
  <div class="card">
    <h2>Son Siparişler</h2>
    <table class="table">
      <thead><tr><th>#</th><th>Durum</th><th>Tutar</th><th>Tarih</th></tr></thead>
      <tbody>
        <?php foreach ($orders as $order): ?>
          <tr>
            <td>#<?= (int)$order['id'] ?></td>
            <td><?= \Core\Helpers::e($order['status']) ?></td>
            <td>₺<?= number_format($order['total'], 2) ?></td>
            <td><?= \Core\Helpers::e($order['created_at']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="card">
    <h2>Destek Talepleri</h2>
    <ul style="list-style:none;padding:0;margin:0;">
      <?php foreach ($tickets as $ticket): ?>
        <li style="padding:0.6rem 0;border-bottom:1px solid rgba(255,255,255,0.04);">
          <strong><?= \Core\Helpers::e($ticket['subject']) ?></strong>
          <span style="display:block;color:var(--text-dim);">Durum: <?= \Core\Helpers::e($ticket['status']) ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div>
    <a class="btn-muted" href="<?= \Core\Helpers::baseUrl('logout') ?>">Çıkış Yap</a>
  </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
