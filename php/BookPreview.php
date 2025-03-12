<?php
include 'connection.php'; // Ensure database connection is included

if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    // Fetch book details based on the book ID
    $query = "SELECT * FROM book WHERE BookNo = ?";
    $stmt = $_db->prepare($query);
    $stmt->execute([$book_id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        die("Book not found.");
    }
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $book['BookName']; ?> - Preview</title>
    <link rel="stylesheet" href="../css/BookPreviewStyle.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">


</head>

<?php include_once("navbar.php") ?>

<body>

    
    <!-- Back button -->
    <button class="back-button" onclick="history.back()">← BACK</button>
    
    <!-- Book details container -->
    <div class="book-container">
        <div class="book-image">
            <?php if (!empty($book['BookImage'])): ?>
                <img src="<?php echo $book['BookImage']; ?>" alt="Book cover" style="width: 100%; height: 100%; object-fit: cover; border-radius: 5px;">
            <?php endif; ?>
        </div>
        
        <div class="book-details">
            <div>Book Name: <?php echo $book['BookName']; ?></div>
            <div>Author: <?php echo $book['Author']; ?></div>
            <div>Price: $<?php echo number_format($book['BookPrice'], 2); ?></div>
            
            <div class="quantity-control">
                <button class="quantity-button" onclick="decrementQuantity()">-</button>
                <input type="text" id="quantity" class="quantity-input" value="1" readonly>
                <button class="quantity-button" onclick="incrementQuantity()">+</button>
            </div>
            
            <button class="add-to-cart" onclick="addToCart(<?php echo $book_id; ?>)">
                <span style="margin-right: 5px;">🛒</span> Add to cart
            </button>
        </div>
    </div>
    
    <!-- Description tab -->
    <div class="description-tab">Description</div>
    
    <!-- Description content -->
    <div class="description-content">
        <?php echo $book['Description']; ?>
    </div>
