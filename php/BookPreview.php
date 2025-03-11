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
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2><?php echo $book['BookName']; ?></h2>
    <img src="<?php echo $book['BookImage']; ?>" alt="Book Image" style="width: 300px;">
    <p><strong>Author:</strong> <?php echo $book['Author']; ?></p>
    <p><strong>Price:</strong> $<?php echo number_format($book['BookPrice'], 2); ?></p>
    <p><strong>Description:</strong> <?php echo $book['Description']; ?></p>

    <button onclick="history.back()">Go Back</button>

</body>
</html>
