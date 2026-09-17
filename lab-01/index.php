<?php
require_once "db.php";

$result = $conn->query("SELECT * FROM tasks ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tasks</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>My Tasks</h1>
            <a class="btn" href="create.php">+ Add Task</a>
        </div>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="task">
                <h2><?php echo htmlspecialchars($row["title"]); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($row["description"] ?? "")); ?></p>
                <p class="status">Status: <?php echo htmlspecialchars($row["status"]); ?></p>
                <p>Created: <?php echo htmlspecialchars($row["created_at"]); ?></p>
                <div class="actions">
                    <a class="edit-link" href="edit.php?id=<?php echo $row["id"]; ?>">Edit</a>
                    <a class="delete-link" href="delete.php?id=<?php echo $row["id"]; ?>"
                       onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="empty">
            <p>No tasks found.</p>
            <a href="create.php">Create your first task</a>
        </div>
    <?php endif; ?>
    </div>
</body>
</html>
<?php $conn->close(); ?>
