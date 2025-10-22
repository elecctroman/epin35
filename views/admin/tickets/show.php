<?php
use Core\Helpers;
$title = 'Destek Talebi';
ob_start();
?>
<section class="card">
  <header class="card-title">
    <div>
      <h2><?= Helpers::e($ticket['subject']) ?></h2>
      <p class="subtitle">Talep #<?= (int)$ticket['id'] ?> • <?= Helpers::e($ticket['email'] ?? '-') ?></p>
    </div>
    <a class="btn-muted" href="<?= Helpers::baseUrl('admin/tickets') ?>">Listeye Dön</a>
  </header>
  <div class="ticket-messages">
    <?php foreach ($ticket['messages'] as $message): ?>
      <article class="ticket-message">
        <header>
          <strong><?= Helpers::e($message['email'] ?? 'Destek Ekibi') ?></strong>
          <time><?= Helpers::e(date('d.m.Y H:i', strtotime($message['created_at']))) ?></time>
        </header>
        <p><?= nl2br(Helpers::e($message['body'])) ?></p>
      </article>
    <?php endforeach; ?>
  </div>
  <form class="form-grid" action="<?= Helpers::baseUrl('admin/tickets/' . $ticket['id'] . '/reply') ?>" method="post">
    <?= Helpers::csrfField() ?>
    <div class="form-field form-field-full">
      <label>Yanıtınız</label>
      <textarea name="body" rows="4" required></textarea>
    </div>
    <div class="form-field">
      <label>Durum</label>
      <select name="status">
        <option value="open" <?= $ticket['status'] === 'open' ? 'selected' : '' ?>>Açık</option>
        <option value="answered" <?= $ticket['status'] === 'answered' ? 'selected' : '' ?>>Yanıtlandı</option>
        <option value="closed" <?= $ticket['status'] === 'closed' ? 'selected' : '' ?>>Kapalı</option>
      </select>
    </div>
    <button class="btn-primary" type="submit">Yanıt Gönder</button>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
