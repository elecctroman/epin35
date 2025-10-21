<?php
$title = 'Kullanıcılar';
ob_start();
?>
<section class="card">
  <h1>Kullanıcı Yönetimi</h1>
  <table class="table">
    <thead><tr><th>#</th><th>E-posta</th><th>Adı</th><th>Rol</th><th>Katılma</th></tr></thead>
    <tbody>
      <?php foreach ($users as $user): ?>
        <tr>
          <td><?= (int)$user['id'] ?></td>
          <td><?= \Core\Helpers::e($user['email']) ?></td>
          <td><?= \Core\Helpers::e($user['name']) ?></td>
          <td><?= \Core\Helpers::e($user['role']) ?></td>
          <td><?= \Core\Helpers::e($user['created_at']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
