<?php
require_once __DIR__ . '/../../core/core.php';
require_admin();
require_once __DIR__ . '/../../controllers/ProductController.php';

$controller = new ProductController();
$edit = false;
$product = null;

if (isset($_GET['edit_id']) && ctype_digit($_GET['edit_id'])) {
    $product = $controller->getProductById((int)$_GET['edit_id']);
    $edit = (bool)$product;
}

$products = $controller->getAllProducts();
$categories = $controller->getAllCategories();
$brands = $controller->getAllBrands();
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
        <input type="hidden" name="product_id" value="<?= (int)($product['product_id'] ?? 0) ?>">
    <?php endif; ?>

    <label>
        Category
        <select name="product_cat" required>
            <option value="">Select category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= (int)$category['cat_id'] ?>" <?= (($product['product_cat'] ?? '') == $category['cat_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['cat_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label>
        Brand
        <select name="product_brand" required>
            <option value="">Select brand</option>
            <?php foreach ($brands as $brand): ?>
                <option value="<?= (int)$brand['brand_id'] ?>" <?= (($product['product_brand'] ?? '') == $brand['brand_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($brand['brand_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label>
        Product title
        <input type="text" name="product_title" value="<?= htmlspecialchars($product['product_title'] ?? '') ?>" required>
    </label>

    <label>
        Price
        <input type="number" step="0.01" min="0.01" name="product_price" value="<?= htmlspecialchars((string)($product['product_price'] ?? '')) ?>" required>
    </label>

    <label>
        Description
        <textarea name="product_desc" rows="5"><?= htmlspecialchars($product['product_desc'] ?? '') ?></textarea>
    </label>

    <label>
        Keywords
        <input type="text" name="product_keywords" value="<?= htmlspecialchars($product['product_keywords'] ?? '') ?>">
    </label>

    <label>
        Product image
        <input type="file" name="product_image" accept="image/*">
    </label>

    <?php if ($edit && !empty($product['product_image'])): ?>
        <div>
            <img src="<?= htmlspecialchars(APP_BASE) ?>/images/products/<?= htmlspecialchars($product['product_image']) ?>" alt="Current product image" style="max-width: 180px; display: block; margin-top: 10px;">
        </div>
    <?php endif; ?>

    <button type="submit"><?= $edit ? 'Update' : 'Add' ?> Product</button>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Category</th>
        <th>Brand</th>
        <th>Price</th>
        <th>Action</th>
    </tr>
    <?php foreach ($products as $item): ?>
        <tr>
            <td><?= (int)$item['product_id'] ?></td>
            <td><?= htmlspecialchars($item['product_title']) ?></td>
            <td><?= htmlspecialchars($item['cat_name'] ?? '') ?></td>
            <td><?= htmlspecialchars($item['brand_name'] ?? '') ?></td>
            <td>$<?= number_format((float)$item['product_price'], 2) ?></td>
            <td><a href="product.php?edit_id=<?= (int)$item['product_id'] ?>">Edit</a></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include __DIR__ . '/../layout/footer.php'; ?>
