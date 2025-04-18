<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secret Shelf</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/Scripts.js"></script>
    <script src="../js/Bookscript.js" defer></script>
    <link rel="stylesheet" href="../css/HomeStyles.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
</head>

<?php 
    require_once("base.php");
    includeNavbar();
    includeDropDownNav();

    function fetchBooks($query, $limit = 5) {
        global $_db;
        try {
            $stmt = $_db->prepare($query);
            $stmt->bindValue(1, $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    $bestSellersQuery = "SELECT b.*, COALESCE(SUM(od.Quantity), 0) as total_ordered 
                        FROM book b 
                        LEFT JOIN orderdetails od ON b.BookNo = od.BookNo 
                        GROUP BY b.BookNo 
                        ORDER BY total_ordered DESC 
                        LIMIT ?";
    $bestSellers = fetchBooks($bestSellersQuery);

    $latestBooksQuery = "SELECT b.* 
                        FROM book b 
                        ORDER BY b.BookNo DESC 
                        LIMIT ?";
    $latestBooks = fetchBooks($latestBooksQuery);

    $recommendationsQuery = "SELECT b.*, c.CategoryName 
                           FROM book b 
                           JOIN subcategory s ON b.SubcategoryNo = s.SubcategoryNo 
                           JOIN category c ON s.CategoryNo = c.CategoryNo 
                           ORDER BY RAND() 
                           LIMIT ?";
    $recommendations = fetchBooks($recommendationsQuery);
    ?>

<body>


    <div class="IndexBodybackground">
        <div class="up">
            <div class="slider-wrapper">
                <div class="Recommendation-Container">
                    <button id="back" class="slider-btn" aria-label="Previous slide">
                        <img src="../upload/icon/arrowback.png" alt="Previous" class="arrow-icon">
                    </button>
                    
                    <div class="slider-content">
                        <img id="mainImg" src="../img/Intro3.png" alt="Featured Book">
                    </div>
                    
                    <button id="next" class="slider-btn" aria-label="Next slide">
                        <img src="../upload/icon/arrowfoward.png" alt="Next" class="arrow-icon">
                    </button>
                </div>
            </div>
        </div>

        <div class="down">
            <div class="Category-part">
                <div class="Category-Section">
                    <p>Best-seller</p>
                    <div class="cat-img">
                        <?php foreach ($bestSellers as $book): ?>
                            <figure>
                                <a href="BookPreview.php?book_id=<?php echo $book['BookNo']; ?>" class="book-link">
                                    <img class="bookImg" src="<?php echo htmlspecialchars($book['BookImage']); ?>" 
                                         alt="<?php echo htmlspecialchars($book['BookName']); ?>">
                                    <div class="book-title">
                                        <?php echo htmlspecialchars($book['BookName']); ?>
                                    </div>
                                </a>
                            </figure>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="Category-Section">
                    <p>What's New</p>
                    <div class="cat-img">
                        <?php foreach ($latestBooks as $book): ?>
                            <figure>
                                <a href="BookPreview.php?book_id=<?php echo $book['BookNo']; ?>" class="book-link">
                                    <img class="bookImg" src="<?php echo htmlspecialchars($book['BookImage']); ?>" 
                                         alt="<?php echo htmlspecialchars($book['BookName']); ?>">
                                    <div class="book-title">
                                        <?php echo htmlspecialchars($book['BookName']); ?>
                                    </div>
                                </a>
                            </figure>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="Category-Section">
                    <p>Recommendation</p>
                    <div class="cat-img">
                        <?php foreach ($recommendations as $book): ?>
                            <figure>
                                <a href="BookPreview.php?book_id=<?php echo $book['BookNo']; ?>" class="book-link">
                                    <img class="bookImg" src="<?php echo htmlspecialchars($book['BookImage']); ?>" 
                                         alt="<?php echo htmlspecialchars($book['BookName']); ?>">
                                    <div class="book-title">
                                        <?php echo htmlspecialchars($book['BookName']); ?>
                                    </div>
                                </a>
                            </figure>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    
</body>

<?php includeFooter(); ?>

</html>