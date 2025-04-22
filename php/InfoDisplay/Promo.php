<?php
require_once("../base.php");
includeNavbar();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotions - Secret Shelf</title>
    <link rel="stylesheet" href="/WebAssg/css/NavbarStyles.css">
    <link rel="stylesheet" href="/WebAssg/css/FooterStyles.css">
    <link rel="stylesheet" href="/WebAssg/css/InfoDisplayStyles.css">
    <link rel="icon" type="image/x-icon" href="/WebAssg/img/Logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/WebAssg/js/Scripts.js"></script>
    
</head>
<body>
    <div class="info-container">
        <div class="info-header">
            <h1>Special Offer</h1>
            <p>Exclusive discounts for Secret Shelf customers</p>
        </div>

        <div class="info-section">
            <div class="promo-banner">
                <h3>First-Time Customer Special</h3>
                <p>As a token of appreciation for choosing Secret Shelf, all first-time customers receive:</p>
                <span class="discount-highlight">20% OFF</span>
                <p>Your first order will automatically receive this discount at checkout - no promo code needed!</p>
            </div>
        </div>

        <div class="info-section">
            <h2>Membership Benefits</h2>
            <p>To be coming soon</p>
            
        </div>

        <a href="/WebAssg/php/index.php" class="back-link">Back to Homepage</a>
    </div>

    <?php includeFooter(); ?>
</body>
</html>
