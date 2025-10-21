<?php
use Core\Helpers;
$title = 'Kullanıcı Yönetimi';
ob_start();
?>
<section class="card">
  <header class="card-title">
    <div>
      <h2>Kullanıcılar</h2>
      <p class="subtitle">Müşteri ve yönetici hesaplarını yönetin.</p>
    </div>
  </header>
  <form class="filter-bar" method="get" action="<?= Helpers::baseUrl('admin/users') ?>">
    <input type="search" name="q" placeholder="E-posta veya ad" value="<?= Helpers::e($filters['search']) ?>">
    <select name="role">
      <option value="">Rol</option>
      <option value="user" <?= $filters['role'] === 'user' ? 'selected' : '' ?>>Müşteri</option>
      <option value="admin" <?= $filters['role'] === 'admin' ? 'selected' : '' ?>>Yönetici</option>
    </select>
    <button class="btn-muted" type="submit">Filtrele</button>
  </form>
  <table class="table">
    <thead>
      <tr><th>#</th><th>E-posta</th><th>Ad Soyad</th><th>Rol</th><th>Kayıt</th><th></th></tr>
    </thead>
    <tbody>
      <?php foreach ($users as $user): ?>
        <tr>
          <td>#<?= (int)$user['id'] ?></td>
          <td><?= Helpers::e($user['email']) ?></td>
          <td><?= Helpers::e($user['name']) ?></td>
          <td>
            <form class="form-inline" method="post" action="<?= Helpers::baseUrl('admin/users/' . $user['id'] . '/role') ?>">
              <?= Helpers::csrfField() ?>
              <select name="role">
                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Müşteri</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Yönetici</option>
              </select>
              <button type="submit" class="btn-muted">Kaydet</button>
            </form>
          </td>
          <td><?= Helpers::e(date('d.m.Y H:i', strtotime($user['created_at']))) ?></td>
          <td>
            <form method="post" action="<?= Helpers::baseUrl('admin/users/' . $user['id'] . '/reset-2fa') ?>">
              <?= Helpers::csrfField() ?>
              <button type="submit" class="btn-danger">2FA Sıfırla</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="pagination">
    <?php for ($i = 1; $i <= $pagination['pages']; $i++): ?>
      <a class="page <?= $pagination['current'] === $i ? 'active' : '' ?>" href="<?= Helpers::baseUrl('admin/users?page=' . $i . '&q=' . urlencode($filters['search']) . '&role=' . urlencode($filters['role'])) ?>"><?= $i ?></a>
    <?php endfor; ?>
  </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
