<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Add this function at the top of the file after the session_start() code
// This will help with path resolution across the site

// REMOVING getBasePath function as it's no longer needed with absolute paths

// Database connection
require_once("connection.php");



// Common error handling function
function handleError($message, $redirect = null) {
    $_SESSION['error_message'] = $message;
    if ($redirect) {
        header("Location: $redirect");
        exit();
    }
    return false;
}

// Common success message function
function setSuccessMessage($message) {
    $_SESSION['success_message'] = $message;
}

// Common redirect function
function redirect($url) {
    header("Location: $url");
    exit();
}

// Common authentication check
function requireLogin() {
    if (!isset($_SESSION['user_name'])) {
        redirect('UserLogin.php');
    }
}

// Common admin check
function requireAdmin() {
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        redirect('UserLogin.php');
    }
}

// Common customer check
function requireCustomer() {
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'customer') {
        redirect('UserLogin.php');
    }
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_name']);
}

// Check if user is admin
function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// Check if user is customer
function isCustomer() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'customer';
}

// Get current user's role
function getUserRole() {
    return $_SESSION['user_role'] ?? null;
}

// Get current user's username
function getUsername() {
    return $_SESSION['user_name'] ?? null;
}

// Get user's profile picture
function getUserProfilePic() {
    global $_db;
    
    $default_pic = '/WebAssg/upload/icon/UnknownUser.jpg';
    
    if (!isset($_SESSION['user_name'])) {
        return $default_pic;
    }
    
    try {
        $stmt = $_db->prepare("SELECT ProfilePic, Role FROM users WHERE Username = ?");
        $stmt->execute([$_SESSION['user_name']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result && !empty($result['ProfilePic'])) {
            $profilePic = $result['ProfilePic'];
            
            // If the path starts with a slash, it's already an absolute path
            if (strpos($profilePic, '/') === 0) {
                return $profilePic;
            }
            
            // If the profile pic is stored with a relative path, convert to absolute
            if (strpos($profilePic, '../') === 0) {
                // Convert "../upload/..." to "/WebAssg/upload/..."
                $profilePic = '/WebAssg/' . substr($profilePic, 3);
                return $profilePic;
            }
            
            // For older paths without proper formatting
            if (strpos($profilePic, 'upload/') !== false) {
                return '/WebAssg/' . $profilePic;
            }
            
            return $profilePic;
        }
    } catch (PDOException $e) {
        // Log error if needed
        error_log("Error fetching profile picture: " . $e->getMessage());
    }
    
    return $default_pic;
}

/**
 * Include the navbar file based on user role
 */
function includeNavbar() {
   
        include_once dirname(__FILE__) . '/navbar.php';
    
}

function includeAdminNav() {
    // Include with absolute path
    include_once dirname(__FILE__) . '/navbaradmin.php';
}

// Common footer include
function includeFooter() {
    // Include with absolute path
    include_once dirname(__FILE__) . '/footer.php';
}

function includeDropDownNav() {
    // Include with absolute path
    include_once dirname(__FILE__) . '/DropDownNav.php';
}


// Utility functions for MainPage.php
function get($key, $default = '') {
    return isset($_GET[$key]) ? $_GET[$key] : $default;
}

function encode($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function format_price($price) {
    return 'RM ' . number_format($price, 2);
}

function get_books($filters = []) {
    global $db;
    
    $query = "
        SELECT b.*, s.SubcategoryName, c.CategoryName 
        FROM book b 
        JOIN subcategory s ON b.SubcategoryNo = s.SubcategoryNo 
        JOIN category c ON s.CategoryNo = c.CategoryNo 
        WHERE 1=1
    ";
    
    $params = [];
    
    if (!empty($filters['search'])) {
        $query .= " AND (b.BookName LIKE ? OR b.Author LIKE ?)";
        $search = "{$filters['search']}%";
        $params[] = $search;
        $params[] = $search;
    }
    
    if (!empty($filters['category'])) {
        $query .= " AND c.CategoryName = ?";
        $params[] = $filters['category'];
    }
    
    if (!empty($filters['subcategory'])) {
        $query .= " AND s.SubcategoryName = ?";
        $params[] = $filters['subcategory'];
    }
    
    $query .= " ORDER BY b.BookName";
    
    $stmt = $db->query($query, $params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function add_err($key, $message) {
    if (!isset($_SESSION['errors'])) {
        $_SESSION['errors'] = [];
    }
    $_SESSION['errors'][$key] = $message;
}

function displayFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        echo '<div class="flash-message ' . $flash['type'] . '">' . $flash['message'] . '</div>';
        unset($_SESSION['flash_message']);
    }
    
    if (isset($_SESSION['error_message'])) {
        echo '<div class="flash-message error">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']);
    }
    
    if (isset($_SESSION['success_message'])) {
        echo '<div class="flash-message success">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']);
    }
}

// Order Management Functions
function confirmOrderCollection($order_id) {
    global $_db;
    
    if (!isset($_SESSION['user_name'])) {
        return ['success' => false, 'message' => 'Please login first'];
    }

    try {
        // Get user ID
        $stmt = $_db->prepare("SELECT UserID FROM users WHERE UserName = ?");
        $stmt->execute([$_SESSION['user_name']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return ['success' => false, 'message' => 'User not found'];
        }

        // Update order status to Collected
        $stmt = $_db->prepare("UPDATE orders SET OrderStatus = 'Collected' WHERE OrderNo = ?");
        $stmt->execute([$order_id]);

        return ['success' => true, 'message' => 'Order collection confirmed successfully'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}

function updateOrderStatus($order_id, $new_status) {
    global $_db;
    
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        return ['success' => false, 'message' => 'Unauthorized access'];
    }

    try {
        // Check if order exists
        $stmt = $_db->prepare("SELECT OrderStatus FROM orders WHERE OrderNo = ?");
        $stmt->execute([$order_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$order) {
            return ['success' => false, 'message' => 'Order not found'];
        }
        
        // Validate status transition
        $validTransitions = [
            'Preparing' => ['Delivering'],
            'Delivering' => ['Collected', 'Complete'],
            'Collected' => ['Complete']
        ];
        
        if (!isset($validTransitions[$order['OrderStatus']]) || 
            !in_array($new_status, $validTransitions[$order['OrderStatus']])) {
            return ['success' => false, 'message' => 'Invalid status transition'];
        }
        
        // Update order status
        $stmt = $_db->prepare("UPDATE orders SET OrderStatus = ? WHERE OrderNo = ?");
        $stmt->execute([$new_status, $order_id]);
        
        return ['success' => true, 'message' => 'Order status updated successfully'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}
?> 