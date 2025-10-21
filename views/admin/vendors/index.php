<?php
$title = 'Satıcılar';
ob_start();
?>
<section class="card">
  <h1>Satıcı Performansı</h1>
  <table class="table">
    <thead><tr><th>Adı</th><th>Puan</th><th>Satış</th></tr></thead>
    <tbody>
      <?php foreach ($vendors as $vendor): ?>
        <tr>
          <td><?= \Core\Helpers::e($vendor['name']) ?></td>
          <td><?= number_format($vendor['rating'], 2) ?></td>
          <td><?= (int)$vendor['sales_count'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
