<?php
require_once("connection.php");
try {
    $query = "SELECT * FROM book";
    $stmt = $_db->prepare($query);
    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title><?= $_title ?? 'Secret Shelf' ?></title>
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



</head>

<?php include_once("navbar.php") ?>
<?php include_once("DropDownNav.php")?>

<body>

    <h2>Book List</h2>
    <div class="book-container">
        <?php foreach ($books as $book) { ?>
            <div class="book-card">
                <a href="BookPreview.php?book_id=<?php echo $book['BookNo']; ?>">
                    <img src="<?php echo $book['BookImage']; ?>" alt="Book Image">
                </a>
                <h3><?php echo $book['BookName']; ?></h3>
                <p><strong>Author:</strong> <?php echo $book['Author']; ?></p>
                <p><strong>Price:</strong> $<?php echo number_format($book['BookPrice'], 2); ?></p>
                <!-- <p><?php echo $book['Description']; ?></p> -->
                <button>Add to Cart</button>
            </div>
        <?php } ?>
    </div>
    <script src="../js/Scripts.js"></script>
</body>

</html>