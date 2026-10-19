<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

if (!isset($_GET['pro_id']) || !ctype_digit($_GET['pro_id'])) {
    redirect('../index.php');
}

$controller = new ProductController();
$product = $controller->getProductById((int)$_GET['pro_id']);

if (!$product) {
    redirect('../index.php');
}
?>
<?php include __DIR__ . '/layout/header.php'; ?>

<h1><?= htmlspecialchars($product['product_title']) ?></h1>

<?php if (!empty($product['product_image'])): ?>
    <img class="product-detail" src="../images/products/<?= htmlspecialchars($product['product_image']) ?>" alt="<?= htmlspecialchars($product['product_title']) ?>">
<?php endif; ?>

<p>Category: <?= htmlspecialchars($product['cat_name'] ?? '') ?></p>
<p>Brand: <?= htmlspecialchars($product['brand_name'] ?? '') ?></p>
<p>Price: $<?= number_format((float)$product['product_price'], 2) ?></p>
<p><?= nl2br(htmlspecialchars($product['product_desc'] ?? '')) ?></p>
<p>Keywords: <?= htmlspecialchars($product['product_keywords'] ?? '') ?></p>
<a class="btn btn-primary btn-large" href="<?= htmlspecialchars(APP_BASE) ?>/actions/add_to_cart_action.php?add_cart=<?= (int)$product['product_id'] ?>">Add to Cart</a>

<?php include __DIR__ . '/layout/footer.php'; ?>
