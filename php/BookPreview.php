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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../css/BookPreviewStyle.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <script src="../js/order.js"></script>
    <script src="../js/Scripts.js"></script>


</head>

<?php include_once("navbar.php") ?>

<body>


    <!-- Back button -->
    <button class="back-button" onclick="history.back()">← BACK</button>

    <div class="wrap-container">

        <!-- Book details container -->
        <div class="book-container">

            <div class="inner-position">

                <div class="book-image">
                    <?php if (!empty($book['BookImage'])): ?>
                        <img src="<?php echo $book['BookImage']; ?>" alt="Book cover" style="width: 260px; height: 400px; object-fit: cover; ">
                    <?php endif; ?>
                </div>

                <div class="book-details">
                    <div class="book-info">
                        <div>Book Name: <?php echo $book['BookName']; ?></div>
                        <div>Author: <?php echo $book['Author']; ?></div>
                        <div>Price: RM <?php echo number_format($book['BookPrice'], 2); ?></div>
                    </div>

                    <div class="description-section">
                        <div class="description-tab">Description</div>
                        <div class="description-content">
                            <?php echo $book['Description']; ?>
                        </div>
                    </div>

                    <div class="controls-wrapper">
                        <div class="controls-container">
                            <div class="quantity-control">
                                <button class="quantity-button" onclick="decrementQuantity()">-</button>
                                <input type="text" id="quantity" class="quantity-input" value="1" readonly>
                                <button class="quantity-button" onclick="incrementQuantity()">+</button>
                            </div>
                            <button class="add-to-cart" onclick="addToCart(<?php echo $book_id; ?>)">
                                <i class="fas fa-shopping-cart" style="margin-right: 5px;"></i> Add to Cart
                            </button>

                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</body>

<?php include_once('footer.php') ?>

</html>