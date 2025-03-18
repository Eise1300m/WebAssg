<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: UserLogin.php");
    exit();
}

// Fetch all books with their subcategories
$stmt = $_db->prepare("
    SELECT b.*, s.SubcategoryName, c.CategoryName 
    FROM book b 
    JOIN subcategory s ON b.SubcategoryNo = s.SubcategoryNo 
    JOIN category c ON s.CategoryNo = c.CategoryNo
    ORDER BY b.BookNo DESC
");
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch categories and subcategories for the add/edit form
$stmt = $_db->prepare("SELECT * FROM category");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management - Secret Shelf</title>
    <link rel="stylesheet" href="../css/HomeStyles.css">
    <link rel="stylesheet" href="../css/AdminStyles.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/AdminScripts.js"></script>
    <script src="../js/Scripts.js"></script>
</head>
<body>
    <?php include_once("navbar.php") ?>

    <main class="admin-container">
        <div class="admin-header">
            <h1>Product Management</h1>
            <p>Manage your book inventory</p>
        </div>

        <div class="admin-content">
            <a href="AdminMainPage.php" class="admin-nav-back">
                <img src="../upload/icon/back-arrow.png" alt="Back"> Back to Dashboard
            </a>
            
            <div class="product-management">
                <button class="add-product-btn" onclick="showAddProductForm()">
                    Add New Book
                </button>

                <div class="product-list">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Book ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($books as $book): ?>
                            <tr>
                                <td><?php echo $book['BookNo']; ?></td>
                                <td>
                                    <img src="<?php echo $book['BookImage'] ?: '../img/no-cover.png'; ?>" 
                                         alt="<?php echo htmlspecialchars($book['BookName']); ?>"
                                         class="book-thumbnail">
                                </td>
                                <td><?php echo htmlspecialchars($book['BookName']); ?></td>
                                <td>RM <?php echo number_format($book['BookPrice'], 2); ?></td>
                                <td><?php echo htmlspecialchars($book['CategoryName']); ?></td>
                                <td>
                                    <button onclick="editBook(<?php echo $book['BookNo']; ?>)">Edit</button>
                                    <button onclick="confirmDeleteBook(<?php echo $book['BookNo']; ?>)">Delete</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Add/Edit Product Modal -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeProductModal()">&times;</span>
            <h2 id="modalTitle">Add New Book</h2>
            <form id="productForm">
                <input type="hidden" name="book_id" id="book_id">
                <div class="form-group">
                    <label for="book_name">Book Name</label>
                    <input type="text" id="book_name" name="book_name" required>
                </div>
                <div class="form-group">
                    <label for="book_price">Price</label>
                    <input type="number" id="book_price" name="book_price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['CategoryNo']; ?>">
                                <?php echo htmlspecialchars($category['CategoryName']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="book_image">Book Image</label>
                    <input type="file" id="book_image" name="book_image" accept="image/*">
                </div>
                <button type="submit" class="save-btn">Save</button>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html> 