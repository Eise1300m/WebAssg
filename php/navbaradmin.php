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


    <div class="nav-container">
        <?php require_once 'AdminProfileMenu.php'; ?>
    </div>
</div>