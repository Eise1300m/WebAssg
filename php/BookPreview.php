<?php
require_once("base.php");

// Get book ID from URL
$bookId = isset($_GET['book_id']) ? (int)$_GET['book_id'] : 0;

// Fetch book details
$query = "SELECT * FROM book WHERE BookNo = ?";
$stmt = $_db->prepare($query);
$stmt->execute([$bookId]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    die("Book not found.");
}

// Fetch reviews for this book
$query = "
    SELECT r.*, u.Username 
    FROM reviews r 
    JOIN users u ON r.UserID = u.UserID 
    WHERE r.BookNo = ? 
    ORDER BY r.ReviewDate DESC
";
$stmt = $_db->prepare($query);
$stmt->execute([$bookId]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate average rating
$query = "
    SELECT AVG(Rating) as average_rating, COUNT(*) as review_count 
    FROM reviews 
    WHERE BookNo = ?
";
$stmt = $_db->prepare($query);
$stmt->execute([$bookId]);
$rating_data = $stmt->fetch(PDO::FETCH_ASSOC);
$average_rating = $rating_data['average_rating'] ? round($rating_data['average_rating'], 1) : 0;
$review_count = $rating_data['review_count'];

// Include navbar
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['BookName']); ?> - Preview</title>
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <link rel="stylesheet" href="../css/BookPreviewStyle.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link href="../css/NavbarStyles.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/Scripts.js"></script>
    <script src="../js/order.js"></script>
</head>

<body>
    <!-- Back button -->
    <button class="back-button" onclick="history.back()">
        <img src="../upload/icon/back.png" alt="Back"> Back
    </button>

    <div class="wrap-container">
        <!-- Book details container -->
        <div class="book-container">
            <div class="inner-position">
                <div class="book-image">
                    <?php if (!empty($book['BookImage'])): ?>
                        <img src="<?php echo $book['BookImage']; ?>" alt="Book cover">
                    <?php else: ?>
                        <img src="../upload/bookPfp/bookcoverunavailable.png" alt="Cover not available">
                    <?php endif; ?>
                </div>

                <div class="book-details">
                    <div class="book-info">
                        <div><?php echo htmlspecialchars($book['BookName']); ?></div>
                        <div>Author: <?php echo htmlspecialchars($book['Author']); ?></div>
                        <div>Price: RM <?php echo number_format($book['BookPrice'], 2); ?></div>

                        <!-- Rating Display -->
                        <?php if ($review_count > 0): ?>
                            <div class="book-rating">
                                <div class="stars">
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $average_rating) {
                                            echo '<img src="../upload/icon/star-filled.png" alt="Star" class="star-icon">';
                                        } else if ($i - 0.5 <= $average_rating) {
                                            echo '<img src="../upload/icon/star-half.png" alt="Half star" class="star-icon">';
                                        } else {
                                            echo '<img src="../upload/icon/star-empty.png" alt="Empty star" class="star-icon">';
                                        }
                                    }
                                    ?>
                                </div>
                                <span>(<?php echo $average_rating; ?>/5 from <?php echo $review_count; ?> reviews)</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="description-section">
                        <div class="description-tab">Description</div>
                        <div class="description-content">
                            <?php echo nl2br(htmlspecialchars($book['Description'])); ?>
                        </div>
                    </div>

                    <div class="controls-wrapper">
                        <div class="controls-container">
                            <div class="quantity-control">
                                <button type="button" class="quantity-button" onclick="decrementQuantity()">-</button>
                                <input type="text" id="quantity" class="quantity-input" value="1" readonly>
                                <button type="button" class="quantity-button" onclick="incrementQuantity()">+</button>
                            </div>
                            <button type="button" class="cart-but" data-book-id="<?php echo $book['BookNo']; ?>" data-quantity-id="quantity">
                                <img src="../upload/icon/shoppingcart.png" alt="Cart"> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="reviews-section">
            <div class="reviews-title">
                <h2>Customer Reviews</h2>
                <div class="rating-summary">
                    <?php if ($review_count > 0): ?>
                        <span class="average-rating"><?php echo $average_rating; ?></span>
                        <div class="stars">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $average_rating) {
                                    echo '<img src="../upload/icon/star-filled.png" alt="Star" class="star-icon">';
                                } else {
                                    echo '<img src="../upload/icon/star-empty.png" alt="Empty star" class="star-icon">';
                                }
                            }
                            ?>
                        </div>
                        <span class="review-count">(<?php echo $review_count; ?> reviews)</span>
                    <?php else: ?>
                        <span class="no-reviewsMsg">No reviews yet</span>
                    <?php endif; ?>
                </div>

                <?php if (isset($_SESSION['user_name'])): ?>
                    <button class="write-review-btn" onclick="location.href='WriteReview.php?book_id=<?php echo $bookId; ?>'">
                        <img src="../upload/icon/edit.png" alt="Edit" class="btn-icon"> Write a Review
                    </button>
                <?php else: ?>
                    <button class="write-review-btn" onclick="location.href='UserLogin.php?redirect=BookPreview.php?book_id=<?php echo $bookId; ?>'">
                        <img src="../upload/icon/login.png" alt="Login" class="btn-icon"> Login to Write a Review
                    </button>
                <?php endif; ?>
            </div>

            <?php if (count($reviews) > 0): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review-item">
                        <div class="review-header">
                            <span class="reviewer-name"><?php echo htmlspecialchars($review['Username']); ?></span>
                            <span class="review-date"><?php echo date('F j, Y', strtotime($review['ReviewDate'])); ?></span>
                        </div>
                        <div class="review-rating">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $review['Rating']) {
                                    echo '<img src="../upload/icon/star-filled.png" alt="Star" class="star-icon">';
                                } else {
                                    echo '<img src="../upload/icon/star-empty.png" alt="Empty star" class="star-icon">';
                                }
                            }
                            ?>
                        </div>
                        <div class="review-text">
                            <?php echo htmlspecialchars($review['ReviewText']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-reviews">
                    <p>No reviews yet. Be the first to review this book!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>