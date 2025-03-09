<!-- Updated Navbar Code with Profile Button -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Navbar2Styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@100..900&display=swap" rel="stylesheet">
    
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
</head>

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
        
        <div class="user-actions">
            <a href="cart.php" class="cart-btn">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                <span class="cart-count">0</span>
            </a>

            <a href="profile.php" class="profile-btn">
                <i class="fa fa-user" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>
