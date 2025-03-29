<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

try {
    $bookId = $_POST['book_id'];
    $bookName = $_POST['book_name'];
    $bookPrice = $_POST['book_price'];
    $description = $_POST['description'];
    $subcategoryNo = $_POST['subcategory'];
    
    // Start with base query
    $query = "UPDATE book SET 
              BookName = ?, 
              BookPrice = ?, 
              Description = ?, 
              SubcategoryNo = ?";
    
    $params = [$bookName, $bookPrice, $description, $subcategoryNo];
    
    // Handle image upload if provided
    if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] === 0) {
        $uploadDir = '../upload/bookPfp/';
        $fileName = basename($_FILES['book_image']['name']);
        $targetPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['book_image']['tmp_name'], $targetPath)) {
            $query .= ", BookImage = ?";
            $params[] = $targetPath;
        }
    }
    
    $query .= " WHERE BookNo = ?";
    $params[] = $bookId;
    
    $stmt = $_db->prepare($query);
    $stmt->execute($params);
    
    echo json_encode(['success' => true, 'message' => 'Book updated successfully']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error updating book: ' . $e->getMessage()]);
} 