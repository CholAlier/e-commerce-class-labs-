<?php

require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $status = $_POST["status"] ?? "pending";

    if ($title === "") {
        die("Title is required.");
    }

    $allowed_statuses = ["pending", "in_progress", "done"];

    if (!in_array($status, $allowed_statuses, true)) {
        die("Invalid status.");
    }

    $sql = "INSERT INTO tasks (title, description, status) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("SQL prepare failed: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("sss", $title, $description, $status);

    if (!$stmt->execute()) {
        die("SQL execute failed: " . htmlspecialchars($stmt->error));
    }

    $stmt->close();

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Task</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="form-container">

    <div class="form-header">
        <h1>Add Task</h1>
        <p>Create a new task and keep track of your progress.</p>
    </div>

    <form method="POST">

        <div class="form-group">
            <label for="title">Title</label>

            <input
                type="text"
                id="title"
                name="title"
                placeholder="Enter task title"
                required
            >
        </div>

        <div class="form-group">
            <label for="description">Description</label>

            <textarea
                id="description"
                name="description"
                rows="5"
                placeholder="Enter task description"
            ></textarea>
        </div>

        <div class="form-group">
            <label for="status">Status</label>

            <select id="status" name="status">
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="done">Done</option>
            </select>
        </div>

        <div class="form-actions">

            <a href="index.php" class="back-link">
                Back to Tasks
            </a>

            <button type="submit" class="btn">
                Add Task
            </button>

        </div>

    </form>

</div>

</body>
</html>