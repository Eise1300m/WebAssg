<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: UserLogin.php");
    exit();
}

// Determine any filters from GET parameters
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : 'all';
$subcategoryFilter = isset($_GET['subcategory']) ? $_GET['subcategory'] : 'all';

// Prepare the query with potential filters
$query = "
    SELECT b.*, s.SubcategoryName, s.CategoryNo, c.CategoryName 
    FROM book b 
    JOIN subcategory s ON b.SubcategoryNo = s.SubcategoryNo 
    JOIN category c ON s.CategoryNo = c.CategoryNo
    WHERE 1=1
";

// Add filters if selected
$params = [];
if ($categoryFilter !== 'all') {
    $query .= " AND s.CategoryNo = ?";
    $params[] = $categoryFilter;
}
if ($subcategoryFilter !== 'all') {
    $query .= " AND b.SubcategoryNo = ?";
    $params[] = $subcategoryFilter;
}

$query .= " ORDER BY b.BookNo DESC";

// Execute the filtered query
$stmt = $_db->prepare($query);
$stmt->execute($params);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch categories for the add/edit form and filter dropdown
$stmt = $_db->prepare("SELECT * FROM category");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all subcategories
$stmt = $_db->prepare("SELECT * FROM subcategory");
$stmt->execute();
$allSubcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count books for stats
$bookCount = count($books);

// Add this after your existing database queries, before the HTML
$subcategoriesMap = [];
foreach ($allSubcategories as $sub) {
    if (!isset($subcategoriesMap[$sub['CategoryNo']])) {
        $subcategoriesMap[$sub['CategoryNo']] = [];
    }
    $subcategoriesMap[$sub['CategoryNo']][] = [
        'id' => $sub['SubcategoryNo'],
        'name' => $sub['SubcategoryName']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management - Secret Shelf</title>
    <link rel="stylesheet" href="../css/HomeStyles.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/AdminProductStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/Scripts.js"></script>
    <script src="../js/AdminScripts.js"></script>

</head>

<body>
    <?php include_once("navbaradmin.php") ?>

    <main class="admin-container">
        <div class="admin-header">
            <h1>Product Management</h1>
            <p>Manage your book inventory</p>
        </div>

        <div class="admin-content">
            <a href="AdminMainPage.php" class="admin-nav-back">
                <img src="../upload/icon/back.png" alt="Back"> Back to Dashboard
            </a>

            <div class="admin-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <img src="../upload/icon/book.png" style="width: 30px; height: 30px;" alt="Total Books">
                    </div>
                    <div class="stat-info">
                        <span>Total Books</span>
                        <h3><?php echo $bookCount; ?></h3>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <img src="../upload/icon/list.png" style="width: 30px; height: 30px;" alt="Total Categories">
                    </div>
                    <div class="stat-info">
                        <span>Categories</span>
                        <h3><?php echo count($categories); ?></h3>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <img src="../upload/icon/subcat.png" style="width: 30px; height: 30px;" alt="Total Subcategories">
                    </div>
                    <div class="stat-info">
                        <span>Subcategories</span>
                        <h3><?php echo count($allSubcategories); ?></h3>
                    </div>
                </div>
            </div>

            <div class="product-management">
                <div class="product-actions">
                    <button class="add-product-btn" onclick="showAddProductForm()">
                        Add New Book
                    </button>

                    <div class="filter-container">
                        <form id="filterForm" method="get" class="filter-form">
                            <div class="filter-group">
                                <label for="category-filter">Category</label>
                                <select id="category-filter" name="category" onchange="updateSubcategoryFilter()">
                                    <option value="all" <?php echo $categoryFilter === 'all' ? 'selected' : ''; ?>>All Categories</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['CategoryNo']; ?>" <?php echo $categoryFilter == $category['CategoryNo'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($category['CategoryName']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="filter-group">
                                <label for="subcategory-filter">Subcategory</label>
                                <select id="subcategory-filter" name="subcategory">
                                    <option value="all">All Subcategories</option>
                                    <!-- This will be populated via JavaScript based on category selection -->
                                </select>
                            </div>

                            <button type="submit" class="filter-btn">
                                <img src="../upload/icon/filter.png" style="width: 20px; height: 20px;"> Apply Filter
                            </button>

                            <a href="AdminProductManagement.php" class="reset-btn">
                                <img src="../upload/icon/reset.png" style="width: 20px; height: 20px;"> Reset
                            </a>
                        </form>
                    </div>
                </div>

                <div class="product-table-container">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Book ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($books)): ?>
                                <tr>
                                    <td colspan="7" class="no-results">No books found matching your criteria.</td>
                                </tr>
                            <?php else: ?>
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
                                        <td><span class="category-badge"><?php echo htmlspecialchars($book['CategoryName']); ?></span></td>
                                        <td><span class="subcategory-badge"><?php echo htmlspecialchars($book['SubcategoryName']); ?></span></td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="edit-btn" onclick="editBook(<?php echo $book['BookNo']; ?>)">
                                                    <img src="../upload/icon/edit.png" style="width: 20px; height: 20px;"> Edit
                                                </button>
                                                <button class="delete-btn" onclick="confirmDeleteBook(<?php echo $book['BookNo']; ?>)">
                                                    <img src="../upload/icon/delete.png" style="width: 20px; height: 20px;"> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
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
            <!-- <h2 id="modalTitle">Add New Book</h2> -->
            <form id="productForm">
                <input type="hidden" name="book_id" id="book_id">
                <div class="form-row">
                    <div class="form-group">
                        <label for="book_name">Book Name</label>
                        <input type="text" id="book_name" name="book_name" required>
                    </div>
                    <div class="form-group">
                        <label for="book_price">Price (RM)</label>
                        <input type="number" id="book_price" name="book_price" step="0.01" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category" name="category" required>
                            <option value="">-- Select Category --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['CategoryNo']; ?>">
                                    <?php echo htmlspecialchars($category['CategoryName']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subcategory">Subcategory</label>
                        <select id="subcategory" name="subcategory" required>
                            <option value="">-- Select Category First --</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="book_description">Description</label>
                    <textarea id="book_description" name="book_description" rows="4"></textarea>
                </div>

                <div class="form-group">
                    <label for="book_image">Book Image</label>
                    <input type="file" id="book_image" name="book_image" accept="image/*">
                    <div id="image-preview-container" class="image-preview-container" style="display: none;">
                        <img id="image-preview" alt="Book preview">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="cancel-btn" onclick="closeProductModal()">Cancel</button>
                    <button type="submit" class="save-btn">Save Book</button>
                </div>
            </form>
        </div>
    </div>

    <div id="subcategories-data"
        data-subcategories='<?php echo json_encode($subcategoriesMap); ?>'
        data-current-subcategory='<?php echo $subcategoryFilter; ?>'>
    </div>

    <!-- Remove inline script references and keep only external ones -->
    <script src="../js/Scripts.js"></script>
    <script src="../js/AdminScripts.js"></script>
    <?php include 'footer.php'; ?>
</body>

</html>