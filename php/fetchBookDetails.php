<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['error' => 'Unauthorized access']);
    exit();
}

if (isset($_GET['book_id'])) {
    $bookId = $_GET['book_id'];
    
    $stmt = $_db->prepare("
        SELECT b.*, s.SubcategoryNo, s.CategoryNo
        FROM book b
        JOIN subcategory s ON b.SubcategoryNo = s.SubcategoryNo
        WHERE b.BookNo = ?
    ");
    
    $stmt->execute([$bookId]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($book) {
        echo json_encode($book);
    } else {
        echo json_encode(['error' => 'Book not found']);
    }
} else {
    echo json_encode(['error' => 'No book ID provided']);
}
?> 