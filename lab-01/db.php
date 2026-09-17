<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

mysqli_report(MYSQLI_REPORT_OFF);

$host = "localhost";
$db_user = "chol.thiong";
$db_pass = "092693555.C";
$db_name = "ecommerce_2026A_chol_thiong";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_errno) {
    die("Database connection failed: " . htmlspecialchars($conn->connect_error));
}

$conn->set_charset("utf8mb4");

?>