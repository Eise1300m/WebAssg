<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connection
require_once("connection.php");

// Include helper classes
require_once("../lib/DatabaseHelper.php");
require_once("../lib/SecurityHelper.php");
require_once("../lib/FormHelper.php");
require_once("../lib/BookHelper.php");

// Initialize helpers
BookHelper::init($_db);

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



// Common navbar include
function includeNavbar() {
    include_once 'navbar.php';
}

function includeAdminNav() {
    include_once 'navbaradmin.php';
}

// Common footer include
function includeFooter() {
    include_once 'footer.php';
}

// Common flash message display
function displayFlashMessages() {
    if (isset($_SESSION['error_message'])) {
        echo '<div class="error-message">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
        unset($_SESSION['error_message']);
    }
    if (isset($_SESSION['success_message'])) {
        echo '<div class="success-message">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
        unset($_SESSION['success_message']);
    }
}

// Common database instance
$db = DatabaseHelper::getInstance($_db);

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

/**
 * Display flash message if exists and remove it from session
 * @return void
 */
function displayFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        echo '<div class="flash-message ' . $flash['type'] . '">' . $flash['message'] . '</div>';
        unset($_SESSION['flash_message']);
    }
}
?> 