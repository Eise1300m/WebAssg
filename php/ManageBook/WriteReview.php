<?php
session_start();
require_once("../base.php");

requireLogin();

$username = $_SESSION['user_name'];
$error_message = "";
$success_message = "";

// Get user ID
$stmt = $_db->prepare("SELECT UserID FROM users WHERE Username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

$user_id = $user['UserID'];

if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    // Fetch book details
    $stmt = $_db->prepare("SELECT * FROM book WHERE BookNo = ?");
    $stmt->execute([$book_id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        die("Book not found.");
    }

    // Check if user has already reviewed this book
    $stmt = $_db->prepare("SELECT * FROM reviews WHERE UserID = ? AND BookNo = ?");
    $stmt->execute([$user_id, $book_id]);
    $existing_review = $stmt->fetch(PDO::FETCH_ASSOC);

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
        $review_text = isset($_POST['review_text']) ? trim($_POST['review_text']) : '';

        if ($rating < 1 || $rating > 5) {
            $error_message = "Please select a rating between 1 and 5 stars.";
        } else {
            try {
                if ($existing_review) {
                    // Update existing review
                    $stmt = $_db->prepare("UPDATE reviews SET Rating = ?, ReviewText = ?, ReviewDate = NOW() 
                                           WHERE UserID = ? AND BookNo = ?");
                    $stmt->execute([$rating, $review_text, $user_id, $book_id]);
                    $success_message = "Your review has been updated! Redirecting back...";
                } else {
                    // Insert new review
                    $stmt = $_db->prepare("INSERT INTO reviews (UserID, BookNo, Rating, ReviewText, ReviewDate) 
                                           VALUES (?, ?, ?, ?, NOW())");
                    $stmt->execute([$user_id, $book_id, $rating, $review_text]);
                    $success_message = "Your review has been submitted! Redirecting back...";
                }

                header("refresh:2;url=BookPreview.php?book_id=" . $book_id);
            } catch (Exception $e) {
                $error_message = "Error saving review: " . $e->getMessage();
            }
        }
    }
} else {
    die("Book ID not provided.");
}

includeNavbar();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write a Review - <?php echo $book['BookName']; ?></title>
    <link rel="stylesheet" href="/WebAssg/css/NavbarStyles.css">
    <link rel="stylesheet" href="/WebAssg/css/FooterStyles.css">
    <link rel="stylesheet" href="/WebAssg/css/WriteReviewStyle.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../js/Scripts.js"></script>
    <script src="../../js/book.js"></script>
</head>

<body>

    <div class="review-container">
        <div class="review-header">
            <img src="<?= str_replace('../', '/WebAssg/', $book['BookImage']) ?: '/WebAssg/upload/bookPfp/BookCoverUnavailable.png'; ?>"
                alt="<?php echo htmlspecialchars($book['BookName']); ?>"
                class="book-thumbnail">
            <div class="book-info">
                <h1><?php echo htmlspecialchars($book['BookName']); ?></h1>
                <p>By <?php echo htmlspecialchars($book['Author']); ?></p>
            </div>
        </div>

        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="success-message">
                <h3>Review Submitted Successfully!</h3>
                <p>Thank you for your feedback.</p>
                <p>Redirecting in <span id="timer" data-book-id="<?php echo $book_id; ?>" data-time-left="2">2</span> seconds...</p>
            </div>
            
            <?php endif; ?>
            
        <form method="POST" action="" class="review-form">
            <div class="rate-book">
                <h3>Rate this book:</h3>
                <div class="stars-container">
                    <input type="radio" id="star5" name="rating" value="5">
                    <label for="star5"><i class="star" value="5"></i></label>
                    
                    <input type="radio" id="star4" name="rating" value="4">
                    <label for="star4"><i class="star" value="4"></i></label>
                    
                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3"><i class="star" value="3"></i></label>
                    
                    <input type="radio" id="star2" name="rating" value="2">
                    <label for="star2"><i class="star" value="2"></i></label>
                    
                    <input type="radio" id="star1" name="rating" value="1">
                    <label for="star1"><i class="star" value="1"></i></label>
                </div>
            </div>

            <div class="review-textarea">
                <h3>Write your review:</h3>
                <textarea name="review_text" rows="6" placeholder="What did you think about this book?"><?php echo $existing_review ? htmlspecialchars($existing_review['ReviewText']) : ''; ?></textarea>
            </div>

            <div class="review-actions">
                <button type="button" class="redirect-button cancel-btn" data-redirect-url="BookPreview.php?book_id=<?php echo $book_id; ?>">Cancel</button>
                <button type="submit" class="submit-btn"><?php echo $existing_review ? 'Update Review' : 'Submit Review'; ?></button>
            </div>
        </form>
    </div>

    <?php include_once('../footer.php') ?>

</body>

</html>