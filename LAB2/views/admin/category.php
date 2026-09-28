<?php
require_once __DIR__ . '/../../core/core.php';
require_admin();
require_once __DIR__ . '/../../controllers/ProductController.php';

$controller = new ProductController();
$edit = false;
$category = null;

if (isset($_GET['edit_id']) && ctype_digit($_GET['edit_id'])) {
    $category = $controller->getCategoryById((int)$_GET['edit_id']);
    $edit = (bool)$category;
}

$categories = $controller->getAllCategories();
?>
<?php include __DIR__ . '/../layout/header.php'; ?>

<h1><?= $edit ? 'Edit Category' : 'Add Category' ?></h1>

<?php if (isset($_SESSION['success'])): ?>
    <p class="success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></p>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <p class="error"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form action="../../actions/<?= $edit ? 'update' : 'add' ?>_category_action.php" method="POST">
    <?php if ($edit): ?>
        <input type="hidden" name="cat_id" value="<?= (int)$category['cat_id'] ?>">
    <?php endif; ?>
    <input type="text" name="cat_name" value="<?= htmlspecialchars($category['cat_name'] ?? '') ?>" required>
    <button type="submit"><?= $edit ? 'Update' : 'Add' ?> Category</button>
</form>

<table>
    <tr><th>ID</th><th>Category</th><th>Action</th></tr>
    <?php foreach ($categories as $item): ?>
        <tr>
            <td><?= (int)$item['cat_id'] ?></td>
            <td><?= htmlspecialchars($item['cat_name']) ?></td>
            <td><a href="category.php?edit_id=<?= (int)$item['cat_id'] ?>">Edit</a></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include __DIR__ . '/../layout/footer.php'; ?>
