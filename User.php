<?php
class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        if ($this->conn === null) {
            return null;
        }

        $query = 'SELECT id, username, email, created_at FROM users ORDER BY created_at DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
