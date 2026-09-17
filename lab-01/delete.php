<?php

require_once "db.php";

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {

    $id = (int) $_GET["id"];

    $stmt = $conn->prepare(
        "DELETE FROM tasks WHERE id = ?"
    );

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $stmt->close();
}

$conn->close();

header("Location: index.php");

exit;

?>