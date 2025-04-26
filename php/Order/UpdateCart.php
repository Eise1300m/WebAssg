<?php
session_start();
require_once "../base.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_name'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Please login first'
    ]);
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'] ?? null;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
    
    if (!isset($_SESSION['cart'][$book_id])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Book not found in cart'
        ]);
        exit;
    }

    if ($quantity <= 0) {
        // Remove item from cart
        unset($_SESSION['cart'][$book_id]);
        
        // Calculate new subtotal
        $subtotal = 0;
        $shipping = 5.00;
        
        // Only calculate subtotal if cart is not empty
        if (!empty($_SESSION['cart'])) {
            $bookIds = array_keys($_SESSION['cart']);
            $placeholders = str_repeat('?,', count($bookIds) - 1) . '?';
            $stmt = $_db->prepare("SELECT BookNo, BookPrice FROM book WHERE BookNo IN ($placeholders)");
            $stmt->execute($bookIds);
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($books as $book) {
                if (isset($_SESSION['cart'][$book['BookNo']])) {
                    $subtotal += $book['BookPrice'] * $_SESSION['cart'][$book['BookNo']]['Quantity'];
                }
            }
        } else {
            $shipping = 0;
        }
        
        // Calculate total (subtotal + shipping)
        $total = $subtotal + $shipping;
        
        // Update session values
        $_SESSION['cart_subtotal'] = $subtotal;
        $_SESSION['cart_shipping'] = $shipping;
        $_SESSION['cart_total'] = $total;
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Item removed from cart',
            'action' => 'remove',
            'cart_total' => number_format($total, 2),
            'cart_subtotal' => number_format($subtotal, 2),
            'shipping' => number_format($shipping, 2),
            'item_count' => count($_SESSION['cart'])
        ]);
    } else {
        // Update quantity
        $_SESSION['cart'][$book_id]['Quantity'] = $quantity;
        
        // Calculate new subtotal
        $subtotal = 0;
        $shipping = 5.00;
        
        $bookIds = array_keys($_SESSION['cart']);
        $placeholders = str_repeat('?,', count($bookIds) - 1) . '?';
        $stmt = $_db->prepare("SELECT BookNo, BookPrice FROM book WHERE BookNo IN ($placeholders)");
        $stmt->execute($bookIds);
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($books as $book) {
            if (isset($_SESSION['cart'][$book['BookNo']])) {
                $subtotal += $book['BookPrice'] * $_SESSION['cart'][$book['BookNo']]['Quantity'];
            }
        }
        
        // Calculate total (subtotal + shipping)
        $total = $subtotal + $shipping;
        
        // Update session values
        $_SESSION['cart_subtotal'] = $subtotal;
        $_SESSION['cart_shipping'] = $shipping;
        $_SESSION['cart_total'] = $total;
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Quantity updated',
            'action' => 'update',
            'cart_total' => number_format($total, 2),
            'cart_subtotal' => number_format($subtotal, 2),
            'shipping' => number_format($shipping, 2),
            'item_count' => count($_SESSION['cart'])
        ]);
    }
}
?>