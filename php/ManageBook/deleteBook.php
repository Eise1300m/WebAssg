<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo "Unauthorized access";
    exit();
}

if (isset($_POST['book_id'])) {
    $bookId = $_POST['book_id'];
    
    // First get the book image to delete the file
    $stmt = $_db->prepare("SELECT BookImage FROM book WHERE BookNo = ?");
    $stmt->execute([$bookId]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Delete the book
    $stmt = $_db->prepare("DELETE FROM book WHERE BookNo = ?");
    
    try {
        $stmt->execute([$bookId]);
        
        // Delete the image file if it exists
        if ($book && !empty($book['BookImage']) && file_exists($book['BookImage'])) {
            unlink($book['BookImage']);
        }
        
        echo "Book deleted successfully!";
    } catch (PDOException $e) {
        echo "Error deleting book: " . $e->getMessage();
    }
} else {
    echo "No book ID provided";
}
?> 