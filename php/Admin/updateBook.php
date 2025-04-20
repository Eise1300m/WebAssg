<?php
session_start();
require_once("../base.php");

// Set JSON content type
header('Content-Type: application/json');

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

try {
    $bookId = $_POST['book_id'];
    $bookName = $_POST['book_name'];
    $bookAuthor = $_POST['book_author'];
    $bookPrice = $_POST['book_price'];
    $description = $_POST['book_description']; 
    $subcategoryNo = $_POST['subcategory'];
    
    // Start with base query
    $query = "UPDATE book SET 
              BookName = ?, 
              Author = ?,
              BookPrice = ?, 
              Description = ?, 
              SubcategoryNo = ?";
    
    $params = [$bookName, $bookAuthor, $bookPrice, $description, $subcategoryNo];
    
    // Handle image upload if provided
    if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] === 0) {
        // Server file system path for uploads
        $uploadDir = '../../upload/bookPfp/';
        
        // Ensure upload directory exists
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                throw new Exception("Failed to create upload directory");
            }
        }
        
        // Create a unique filename to prevent overwriting
        $fileExt = pathinfo($_FILES['book_image']['name'], PATHINFO_EXTENSION);
        $fileName = $bookId . '_' . time() . '.' . $fileExt;
        $filePath = $uploadDir . $fileName;
        
        // Database path (how it will be accessed in HTML)
        $dbPath = '/WebAssg/upload/bookPfp/' . $fileName;
        
        // Move the uploaded file
        if (move_uploaded_file($_FILES['book_image']['tmp_name'], $filePath)) {
            $query .= ", BookImage = ?";
            $params[] = $dbPath;
            
            // Log success for debugging
            error_log("Book image uploaded successfully to: " . $filePath);
        } else {
            throw new Exception("Failed to upload image file");
        }
    }
    
    $query .= " WHERE BookNo = ?";
    $params[] = $bookId;
    
    $stmt = $_db->prepare($query);
    $stmt->execute($params);
    
    echo json_encode(['success' => true, 'message' => 'Book updated successfully']);
} catch (Exception $e) {
    error_log("Error updating book: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error updating book: ' . $e->getMessage()]);
} 