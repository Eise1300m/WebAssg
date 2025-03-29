<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo "Unauthorized access";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookId = isset($_POST['book_id']) ? $_POST['book_id'] : null;
    $bookName = $_POST['book_name'];
    $bookPrice = $_POST['book_price'];
    $description = $_POST['book_description'];
    $subcategoryId = $_POST['subcategory'];
    
    // Handle image upload
    $uploadImage = false;
    $imagePath = '';
    
    if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['book_image']['name'];
        $fileTmpName = $_FILES['book_image']['tmp_name'];
        $fileSize = $_FILES['book_image']['size'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
        
        if (!in_array($fileExt, $allowedExtensions)) {
            echo "Invalid file type! Only JPG, PNG & GIF files are allowed.";
            exit();
        }
        
        if ($fileSize > 5000000) { // 5MB max
            echo "File is too large! Maximum size is 5MB.";
            exit();
        }
        
        $uploadDir = "../upload/bookPfp/";
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $newFileName = time() . "-" . $fileName;
        $uploadPath = $uploadDir . $newFileName;
        
        if (move_uploaded_file($fileTmpName, $uploadPath)) {
            $uploadImage = true;
            $imagePath = $uploadPath;
        } else {
            echo "Failed to upload image.";
            exit();
        }
    }
    
    try {
        if ($bookId) {
            // Update existing book
            if ($uploadImage) {
                // First get the old image to delete it
                $stmt = $_db->prepare("SELECT BookImage FROM book WHERE BookNo = ?");
                $stmt->execute([$bookId]);
                $oldBook = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Delete old image
                if ($oldBook && !empty($oldBook['BookImage']) && file_exists($oldBook['BookImage'])) {
                    unlink($oldBook['BookImage']);
                }
                
                // Update with new image
                $stmt = $_db->prepare("UPDATE book SET BookName = ?, BookPrice = ?, Description = ?, SubcategoryNo = ?, BookImage = ? WHERE BookNo = ?");
                $stmt->execute([$bookName, $bookPrice, $description, $subcategoryId, $imagePath, $bookId]);
            } else {
                // Update without changing the image
                $stmt = $_db->prepare("UPDATE book SET BookName = ?, BookPrice = ?, Description = ?, SubcategoryNo = ? WHERE BookNo = ?");
                $stmt->execute([$bookName, $bookPrice, $description, $subcategoryId, $bookId]);
            }
            
            echo "Book updated successfully!";
        } else {
            // Add new book
            $stmt = $_db->prepare("INSERT INTO book (BookName, BookPrice, Description, SubcategoryNo, BookImage) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$bookName, $bookPrice, $description, $subcategoryId, $uploadImage ? $imagePath : null]);
            
            echo "Book added successfully!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method";
}
?> 