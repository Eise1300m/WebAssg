<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$login = isset($_SESSION['user_name']);

if(isAdmin()){
    header("Location: /WebAssg/php/Admin/AdminMainPage.php");
    exit();
}

?>

<div class="navbar">

    <a href="/WebAssg/php/index.php" class="logo-link">
        <div class="logo-container">
            <img src="/WebAssg/img/Logo.png" alt="Logo">
            <p>Secret Shelf</p>
        </div>
    </a>

    <div class="search-container">
        <input type="text" class="searchbar" placeholder="Search..." id="searchInput">
        <button id="searchButton" class="search-btn">
            <img src="/WebAssg/upload/icon/search.png" alt="Search" class="search-icon">
        </button>
    </div>

    <div class="nav-container">
        <nav class="navtittle">
            <a href="/WebAssg/php/InfoDisplay/ContactUs.php">Contact Us</a>
            <a href="/WebAssg/php/InfoDisplay/Promo.php">Promo</a>
            <a href="/WebAssg/php/InfoDisplay/Help.php">Help</a>
        </nav>

        <?php if ($login): ?>
            <div class="user-actions">
                <a href="/WebAssg/php/Order/Cart.php" class="cart-btn">
                    <img src="/WebAssg/upload/icon/shoppingcart.png" alt="Cart" class="cart-icon">
                    <span class="cart-count"><?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span>
                </a> 
                <?php 
                // Include ProfileMenu.php with absolute path
                include_once ('ProfileMenu.php');
                ?>
            </div>
        <?php else: ?>
            <a href="/WebAssg/php/Authentication/UserLogin.php" class="Login-Btn">Login / Sign up</a>    
        <?php endif; ?>
    </div>
</div>