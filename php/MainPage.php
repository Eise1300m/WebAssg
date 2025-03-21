<?php
require_once("connection.php");

// Get category and subcategory from URL parameters
$category = isset($_GET['category']) ? $_GET['category'] : null;
$subcategory = isset($_GET['subcategory']) ? $_GET['subcategory'] : null;

try {
    // Base query
    $query = "SELECT b.* 
              FROM book b
              JOIN subcategory s ON b.SubcategoryNo = s.SubcategoryNo
              JOIN category c ON s.CategoryNo = c.CategoryNo";
    
    // Add WHERE clauses if filters are present
    $params = [];
    $whereClause = [];
    
    if ($category) {
        $whereClause[] = "c.CategoryName = ?";
        $params[] = $category;
    }
    
    if ($subcategory) {
        $whereClause[] = "s.SubcategoryName = ?";
        $params[] = $subcategory;
    }
    
    // Combine where clauses if any exist
    if (!empty($whereClause)) {
        $query .= " WHERE " . implode(" AND ", $whereClause);
    }
    
    // Add an order clause
    $query .= " ORDER BY b.BookName ASC";
    
    // Prepare and execute query
    $stmt = $_db->prepare($query);
    $stmt->execute($params);
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get page title based on filters
    if ($category && $subcategory) {
        $_title = "$subcategory $category Books - Secret Shelf";
    } elseif ($category) {
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
                    <a href="BookPreview.php?book_id=<?php echo $book['BookNo']; ?>">
                        <img src="<?php echo !empty($book['BookImage']) ? $book['BookImage'] : '../upload/bookPfp/BookCoverUnavailable.webp'; ?>" alt="<?php echo htmlspecialchars($book['BookName']); ?>">
                    </a>
                    <h3><?php echo htmlspecialchars($book['BookName']); ?></h3>
                    <p><strong>Author:</strong> <?php echo htmlspecialchars($book['Author']); ?></p>
                    <p><strong>Price:</strong> RM <?php echo number_format($book['BookPrice'], 2); ?></p>
                    <button class="cart-but" data-book-id="<?php echo $book['BookNo']; ?>">Add to Cart</button>
                </div>
            <?php } ?>
        </div>

    </div>

    <script src="../js/order.js"></script>
    <script src="../js/Scripts.js"></script>

</body>

</html>