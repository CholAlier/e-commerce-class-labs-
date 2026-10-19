<?php
require_once __DIR__ . '/db_cred.php';

class Database {
    protected $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->conn->connect_error) {
            if (function_exists('log_error')) {
                log_error($this->conn->connect_error);
            } else {
                error_log($this->conn->connect_error);
            }
            die('Connection failed.');
        }

        $this->conn->set_charset('utf8mb4');
    }

    protected function resultToArray(mysqli_result $result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    protected function stmtFetchAssoc(mysqli_stmt $stmt) {
        $result = $stmt->get_result();
        return $result ? $result->fetch_assoc() : false;
    }

    protected function stmtFetchAllAssoc(mysqli_stmt $stmt) {
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
