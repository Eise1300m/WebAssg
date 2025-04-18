<?php
/**
 * A utility class to handle pagination for database queries
 */
class PaginationHelper {
    private static $_instance = null;
    private $_db = null;
    
    private function __construct($db) {
        $this->_db = $db;
    }
    
    /**
     * Initialize with database connection
     */
    public static function init($db) {
        if (self::$_instance === null) {
            self::$_instance = new self($db);
        }
    }
    
    public static function getInstance() {
        if (self::$_instance === null) {
            throw new Exception("PaginationHelper is not initialized. Call init() first.");
        }
        return self::$_instance;
    }
    
    /**
     * Paginate a SQL query
     * 
     * @param string $baseQuery The base SQL query without ORDER BY or LIMIT
     * @param string $orderBy The ORDER BY clause
     * @param array $params Parameters for the prepared statement
     * @param int $page Current page number
     * @param int $itemsPerPage Number of items per page
     * @param string $countField Field to count for total items (defaults to *)
     * @return array Contains 'items', 'totalItems', 'totalPages', 'currentPage'
     */
    public function paginate($baseQuery, $orderBy, $params = [], $page = 1, $itemsPerPage = 10, $countField = '*') {
        // Ensure page is at least 1
        $page = max(1, intval($page));
        $itemsPerPage = max(1, intval($itemsPerPage));
        
        // Get total count
        $countQuery = "SELECT COUNT($countField) as total FROM (" . $baseQuery . ") as count_table";
        $stmt = $this->_db->prepare($countQuery);
        $stmt->execute($params);
        $totalItems = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Calculate total pages
        $totalPages = ceil($totalItems / $itemsPerPage);
        
        // Calculate offset
        $offset = ($page - 1) * $itemsPerPage;
        
        // Get paginated items
        $fullQuery = $baseQuery . " " . $orderBy . " LIMIT " . $offset . ", " . $itemsPerPage;
        $stmt = $this->_db->prepare($fullQuery);
        $stmt->execute($params);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            'items' => $items,
            'totalItems' => $totalItems,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'itemsPerPage' => $itemsPerPage
        ];
    }
    
    /**
     * Generate pagination links HTML
     * 
     * @param int $currentPage Current page number
     * @param int $totalPages Total number of pages
     * @param string $urlPattern URL pattern with :page placeholder
     * @param int $maxLinks Maximum number of page links to show (excluding first/last/prev/next)
     * @return string HTML for pagination links
     */
    public function generatePaginationLinks($currentPage, $totalPages, $urlPattern, $maxLinks = 5) {
        if ($totalPages <= 1) {
            return ''; // No pagination needed
        }
        
        $html = '<div class="pagination">';
        
        // Previous link
        if ($currentPage > 1) {
            $html .= '<a href="' . str_replace(':page', ($currentPage - 1), $urlPattern) . '" class="page-link prev">&laquo;</a>';
        } else {
            $html .= '<span class="page-link disabled">&laquo;</span>';
        }
        
        // Calculate range of page links to show
        $startPage = max(1, $currentPage - floor($maxLinks / 2));
        $endPage = min($totalPages, $startPage + $maxLinks - 1);
        
        // Adjust start if we're near the end
        if ($endPage - $startPage + 1 < $maxLinks) {
            $startPage = max(1, $endPage - $maxLinks + 1);
        }
        
        // First page link (if not in range)
        if ($startPage > 1) {
            $html .= '<a href="' . str_replace(':page', 1, $urlPattern) . '" class="page-link">1</a>';
            if ($startPage > 2) {
                $html .= '<span class="page-link dots">...</span>';
            }
        }
        
        // Page links
        for ($i = $startPage; $i <= $endPage; $i++) {
            if ($i === $currentPage) {
                $html .= '<span class="page-link current">' . $i . '</span>';
            } else {
                $html .= '<a href="' . str_replace(':page', $i, $urlPattern) . '" class="page-link">' . $i . '</a>';
            }
        }
        
        // Last page link (if not in range)
        if ($endPage < $totalPages) {
            if ($endPage < $totalPages - 1) {
                $html .= '<span class="page-link dots">...</span>';
            }
            $html .= '<a href="' . str_replace(':page', $totalPages, $urlPattern) . '" class="page-link">' . $totalPages . '</a>';
        }
        
        // Next link
        if ($currentPage < $totalPages) {
            $html .= '<a href="' . str_replace(':page', ($currentPage + 1), $urlPattern) . '" class="page-link next">&raquo;</a>';
        } else {
            $html .= '<span class="page-link disabled">&raquo;</span>';
        }
        
        $html .= '</div>';
        
        return $html;
    }
}
?> 