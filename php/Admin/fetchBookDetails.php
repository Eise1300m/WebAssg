<?php

session_start();
require_once("../base.php");

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
            // Format the BookImage path correctly
            if (!empty($book['BookImage'])) {
                // Handle relative paths that start with ../
                if (strpos($book['BookImage'], '../') === 0) {
                    $book['BookImage'] = '/WebAssg/' . substr($book['BookImage'], 3);
                }
                // Handle paths that don't have a leading slash and don't include the full path
                else if (strpos($book['BookImage'], '/') !== 0) {
                    $book['BookImage'] = '/WebAssg/upload/bookPfp/' . $book['BookImage'];
                }
            } else {
                // Set default image if BookImage is empty
                $book['BookImage'] = '/WebAssg/upload/bookPfp/BookCoverUnavailable.webp';
            }
            
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