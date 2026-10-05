<?php
require_once __DIR__ . '/../../core/core.php';
require_admin();
require_once __DIR__ . '/../../controllers/ProductController.php';

$controller = new ProductController();
$edit = false;
$brand = null;

if (isset($_GET['edit_id']) && ctype_digit($_GET['edit_id'])) {
    $brand = $controller->getBrandById((int)$_GET['edit_id']);
    $edit = (bool)$brand;
}

$brands = $controller->getAllBrands();
?>
<?php include __DIR__ . '/../layout/header.php'; ?>

<h1><?= $edit ? 'Edit Brand' : 'Add Brand' ?></h1>

<?php if (isset($_SESSION['success'])): ?>
    <p class="success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></p>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <p class="error"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form action="../../actions/<?= $edit ? 'update' : 'add' ?>_brand_action.php" method="POST">
    <?php if ($edit): ?>
        <input type="hidden" name="brand_id" value="<?= (int)$brand['brand_id'] ?>">
    <?php endif; ?>
    <input type="text" name="brand_name" value="<?= htmlspecialchars($brand['brand_name'] ?? '') ?>" required>
    <button type="submit"><?= $edit ? 'Update' : 'Add' ?> Brand</button>
</form>

<table>
    <tr><th>ID</th><th>Brand</th><th>Action</th></tr>
    <?php foreach ($brands as $item): ?>
        <tr>
            <td><?= (int)$item['brand_id'] ?></td>
            <td><?= htmlspecialchars($item['brand_name']) ?></td>
            <td><a href="brand.php?edit_id=<?= (int)$item['brand_id'] ?>">Edit</a></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include __DIR__ . '/../layout/footer.php'; ?>
