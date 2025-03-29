<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

try {
    $bookName = $_POST['book_name'];
    $bookPrice = $_POST['book_price'];
    $description = $_POST['description'];
    $subcategoryNo = $_POST['subcategory'];
    
    // Handle image upload
    $bookImage = null;
    if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] === 0) {
        $uploadDir = '../upload/bookPfp/';
        $fileName = basename($_FILES['book_image']['name']);
        $targetPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['book_image']['tmp_name'], $targetPath)) {
            $bookImage = $targetPath;
        }
    }
    
    $query = "INSERT INTO book (BookName, BookPrice, Description, SubcategoryNo, BookImage) 
              VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $_db->prepare($query);
    $stmt->execute([$bookName, $bookPrice, $description, $subcategoryNo, $bookImage]);
    
    echo json_encode(['success' => true, 'message' => 'Book added successfully']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error adding book: ' . $e->getMessage()]);
} 