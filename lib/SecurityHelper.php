<?php
class SecurityHelper {
    public static function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([self::class, 'sanitizeInput'], $input);
        }
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function validatePhone($phone) {
        return preg_match('/^01\d{8,9}$/', $phone);
    }

    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    public static function generateToken($length = 32) {
        return bin2hex(random_bytes($length));
    }

    public static function validateFileUpload($file, $type = 'image') {
        $max_size = 5000000; // 5MB
        $allowed_types = [
            'image' => ['image/jpeg', 'image/png', 'image/gif'],
            'document' => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']
        ];

        if ($file['size'] > $max_size) {
            return ['success' => false, 'message' => 'File is too large. Maximum size is 5MB.'];
        }

        if (!in_array($file['type'], $allowed_types[$type])) {
            return ['success' => false, 'message' => 'Invalid file type.'];
        }

        return ['success' => true];
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user_name']);
    }

    public static function isAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: UserLogin.php');
            exit();
        }
    }

    public static function requireAdmin() {
        if (!self::isAdmin()) {
            header('Location: index.php');
            exit();
        }
    }

    public static function setFlashMessage($key, $message) {
        $_SESSION['flash'][$key] = $message;
    }

    public static function getFlashMessage($key) {
        if (isset($_SESSION['flash'][$key])) {
            $message = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $message;
        }
        return null;
    }
} 