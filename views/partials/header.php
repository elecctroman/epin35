<header class="site-header">
  <div class="container navbar">
    <a href="<?= \Core\Helpers::baseUrl('/') ?>" class="brand" aria-label="MaxiStore ana sayfa">
      <span class="brand-logo">M</span>
      <span>MaxiStore</span>
    </a>
    <form action="<?= \Core\Helpers::baseUrl('search') ?>" method="get" class="search-box" role="search">
      <svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-search') ?>"></use></svg>
      <input type="search" name="q" placeholder="Aradığınız dijital ürünü bulun" value="<?= \Core\Helpers::e($query ?? '') ?>" aria-label="Ürün ara">
    </form>
    <nav class="nav-actions" aria-label="Hızlı bağlantılar">
      <a class="nav-button" href="<?= \Core\Helpers::baseUrl('support') ?>"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-support') ?>"></use></svg><span>Destek</span></a>
      <a class="nav-button" href="<?= \Core\Helpers::baseUrl('account') ?>"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-user') ?>"></use></svg><span>Hesabım</span></a>
      <a class="nav-button" href="<?= \Core\Helpers::baseUrl('cart') ?>"><svg aria-hidden="true"><use href="<?= \Core\Helpers::asset('svg/icons.svg#icon-cart') ?>"></use></svg><span>Sepet</span></a>
    </nav>
  </div>
</header>
