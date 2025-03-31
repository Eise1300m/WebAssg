<?php
class BookHelper {
    private static $db;

    public static function init($db) {
        self::$db = $db;
    }

    public static function getBooks($filters = []) {
        $query = "SELECT b.*, s.SubcategoryName, c.CategoryName 
                  FROM book b 
                  JOIN subcategory s ON b.SubcategoryNo = s.SubcategoryNo 
                  JOIN category c ON s.CategoryNo = c.CategoryNo 
                  WHERE 1=1";
        
        $params = [];
        
        if (!empty($filters['search'])) {
            $query .= " AND (b.BookName LIKE ? OR b.Author LIKE ?)";
            $searchTerm = $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        if (!empty($filters['category'])) {
            $query .= " AND c.CategoryName = ?";
            $params[] = $filters['category'];
        }
        
        if (!empty($filters['subcategory'])) {
            $query .= " AND s.SubcategoryName = ?";
            $params[] = $filters['subcategory'];
        }
        
        $query .= " ORDER BY b.BookName ASC";
        
        $stmt = self::$db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getBookById($id) {
        $query = "SELECT b.*, s.SubcategoryName, c.CategoryName 
                  FROM book b 
                  JOIN subcategory s ON b.SubcategoryNo = s.SubcategoryNo 
                  JOIN category c ON s.CategoryNo = c.CategoryNo 
                  WHERE b.BookNo = ?";
        
        $stmt = self::$db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getCategories() {
        $query = "SELECT * FROM category ORDER BY CategoryName";
        $stmt = self::$db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getSubcategories($categoryId) {
        $query = "SELECT * FROM subcategory WHERE CategoryNo = ? ORDER BY SubcategoryName";
        $stmt = self::$db->prepare($query);
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function addBook($data) {
        $query = "INSERT INTO book (BookName, Author, BookPrice, Description, BookImage, SubcategoryNo) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = self::$db->prepare($query);
        return $stmt->execute([
            $data['BookName'],
            $data['Author'],
            $data['BookPrice'],
            $data['Description'],
            $data['BookImage'],
            $data['SubcategoryNo']
        ]);
    }

    public static function updateBook($id, $data) {
        $query = "UPDATE book 
                  SET BookName = ?, Author = ?, BookPrice = ?, Description = ?, 
                      BookImage = ?, SubcategoryNo = ? 
                  WHERE BookNo = ?";
        
        $stmt = self::$db->prepare($query);
        return $stmt->execute([
            $data['BookName'],
            $data['Author'],
            $data['BookPrice'],
            $data['Description'],
            $data['BookImage'],
            $data['SubcategoryNo'],
            $id
        ]);
    }

    public static function deleteBook($id) {
        $query = "DELETE FROM book WHERE BookNo = ?";
        $stmt = self::$db->prepare($query);
        return $stmt->execute([$id]);
    }

    public static function formatPrice($price) {
        return 'RM ' . number_format($price, 2);
    }

    public static function getBookImage($book) {
        return !empty($book['BookImage']) ? $book['BookImage'] : '../upload/bookPfp/BookCoverUnavailable.webp';
    }

    public static function getBookCount() {
        $query = "SELECT COUNT(*) as count FROM book";
        $stmt = self::$db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }
} 