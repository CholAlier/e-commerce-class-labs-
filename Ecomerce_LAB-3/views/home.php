<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$controller = new ProductController();

if (isset($_GET['cat']) && ctype_digit($_GET['cat'])) {
    $products = $controller->getProductsByCategory((int)$_GET['cat']);
} elseif (isset($_GET['brand']) && ctype_digit($_GET['brand'])) {
    $products = $controller->getProductsByBrand((int)$_GET['brand']);
} else {
    $products = $controller->getFeaturedProducts();
}
?>
<?php include __DIR__ . '/layout/header.php'; ?>

<div class="layout">
    <div>
        <?php if (isset($_SESSION['error'])): ?>
            <p class="error"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
        <?php endif; ?>
        <div class="grid">
            <?php if (!$products): ?>
                <p>No products found.</p>
            <?php endif; ?>

            <?php foreach ($products as $product): ?>
                <article class="card">
                    <?php if (!empty($product['product_image'])): ?>
                        <img src="images/products/<?= htmlspecialchars($product['product_image']) ?>"
                             alt="<?= htmlspecialchars($product['product_title']) ?>">
                    <?php endif; ?>
                    <h2><?= htmlspecialchars($product['product_title']) ?></h2>
                    <p>$<?= number_format((float)$product['product_price'], 2) ?></p>
                    <a href="views/single_product.php?pro_id=<?= (int)$product['product_id'] ?>">Details</a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>

    <div>
        <?php include __DIR__ . '/layout/sidebar.php'; ?>
    </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>
