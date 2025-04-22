<?php
require_once("../base.php");
includeNavbar();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Secret Shelf</title>
    <link rel="stylesheet" href="/WebAssg/css/NavbarStyles.css">
    <link rel="stylesheet" href="/WebAssg/css/FooterStyles.css">
    <link rel="stylesheet" href="/WebAssg/css/InfoDisplayStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/WebAssg/js/Scripts.js"></script>

</head>
<body>
    <div class="info-container">
        <div class="info-header">
            <h1>Contact Us</h1>
            <p>We'd love to hear from you! Here's how you can reach Secret Shelf.</p>
        </div>

        <div class="info-section">
            <div class="contact-methods">
                <div class="contact-method">
                    <div class="contact-icon">📞</div>
                    <h3>Customer Service</h3>
                    <p>Tel: +603 1122 3344</p>
                    <p>Email: customer@secretshelf.my</p>
                    <p>Monday to Saturday: 9:00am to 6:00pm</p>
                    <p>(Lunch break: 1:00pm to 2:00pm)</p>
                    <p>Closed on Sunday & Public Holidays</p>
                </div>
                <div class="contact-method">
                    <div class="contact-icon">📍</div>
                    <h3>Physical Store</h3>
                    <p>Secret Shelf Bookstore</p>
                    <p>123 Jalan Bukit Bintang</p>
                    <p>Kuala Lumpur, 50200</p>
                    <p>Malaysia</p>
                    <p>Near Pavilion Shopping Mall</p>
                </div>
                <div class="contact-method">
                    <div class="contact-icon">💼</div>
                    <h3>Corporate Inquiries</h3>
                    <p>For bulk orders and corporate partnerships</p>
                    <p>Email: corporate@secretshelf.my</p>
                    <p>Tel: +603 1122 3345</p>
                    <p>Contact: Mr. Tan (Corporate Sales Manager)</p>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>Store Location</h2>
            <p>Our bookstore is conveniently located in the heart of Kuala Lumpur, within walking distance of major landmarks and public transportation options.</p>
            
            <div class="map-container">
                <!-- Placeholder for map -->
                <img src="/WebAssg/img/Maps.png" alt="Store Location Map" style="width: 100%; height: 100%; ">
            </div>
            
            <p><strong>Parking:</strong> Available at Pavilion Shopping Mall (paid)</p>
            <p><strong>Public Transport:</strong> Accessible via Bukit Bintang MRT station (5-minute walk)</p>
        </div>



        <a href="/WebAssg/php/index.php" class="back-link">Back to Homepage</a>
    </div>

    <?php includeFooter(); ?>
</body>
</html>
