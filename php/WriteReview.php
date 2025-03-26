<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_name'])) {
    header("Location: UserLogin.php");
    exit;
}

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
        } elseif (empty($review_text)) {
            $error_message = "Please write a review.";
        } else {
            try {
                if ($existing_review) {
                    // Update existing review
                    $stmt = $_db->prepare("UPDATE reviews SET Rating = ?, ReviewText = ?, ReviewDate = NOW() 
                                           WHERE UserID = ? AND BookNo = ?");
                    $stmt->execute([$rating, $review_text, $user_id, $book_id]);
                    $success_message = "Your review has been updated!";
                } else {
                    // Insert new review
                    $stmt = $_db->prepare("INSERT INTO reviews (UserID, BookNo, Rating, ReviewText, ReviewDate) 
                                           VALUES (?, ?, ?, ?, NOW())");
                    $stmt->execute([$user_id, $book_id, $rating, $review_text]);
                    $success_message = "Your review has been submitted!";
                }
                
                // Redirect back to book preview page after 2 seconds
                header("refresh:2;url=BookPreview.php?book_id=" . $book_id);
            } catch (Exception $e) {
                $error_message = "Error saving review: " . $e->getMessage();
            }
        }
    }
} else {
    die("Book ID not provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write a Review - <?php echo $book['BookName']; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="stylesheet" href="../css/WriteReviewStyle.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/Scripts.js"></script>
</head>
<body>
    <?php include_once("navbar.php") ?>
    
    <div class="review-container">
        <div class="review-header">
            <img src="<?php echo $book['BookImage'] ?: '../upload/bookPfp/bookcoverunavailable.png'; ?>" 
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
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="" class="review-form">
            <div class="rating-select">
                <h3>Rate this book:</h3>
                <div class="stars-container">
                    <input type="radio" id="star5" name="rating" value="5" <?php echo ($existing_review && $existing_review['Rating'] == 5) ? 'checked' : ''; ?>>
                    <label for="star5" title="5 stars"><i class="far fa-star"></i></label>
                    
                    <input type="radio" id="star4" name="rating" value="4" <?php echo ($existing_review && $existing_review['Rating'] == 4) ? 'checked' : ''; ?>>
                    <label for="star4" title="4 stars"><i class="far fa-star"></i></label>
                    
                    <input type="radio" id="star3" name="rating" value="3" <?php echo ($existing_review && $existing_review['Rating'] == 3) ? 'checked' : ''; ?>>
                    <label for="star3" title="3 stars"><i class="far fa-star"></i></label>
                    
                    <input type="radio" id="star2" name="rating" value="2" <?php echo ($existing_review && $existing_review['Rating'] == 2) ? 'checked' : ''; ?>>
                    <label for="star2" title="2 stars"><i class="far fa-star"></i></label>
                    
                    <input type="radio" id="star1" name="rating" value="1" <?php echo ($existing_review && $existing_review['Rating'] == 1) ? 'checked' : ''; ?>>
                    <label for="star1" title="1 star"><i class="far fa-star"></i></label>
                </div>
            </div>
            
            <div class="review-textarea">
                <h3>Write your review:</h3>
                <textarea name="review_text" rows="6" placeholder="What did you think about this book?"><?php echo $existing_review ? htmlspecialchars($existing_review['ReviewText']) : ''; ?></textarea>
            </div>
            
            <div class="review-actions">
                <button type="button" class="cancel-btn" onclick="history.back()">Cancel</button>
                <button type="submit" class="submit-btn"><?php echo $existing_review ? 'Update Review' : 'Submit Review'; ?></button>
            </div>
        </form>
    </div>
    
    <?php include_once('footer.php') ?>

    <script>
    // Add JavaScript to enhance star rating interaction
    document.addEventListener('DOMContentLoaded', function() {
        // Change the star icon from regular to solid when selected or hovered
        const starLabels = document.querySelectorAll('.stars-container label');
        const starInputs = document.querySelectorAll('.stars-container input');
        
        starLabels.forEach(label => {
            // Change to solid star on hover
            label.addEventListener('mouseenter', function() {
                this.querySelector('i').classList.replace('far', 'fas');
                let prevSibling = this.previousElementSibling;
                
                // Also change all siblings to the right
                while (prevSibling && prevSibling.tagName === 'LABEL') {
                    prevSibling.querySelector('i').classList.replace('far', 'fas');
                    prevSibling = prevSibling.previousElementSibling;
                }
            });
            
            // Return to default state on mouseout
            label.addEventListener('mouseleave', function() {
                resetStars();
            });
        });
        
        // Keep the selected stars solid
        starInputs.forEach(input => {
            input.addEventListener('change', function() {
                resetStars();
            });
        });
        
        // Function to reset stars based on the selected rating
        function resetStars() {
            let selectedRating = 0;
            
            starInputs.forEach(input => {
                if (input.checked) {
                    selectedRating = parseInt(input.value);
                }
            });
            
            starLabels.forEach(label => {
                const starValue = parseInt(label.getAttribute('for').replace('star', ''));
                const starIcon = label.querySelector('i');
                
                if (starValue <= selectedRating) {
                    starIcon.classList.replace('far', 'fas');
                } else {
                    starIcon.classList.replace('fas', 'far');
                }
            });
        }
        
        // Initialize the stars based on any pre-selected rating
        resetStars();
    });
    </script>
</body>
</html>