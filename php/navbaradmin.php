<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

// Determine the base URL dynamically - still needed for PHP file paths
$basePath = '';
$isInSubdir = strpos($_SERVER['SCRIPT_NAME'], '/php/') !== false && 
             dirname($_SERVER['SCRIPT_NAME']) !== '/php';
if ($isInSubdir) {
    $basePath = '../';
}
?>

<div class="navbar">

    <a href="<?= $basePath ?>AdminMainPage.php" class="logo-link">
        <div class="logo-container">
            <img src="/WebAssg/img/Logo.png" alt="Logo">
            <p>Secret Shelf</p>
        </div>
    </a>


    <div class="nav-container">
        <?php 
        // Use an absolute path from the document root
        $profileMenuPath = dirname(__FILE__) . '/Admin/AdminProfileMenu.php';
        if (file_exists($profileMenuPath)) {
            require_once $profileMenuPath;
        } else {
            echo "<!-- Admin Profile menu not found -->";
        }
        ?>
    </div>
</div>