<?php
require_once "db.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Invalid task ID.");
}

$id = (int) $_GET["id"];

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $status = $_POST["status"] ?? "pending";
    $post_id = (int) ($_POST["id"] ?? 0);

    $allowed_statuses = ["pending", "in_progress", "done"];

    if ($title === "") {

        $error = "Title is required.";

    } elseif (!in_array($status, $allowed_statuses, true)) {

        $error = "Invalid status.";

    } else {

        $stmt = $conn->prepare(
            "UPDATE tasks
             SET title=?, description=?, status=?
             WHERE id=?"
        );

        $stmt->bind_param(
            "sssi",
            $title,
            $description,
            $status,
            $post_id
        );

        $stmt->execute();

        $stmt->close();
        $conn->close();

        header("Location: index.php");
        exit;
    }
}

$stmt = $conn->prepare(
    "SELECT * FROM tasks WHERE id = ?"
);

$stmt->bind_param("i", $id);

$stmt->execute();

$task = $stmt->get_result()->fetch_assoc();

$stmt->close();

if (!$task) {

    $conn->close();

    die("Task not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Task</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <h1>Edit Task</h1>

    <div class="form-card">

        <?php if ($error): ?>

            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <input
                type="hidden"
                name="id"
                value="<?php echo $task["id"]; ?>"
            >

            <div class="form-group">

                <label for="title">
                    Title
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="<?php echo htmlspecialchars($task["title"]); ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label for="description">
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                ><?php echo htmlspecialchars($task["description"] ?? ""); ?></textarea>

            </div>

            <div class="form-group">

                <label for="status">
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                >

                    <option
                        value="pending"
                        <?php echo $task["status"] === "pending" ? "selected" : ""; ?>
                    >
                        Pending
                    </option>

                    <option
                        value="in_progress"
                        <?php echo $task["status"] === "in_progress" ? "selected" : ""; ?>
                    >
                        In Progress
                    </option>

                    <option
                        value="done"
                        <?php echo $task["status"] === "done" ? "selected" : ""; ?>
                    >
                        Done
                    </option>

                </select>

            </div>

            <button
                type="submit"
                class="btn"
            >
                Update Task
            </button>

        </form>

        <a href="index.php" class="back-link">
            ← Back to Tasks
        </a>

    </div>

</div>

</body>
</html>

<?php
$conn->close();
?>