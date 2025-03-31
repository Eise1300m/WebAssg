<?php
class DatabaseHelper {
    private static $instance = null;
    private $db;

    private function __construct($db) {
        $this->db = $db;
    }

    public static function getInstance($db) {
        if (self::$instance === null) {
            self::$instance = new self($db);
        }
        return self::$instance;
    }

    public function query($sql, $params = []) {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            throw $e;
        }
    }

    public function fetch($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($table, $data) {
        $fields = array_keys($data);
        $values = array_fill(0, count($fields), '?');
        $sql = "INSERT INTO $table (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $values) . ")";
        
        $this->query($sql, array_values($data));
        return $this->db->lastInsertId();
    }

    public function update($table, $data, $where, $whereParams = []) {
        $set = array_map(function($field) {
            return "$field = ?";
        }, array_keys($data));
        
        $sql = "UPDATE $table SET " . implode(', ', $set) . " WHERE $where";
        $params = array_merge(array_values($data), $whereParams);
        
        return $this->query($sql, $params);
    }

    public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM $table WHERE $where";
        return $this->query($sql, $params);
    }

    public function beginTransaction() {
        return $this->db->beginTransaction();
    }

    public function commit() {
        return $this->db->commit();
    }

    public function rollBack() {
        return $this->db->rollBack();
    }
} 