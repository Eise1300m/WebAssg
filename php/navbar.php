<?php session_start();
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
            <i class="fa fa-search" aria-hidden="true"></i>
        </button>

    </div>

    <div class="nav-container">

        <nav class="navtittle">
            <a href="#Edu">Contact Us</a>
            <a href="#Edu">Promo</a>
            <a href="#Edu">Help</a>
        </nav>

        <?php if ($login) {
        ?>
            <div class="user-actions">
                <a href="cart.php" class="cart-btn">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                        <span class="cart-count"><?= count($_SESSION['cart']) ?></span>
                    <?php endif; ?>
                </a>

                <?php include 'ProfileMenu.php'; ?>
                <script src="../js/Scripts.js" ></script>

            </div>
        <?php
        } else {
        ?>
            <a href="CustomerLogin.php" class="Login-Btn">Login / Sign up</a>
        <?php
        }
        ?>



    </div>

</div>