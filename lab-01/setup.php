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

$sql = "CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('pending', 'in_progress', 'done') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) !== TRUE) {
    die("Error creating table: " . htmlspecialchars($conn->error));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="setup">
    <a href="index.php" class="btn">Go to Tasks App</a>
</div>

</body>
</html>

<?php
$conn->close();
?>