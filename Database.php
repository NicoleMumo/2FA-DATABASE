<?php
class Database {
    private $db_path;
    public $conn;

    public function __construct() {
        $this->db_path = __DIR__ . '/database.sqlite';
    }

    public function getConnection() {
        $this->conn = null;
        try {
            if (!class_exists('PDO') || !in_array('sqlite', PDO::getAvailableDrivers(), true)) {
                throw new PDOException('SQLite PDO driver is not available.');
            }

            $this->conn = new PDO('sqlite:' . $this->db_path);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec(
                "CREATE TABLE IF NOT EXISTS users (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    username TEXT NOT NULL,
                    email TEXT NOT NULL,
                    password TEXT NOT NULL,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )"
            );
        } catch (PDOException $exception) {
            echo 'Connection error: ' . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
