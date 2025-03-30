<?php
require_once("connection.php");

// Get category and subcategory from URL parameters
$category = isset($_GET['category']) ? $_GET['category'] : null;
$subcategory = isset($_GET['subcategory']) ? $_GET['subcategory'] : null;

// Update the search functionality
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

try {
    // Modify the base query to include search functionality
    $query = "SELECT b.* 
              FROM book b
              JOIN subcategory s ON b.SubcategoryNo = s.SubcategoryNo
              JOIN category c ON s.CategoryNo = c.CategoryNo
              WHERE 1=1";
    
    // Add search condition if search parameter exists
    if (!empty($searchQuery)) {
        $query .= " AND (b.BookName LIKE ?)";
        $params[] = "$searchQuery%";
    }
    
    // Add existing category/subcategory filters
    if ($category) {
        $query .= " AND c.CategoryName = ?";
        $params[] = $category;
    }
    
    if ($subcategory) {
        $query .= " AND s.SubcategoryName = ?";
        $params[] = $subcategory;
    }
    
    // Add the order clause
    $query .= " ORDER BY b.BookName ASC";
    
    // Prepare and execute query
    $stmt = $_db->prepare($query);
    $stmt->execute($params);
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Update the page title to include search term if present
    if (!empty($searchQuery)) {
        $_title = "Search Results for '$searchQuery' - Secret Shelf";
    } else if ($category && $subcategory) {
        $_title = "$subcategory $category Books - Secret Shelf";
    } else if ($category) {
        $_title = "$category Books - Secret Shelf";
    } else {
        $_title = "All Books - Secret Shelf";
    }
    
} catch (PDOException $e) {
    die("Error fetching books: " . $e->getMessage());
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
            <?php if (count($books) === 0): ?>
                <p class="no-results">No books found in this category. Please try another category.</p>
            <?php else: ?>
                <p class="results-count">Showing <?= count($books) ?> books</p>
            <?php endif; ?>
        </div>
        
        <div class="book-container">
            <?php foreach ($books as $book) { ?>
                <div class="book-card">
                    <div class="book-image">
                        <a href="BookPreview.php?book_id=<?php echo $book['BookNo']; ?>">
                            <img src="<?php echo !empty($book['BookImage']) ? $book['BookImage'] : '../upload/bookPfp/BookCoverUnavailable.webp'; ?>" alt="<?php echo htmlspecialchars($book['BookName']); ?>">
                        </a>
                    </div>
                    <div class="book-details">
                        <h3 class="book-title" title="<?php echo htmlspecialchars($book['BookName']); ?>"><?php echo htmlspecialchars($book['BookName']); ?></h3>
                        <p class="book-author" title="<?php echo htmlspecialchars($book['Author']); ?>"><strong>Author:</strong> <?php echo htmlspecialchars($book['Author']); ?></p>
                        <p class="book-price"><strong>Price:</strong> RM <?php echo number_format($book['BookPrice'], 2); ?></p>
                        
                        <?php if (isset($_SESSION['user_name'])): ?>
                            <button class="cart-but" data-book-id="<?php echo $book['BookNo']; ?>">
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
            <?php } ?>
        </div>

    </div>

    <script src="../js/order.js"></script>
    <script src="../js/Scripts.js"></script>

</body>

</html>