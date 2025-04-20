<?php
// Disable error display for this page to ensure clean JSON output
// ini_set('display_errors', 0);
// error_reporting(0);

session_start();
require_once("../base.php");

// Set JSON content type
header('Content-Type: application/json');

requireAdmin();

try {
    $bookName = $_POST['book_name'];
    $bookAuthor = $_POST['book_author'];
    $bookPrice = $_POST['book_price'];
    $description = $_POST['book_description'];
    $subcategoryNo = $_POST['subcategory'];
    
    // Handle image upload
    $bookImage = null;
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
        // Use timestamp since we don't have a book ID yet
        $fileName = 'new_' . time() . '.' . $fileExt;
        $filePath = $uploadDir . $fileName;
        
        // Database path (how it will be accessed in HTML)
        $dbPath = '/WebAssg/upload/bookPfp/' . $fileName;
        
        if (move_uploaded_file($_FILES['book_image']['tmp_name'], $filePath)) {
            $bookImage = $dbPath;
            // Log success for debugging
            error_log("Book image uploaded successfully to: " . $filePath);
        } else {
            throw new Exception("Failed to upload image file");
        }
    }
    
    $query = "INSERT INTO book (BookName, Author, BookPrice, Description, SubcategoryNo, BookImage) 
              VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $_db->prepare($query);
    $stmt->execute([$bookName, $bookAuthor, $bookPrice, $description, $subcategoryNo, $bookImage]);
    
    // Get the new book ID
    $newBookId = $_db->lastInsertId();
    
    // If we have a new book ID and an image with 'new_' prefix, rename it to include the book ID
    if ($newBookId && $bookImage && strpos($bookImage, 'new_') !== false) {
        $oldFilePath = $uploadDir . $fileName;
        $newFileName = $newBookId . '_' . time() . '.' . $fileExt;
        $newFilePath = $uploadDir . $newFileName;
        $newDbPath = '/WebAssg/upload/bookPfp/' . $newFileName;
        
        if (file_exists($oldFilePath) && rename($oldFilePath, $newFilePath)) {
            // Update the database with the new path
            $updateQuery = "UPDATE book SET BookImage = ? WHERE BookNo = ?";
            $updateStmt = $_db->prepare($updateQuery);
            $updateStmt->execute([$newDbPath, $newBookId]);
        }
    }
    
    echo json_encode(['success' => true, 'message' => 'Book added successfully']);
} catch (Exception $e) {
    error_log("Error adding book: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error adding book: ' . $e->getMessage()]);
} 