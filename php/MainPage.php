<?php
require_once("base.php");
require_once("../lib/BookHelper.php");

// Initialize BookHelper with database connection
BookHelper::init($_db);

// Get filter parameters
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : 'all';
$subcategoryFilter = isset($_GET['subcategory']) ? $_GET['subcategory'] : 'all';
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

// Prepare filters for BookHelper
$filters = [];
if ($categoryFilter !== 'all') {
    $filters['category'] = $categoryFilter;
}
if ($subcategoryFilter !== 'all') {
    $filters['subcategory'] = $subcategoryFilter;
}
if (!empty($searchQuery)) {
    $filters['search'] = $searchQuery;
}

// Get book 
$books = BookHelper::getBooks($filters);

// Get categories 
$categories = BookHelper::getCategories();

// Get subcategories 
$subcategories = [];
if ($categoryFilter !== 'all') {
    $subcategories = BookHelper::getSubcategories($categoryFilter);
}

// Include navbar
includeNavbar();
includeDropDownNav();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secret Shelf - Book Store</title>
    <link rel="stylesheet" href="../css/MainPage.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/Dropdown.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/order.js"></script>
    <script src="../js/Scripts.js"></script>

</head>

<body>
    <div class="wrapbox">
        <div class="page-header">
            <h1>
                <?php if ($categoryFilter === 'all'): ?>
                    All Books
                <?php else: ?>
                    <?php echo htmlspecialchars($categoryFilter); ?>
                    <?php if ($subcategoryFilter !== 'all'): ?>
                         - <?php echo htmlspecialchars($subcategoryFilter); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </h1>
            
            <?php if (!empty($searchQuery)): ?>
                <p class="filter-info">Search results for: "<?php echo htmlspecialchars($searchQuery); ?>"</p><br>
            <?php endif; ?>
            
            
            
            <?php if (empty($books)): ?>
                <p class="no-results">No books found. Please try another</p>
            <?php else: ?>
                <p class="results-count">Showing <?php echo count($books); ?> books</p>
            <?php endif; ?>
        </div>

        <div class="book-container">
            <?php foreach ($books as $book): ?>
                <div class="book-card">
                    <div class="book-image">
                        <a href="/WebAssg/php/ManageBook/BookPreview.php?book_id=<?php echo $book['BookNo']; ?>">
                            <img src="<?php echo BookHelper::getBookImage($book); ?>"
                                alt="<?php echo htmlspecialchars($book['BookName']); ?>">
                        </a>
                    </div>
                    <div class="book-details">
                        <h3 class="book-title" title="<?php echo htmlspecialchars($book['BookName']); ?>">
                            <?php echo htmlspecialchars($book['BookName']); ?>
                        </h3>
                        <p class="book-author" title="<?php echo htmlspecialchars($book['Author']); ?>">
                            <strong>Author:</strong> <?php echo htmlspecialchars($book['Author']); ?>
                        </p>
                        <p class="book-price">
                            <strong>Price:</strong> <?php echo BookHelper::formatPrice($book['BookPrice']); ?>
                        </p>

                        <?php if (isset($_SESSION['user_name'])): ?>
                            <button class="cart-but" data-book-id="<?php echo $book['BookNo']; ?>">
                                <img src="/WebAssg/upload/icon/shoppingcart.png" alt="Cart">
                                Add to Cart
                            </button>
                        <?php else: ?>
                            <button class="cart-but redirect-button" data-redirect-url="/WebAssg/php/Authentication/UserLogin.php">
                                <img src="/WebAssg/upload/icon/shoppingcart.png" alt="Cart">
                                Login to Add
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php includeFooter(); ?>
</body>

</html>