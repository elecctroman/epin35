<?php
$title = 'Raporlar';
ob_start();
?>
<section class="card">
  <h1>Satış Raporları</h1>
  <table class="table">
    <thead><tr><th>Gün</th><th>Toplam Satış</th></tr></thead>
    <tbody>
      <?php foreach ($salesDaily as $row): ?>
        <tr>
          <td><?= \Core\Helpers::e($row['day']) ?></td>
          <td>₺<?= number_format($row['total'], 2) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
