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
    <img class="product-detail" src="../images/products/<?= htmlspecialchars($product['product_image']) ?>" alt="">
<?php endif; ?>

<p>Category: <?= htmlspecialchars($product['cat_name'] ?? '') ?></p>
<p>Brand: <?= htmlspecialchars($product['brand_name'] ?? '') ?></p>
<p>Price: $<?= number_format((float)$product['product_price'], 2) ?></p>
<p><?= nl2br(htmlspecialchars($product['product_desc'] ?? '')) ?></p>
<p>Keywords: <?= htmlspecialchars($product['product_keywords'] ?? '') ?></p>

<?php include __DIR__ . '/layout/footer.php'; ?>
