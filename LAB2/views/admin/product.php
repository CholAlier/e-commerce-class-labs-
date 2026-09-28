<?php
require_once __DIR__ . '/../../core/core.php';
require_admin();
require_once __DIR__ . '/../../controllers/ProductController.php';

$controller = new ProductController();
$categories = $controller->getAllCategories();
$brands = $controller->getAllBrands();

$edit = false;
$product = null;

if (isset($_GET['edit_id']) && ctype_digit($_GET['edit_id'])) {
    $product = $controller->getProductById((int)$_GET['edit_id']);
    $edit = (bool)$product;
}

?>
<?php include __DIR__ . '/../layout/header.php'; ?>

<h1><?= $edit ? 'Edit Product' : 'Add Product' ?></h1>

<?php if (isset($_SESSION['success'])): ?>
    <p class="success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></p>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <p class="error"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form action="../../actions/<?= $edit ? 'update' : 'add' ?>_product_action.php" method="POST" enctype="multipart/form-data">
    <?php if ($edit): ?>
        <input type="hidden" name="product_id" value="<?= (int)$product['product_id'] ?>">
    <?php endif; ?>

    <label>Product Title
        <input type="text" name="product_title" value="<?= htmlspecialchars($product['product_title'] ?? '') ?>" required>
    </label>

    <label>Price
        <input type="number" step="0.01" name="product_price" value="<?= htmlspecialchars($product['product_price'] ?? '') ?>" required>
    </label>

    <label>Description
        <textarea name="product_desc"><?= htmlspecialchars($product['product_desc'] ?? '') ?></textarea>
    </label>

    <label>Keywords
        <input type="text" name="product_keywords" value="<?= htmlspecialchars($product['product_keywords'] ?? '') ?>">
    </label>

    <label>Category
        <select name="product_cat" required>
            <option value="">Select category</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= (int)$cat['cat_id'] ?>"
                    <?= (($product['product_cat'] ?? '') == $cat['cat_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['cat_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label>Brand
        <select name="product_brand" required>
            <option value="">Select brand</option>
            <?php foreach ($brands as $brand): ?>
                <option value="<?= (int)$brand['brand_id'] ?>"
                    <?= (($product['product_brand'] ?? '') == $brand['brand_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($brand['brand_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label>Product Image
        <input type="file" name="product_image" accept="image/jpeg,image/png,image/gif,image/webp">
    </label>

    <?php if (!empty($product['product_image'])): ?>
        <p>Current image:</p>
        <img class="preview" src="../../images/products/<?= htmlspecialchars($product['product_image']) ?>" alt="Product image">
    <?php endif; ?>

    <button type="submit"><?= $edit ? 'Update' : 'Add' ?> Product</button>
</form>

<?php include __DIR__ . '/../layout/footer.php'; ?>
