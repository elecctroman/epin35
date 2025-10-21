<?php
$activePage = $activePage ?? '';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaxiStore - Dijital Mağaza</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script defer src="assets/js/app.js"></script>
</head>
<body>
    <header class="topbar">
        <div class="container">
            <div class="topbar__left">
                <span class="badge badge--success">7/24</span>
                <span class="topbar__text">Hızlı Teslimat &amp; Güvenli Ödeme</span>
            </div>
            <div class="topbar__right">
                <a href="mailto:destek@maxistore.com" class="topbar__link">destek@maxistore.com</a>
                <span class="divider"></span>
                <a href="tel:+908508808888" class="topbar__link">0 (850) 880 88 88</a>
            </div>
        </div>
    </header>
    <nav class="navbar">
        <div class="container navbar__inner">
            <a href="index.php" class="brand">
                <img src="assets/brand/logo.svg" alt="MaxiStore" class="brand__logo" />
                <span class="brand__name">MaxiStore</span>
            </a>
            <div class="navbar__search">
                <form action="search.php" method="get" class="search-form">
                    <input type="text" name="q" placeholder="Oyun, yazılım veya ürün ara" class="search-form__input">
                    <button class="search-form__button" type="submit">Ara</button>
                </form>
                <div class="search-tags">
                    <a href="#" class="search-tag">PUBG</a>
                    <a href="#" class="search-tag">Valorant</a>
                    <a href="#" class="search-tag">Adobe</a>
                    <a href="#" class="search-tag">Microsoft</a>
                </div>
            </div>
            <div class="navbar__actions">
                <a href="account.php" class="nav-link<?= $activePage === 'account' ? ' is-active' : '' ?>">Hesabım</a>
                <a href="support.php" class="nav-link<?= $activePage === 'support' ? ' is-active' : '' ?>">Destek</a>
                <a href="cart.php" class="nav-button">Sepetim</a>
            </div>
        </div>
        <div class="navbar__menu">
            <div class="container menu__inner">
                <a class="menu__link" href="#">PUBG</a>
                <a class="menu__link" href="#">Valorant</a>
                <a class="menu__link" href="#">Windows</a>
                <a class="menu__link" href="#">Steam</a>
                <a class="menu__link" href="#">Adobe</a>
                <a class="menu__link" href="#">Office</a>
                <a class="menu__link" href="#">Netflix</a>
                <a class="menu__link" href="#">Diğer</a>
            </div>
        </div>
    </nav>
    <main class="page">
        <div class="container">
