<?php
use Core\Helpers;
$title = 'Kategori Yönetimi';
ob_start();
?>
<section class="card">
  <header class="card-title">
    <div>
      <h2>Kategoriler</h2>
      <p class="subtitle">Mağaza navigasyonu ve filtre yapısını yönetin.</p>
    </div>
  </header>
  <div class="category-grid">
    <div>
      <h3>Hiyerarşi</h3>
      <ul class="category-tree">
        <?php
        $render = function ($items) use (&$render) {
            foreach ($items as $item) {
                echo '<li>'; // phpcs ignore
                echo '<div class="tree-row">';
                echo '<strong>' . Helpers::e($item['name']) . '</strong>'; // phpcs ignore
                echo '<span class="tree-meta">' . Helpers::e($item['slug']) . '</span>';
                echo '<div class="tree-actions">';
                echo '<a class="btn-muted" href="' . Helpers::baseUrl('admin/categories/' . $item['id'] . '/edit') . '">Düzenle</a>';
                echo '<form method="post" action="' . Helpers::baseUrl('admin/categories/' . $item['id'] . '/delete') . '" onsubmit="return confirm(\'Silmek istediğinize emin misiniz?\');">';
                echo Helpers::csrfField();
                echo '<button type="submit" class="btn-danger">Sil</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                if (!empty($item['children'])) {
                    echo '<ul>';
                    $render($item['children']);
                    echo '</ul>';
                }
                echo '</li>';
            }
        };
        $render($tree);
        ?>
      </ul>
    </div>
    <form class="form-grid" action="<?= Helpers::baseUrl('admin/categories') ?>" method="post">
      <?= Helpers::csrfField() ?>
      <h3>Yeni Kategori</h3>
      <div class="form-field">
        <label>Adı</label>
        <input type="text" name="name" required>
      </div>
      <div class="form-field">
        <label>Slug</label>
        <input type="text" name="slug" required>
      </div>
      <div class="form-field">
        <label>Üst Kategori</label>
        <select name="parent_id">
          <option value="">Yok</option>
          <?php foreach ($categories as $category): ?>
            <option value="<?= (int)$category['id'] ?>"><?= Helpers::e($category['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-field">
        <label>Sıra</label>
        <input type="number" name="sort" value="0">
      </div>
      <button class="btn-primary" type="submit">Kategori Oluştur</button>
    </form>
  </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
