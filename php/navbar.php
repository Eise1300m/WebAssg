<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$login = isset($_SESSION['user_name']);
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
?>


<div class="navbar">

    <a href="<?php echo $isAdmin ? 'AdminMainPage.php' : 'index.php'; ?>" class="logo-link">
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

        <?php if (!$isAdmin): // Only show navigation links for customers ?>
        <nav class="navtittle">
            <a href="#Edu">Contact Us</a>
            <a href="#Edu">Promo</a>
            <a href="#Edu">Help</a>
        </nav>
        <?php endif; ?>

        <?php if ($login): ?>
            <div class="user-actions">
                <?php if (!$isAdmin): // Show cart only for regular users ?>
                    <a href="Cart.php" class="cart-btn">
                        <img src="../upload/icon/shoppingcart.png" alt="Cart" class="cart-icon">
                        <span class="cart-count"><?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span>
                    </a> 
                <?php endif; ?>

                <?php include 'ProfileMenu.php'; ?>
                <script src="../js/Scripts.js"></script>

            </div>
        <?php else: ?>
            <a href="UserLogin.php" class="Login-Btn">Login / Sign up</a>
        <?php endif; ?>



    </div>

</div>