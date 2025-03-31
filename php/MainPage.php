<?php
require_once("base.php");

// Get filters from URL parameters
$filters = [
    'search' => get('search'),
    'category' => get('category'),
    'subcategory' => get('subcategory')
];

try {
    // Get books using the utility function
    $books = get_books($filters);
    
    // Set page title
    if (!empty($filters['search'])) {
        $_title = "Search Results for '" . encode($filters['search']) . "' - Secret Shelf";
    } else if ($filters['category'] && $filters['subcategory']) {
        $_title = encode($filters['subcategory'] . ' ' . $filters['category']) . " Books - Secret Shelf";
    } else if ($filters['category']) {
        $_title = encode($filters['category']) . " Books - Secret Shelf";
    } else {
        $_title = "All Books - Secret Shelf";
    }
    
} catch (PDOException $e) {
    add_err('db', "Error fetching books: " . $e->getMessage());
    $books = [];
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/MainPage.css" rel="stylesheet">
    <title><?= $_title ?></title>
    <link href="../css/NavbarStyles.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/Dropdown.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">




</head>

<?php include_once("navbar.php") ?>
<?php include_once("DropDownNav.php") ?>

<body>

    <div class="wrapbox">
        <div class="page-header">
            <h1><?= $_title ?></h1>
            <?php if (empty($books)): ?>
                <p class="no-results">No books found in this category. Please try another category.</p>
            <?php else: ?>
                <p class="results-count">Showing <?= count($books) ?> books</p>
            <?php endif; ?>
        </div>
        
        <div class="book-container">
            <?php foreach ($books as $book): ?>
                <div class="book-card">
                    <div class="book-image">
                        <a href="BookPreview.php?book_id=<?= encode($book['BookNo']) ?>">
                            <img src="<?= !empty($book['BookImage']) ? encode($book['BookImage']) : '../upload/bookPfp/BookCoverUnavailable.webp' ?>" 
                                 alt="<?= encode($book['BookName']) ?>">
                        </a>
                    </div>
                    <div class="book-details">
                        <h3 class="book-title" title="<?= encode($book['BookName']) ?>">
                            <?= encode($book['BookName']) ?>
                        </h3>
                        <p class="book-author" title="<?= encode($book['Author']) ?>">
                            <strong>Author:</strong> <?= encode($book['Author']) ?>
                        </p>
                        <p class="book-price">
                            <strong>Price:</strong> <?= format_price($book['BookPrice']) ?>
                        </p>
                        
                        <?php if (isset($_SESSION['user_name'])): ?>
                            <button class="cart-but" data-book-id="<?= encode($book['BookNo']) ?>">
                                <img src="../upload/icon/shoppingcart.png" alt="Cart">
                                Add to Cart
                            </button>
                        <?php else: ?>
                            <button class="cart-but" onclick="window.location.href='UserLogin.php'">
                                <img src="../upload/icon/shoppingcart.png" alt="Cart">
                                Login to Add
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <script src="../js/order.js"></script>
    <script src="../js/Scripts.js"></script>

</body>

</html>