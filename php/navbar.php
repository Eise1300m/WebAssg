<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$login = isset($_SESSION['user_name']);
?>

<div class="navbar">

    <a href="index.php" class="logo-link">
        <div class="logo-container">
            <img src="../img/Logo.png" alt="Logo">
            <p>Secret Shelf</p>
        </div>
    </a>

    <div class="search-container">
        <input type="text" class="searchbar" placeholder="Search..." id="searchInput">
        <button id="searchButton" class="search-btn">
            <img src="../upload/icon/search.png" alt="Search" class="search-icon">
        </button>
    </div>

    <div class="nav-container">
        <nav class="navtittle">
            <a href="#Edu">Contact Us</a>
            <a href="#Edu">Promo</a>
            <a href="#Edu">Help</a>
        </nav>

        <?php if ($login): ?>
            <div class="user-actions">
                <a href="Cart.php" class="cart-btn">
                    <img src="../upload/icon/shoppingcart.png" alt="Cart" class="cart-icon">
                    <span class="cart-count"><?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span>
                </a> 
                <?php include 'ProfileMenu.php'; ?>
            </div>
        <?php else: ?>
            <a href="UserLogin.php" class="Login-Btn">Login / Sign up</a>
        <?php endif; ?>
    </div>
</div>