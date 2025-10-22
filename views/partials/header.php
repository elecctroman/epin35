<?php
$navCategories = \Core\Helpers::navCategories();
$trendingTags = ['Valorant VP', 'PUBG UC', 'Steam Cüzdan', 'Xbox Game Pass'];
?>
<header class="site-header">
  <div class="top-bar">
    <div class="container top-bar-inner">
      <div class="top-bar-broadcast">
        <span class="live-pill">Canlı</span>
        <span>30 sn içinde dijital kod teslimatı • 7/24 fraud koruması aktif</span>
      </div>
      <div class="top-bar-tags" aria-label="Trend aramalar">
        <?php foreach ($trendingTags as $tag): ?>
          <a class="tag" href="<?= \Core\Helpers::baseUrl('search?q=' . urlencode($tag)) ?>">#<?= \Core\Helpers::e($tag) ?></a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <div class="container navbar">
    <a href="<?= \Core\Helpers::baseUrl('/') ?>" class="brand" aria-label="MaxiStore ana sayfa">
      <span class="brand-logo">M</span>
      <div class="brand-text">
        <span>MaxiStore</span>
        <small>Dijital Kod &amp; Lisans Marketi</small>
      </div>
    </a>
    <form action="<?= \Core\Helpers::baseUrl('search') ?>" method="get" class="search-box" role="search">
      <svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-search') ?>"></use></svg>
      <input type="search" name="q" placeholder="Valorant VP, Windows 11, Netflix Gift..." value="<?= \Core\Helpers::e($query ?? '') ?>" aria-label="Ürün ara">
      <div class="search-hints">
        <span>Popüler:</span>
        <?php foreach (array_slice($trendingTags, 0, 3) as $tag): ?>
          <button type="button" class="chip" data-search-fill="<?= \Core\Helpers::e($tag) ?>"><?= \Core\Helpers::e($tag) ?></button>
        <?php endforeach; ?>
      </div>
    </form>
    <button class="menu-toggle" type="button" data-menu-toggle aria-controls="primary-menu" aria-expanded="false">
      <span class="menu-line"></span>
      <span class="menu-line"></span>
      <span class="menu-line"></span>
    </button>
    <nav class="nav-actions" aria-label="Hızlı bağlantılar">
      <a class="nav-button" href="<?= \Core\Helpers::baseUrl('support') ?>"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-support') ?>"></use></svg><span>Destek</span></a>
      <a class="nav-button" href="<?= \Core\Helpers::baseUrl('account') ?>"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-user') ?>"></use></svg><span>Hesabım</span></a>
      <a class="nav-button" href="<?= \Core\Helpers::baseUrl('cart') ?>"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-cart') ?>"></use></svg><span>Sepet</span></a>
    </nav>
  </div>
  <div class="nav-menu" id="primary-menu" data-mobile-menu>
    <div class="container nav-menu-inner">
      <ul class="nav-menu-list">
        <?php foreach ($navCategories as $category): ?>
          <li>
            <a href="<?= \Core\Helpers::baseUrl('kategori/' . $category['slug']) ?>">
              <span class="icon-pill">
                <svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-lightning') ?>"></use></svg>
              </span>
              <span><?= \Core\Helpers::e($category['name']) ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
      <div class="nav-meta">
        <div class="nav-meta-card">
          <h4>Profesyonel Operasyon</h4>
          <p>Fraud taraması, stok otomasyonu ve satıcı doğrulaması ile güvende kalın.</p>
        </div>
        <div class="nav-meta-card">
          <h4>Kurumsal Çözümler</h4>
          <p>Toplu lisans teklifleri için <a href="mailto:sales@maxistore.com">sales@maxistore.com</a>.</p>
        </div>
      </div>
    </div>
  </div>
</header>
