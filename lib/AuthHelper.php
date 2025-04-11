<?php
class AuthHelper {
    /**
     * Check if user is logged in
     * @return bool
     */
    public static function isLoggedIn() {
        return isset($_SESSION['user_name']);
    }

    /**
     * Check if user is an admin
     * @return bool
     */
    public static function isAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    /**
     * Check if user is a customer
     * @return bool
     */
    public static function isCustomer() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'customer';
    }

    /**
     * Require admin access, redirect to login if not admin
     */
    public static function requireAdmin() {
        if (!self::isAdmin()) {
            header("Location: UserLogin.php");
            exit();
        }
    }

    /**
     * Require customer access, redirect to login if not customer
     */
    public static function requireCustomer() {
        if (!self::isCustomer()) {
            header("Location: UserLogin.php");
            exit();
        }
    }

    /**
     * Require login, redirect to login page if not logged in
     */
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header("Location: UserLogin.php");
            exit();
        }
    }

    /**
     * Get current user's role
     * @return string|null
     */
    public static function getUserRole() {
        return $_SESSION['user_role'] ?? null;
    }

    /**
     * Get current user's username
     * @return string|null
     */
    public static function getUsername() {
        return $_SESSION['user_name'] ?? null;
    }
} 