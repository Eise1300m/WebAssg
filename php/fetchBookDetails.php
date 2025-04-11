<?php
// Disable error display for this page to ensure clean JSON output
ini_set('display_errors', 0);
error_reporting(0);

session_start();
require_once("base.php");

// Set JSON content type
header('Content-Type: application/json');

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['error' => 'Unauthorized access']);
    exit();
}

if (isset($_GET['book_id'])) {
    $bookId = $_GET['book_id'];
    
    try {
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
    } catch (Exception $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'No book ID provided']);
}
?> 