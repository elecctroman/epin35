<?php
use Core\Helpers;
$title = 'Destek Talepleri';
ob_start();
?>
<section class="card">
  <header class="card-title">
    <div>
      <h2>Destek Talepleri</h2>
      <p class="subtitle">Sipariş bazlı müşteri destek akışını yönetin.</p>
    </div>
  </header>
  <form class="filter-bar" method="get" action="<?= Helpers::baseUrl('admin/tickets') ?>">
    <input type="search" name="q" placeholder="Konu veya e-posta" value="<?= Helpers::e($filters['search']) ?>">
    <select name="status">
      <option value="">Durum</option>
      <option value="open" <?= $filters['status'] === 'open' ? 'selected' : '' ?>>Açık</option>
      <option value="answered" <?= $filters['status'] === 'answered' ? 'selected' : '' ?>>Yanıtlandı</option>
      <option value="closed" <?= $filters['status'] === 'closed' ? 'selected' : '' ?>>Kapalı</option>
    </select>
    <button class="btn-muted" type="submit">Filtrele</button>
  </form>
  <table class="table">
    <thead>
      <tr><th>#</th><th>Konu</th><th>Müşteri</th><th>Durum</th><th>Tarih</th><th></th></tr>
    </thead>
    <tbody>
      <?php foreach ($tickets as $ticket): ?>
        <tr>
          <td>#<?= (int)$ticket['id'] ?></td>
          <td><?= Helpers::e($ticket['subject']) ?></td>
          <td><?= Helpers::e($ticket['email'] ?? '-') ?></td>
          <td><span class="status-pill status-<?= Helpers::e($ticket['status']) ?>"><?= Helpers::e($ticket['status']) ?></span></td>
          <td><?= Helpers::e(date('d.m.Y H:i', strtotime($ticket['created_at']))) ?></td>
          <td><a class="btn-muted" href="<?= Helpers::baseUrl('admin/tickets/' . $ticket['id']) ?>">Görüntüle</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="pagination">
    <?php for ($i = 1; $i <= $pagination['pages']; $i++): ?>
      <a class="page <?= $pagination['current'] === $i ? 'active' : '' ?>" href="<?= Helpers::baseUrl('admin/tickets?page=' . $i . '&q=' . urlencode($filters['search']) . '&status=' . urlencode($filters['status'])) ?>"><?= $i ?></a>
    <?php endfor; ?>
  </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
