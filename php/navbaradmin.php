<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
?>

<div class="navbar">

    <a href="AdminMainPage.php" class="logo-link">
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
        <?php include 'AdminProfileMenu.php'; ?>
    </div>
</div>