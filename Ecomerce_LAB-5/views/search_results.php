<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$query = trim($_GET['user_query'] ?? '');
$controller = new ProductController();
$products = $query === '' ? [] : $controller->searchProducts($query);
?>
<?php include __DIR__ . '/layout/header.php'; ?>

<h1>Search Results</h1>
<p>Search: <?= htmlspecialchars($query) ?></p>

<div class="grid">
    <?php if (!$products): ?>
        <p>No products found.</p>
    <?php endif; ?>

    <?php foreach ($products as $product): ?>
        <article class="card">
            <div class="card-img-wrap">
                <?php if (!empty($product['product_image'])): ?>
                    <img src="../images/products/<?= htmlspecialchars($product['product_image']) ?>" alt="<?= htmlspecialchars($product['product_title']) ?>">
                <?php else: ?>
                    <div class="card-img-placeholder">No Image</div>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <h2 class="card-title"><?= htmlspecialchars($product['product_title']) ?></h2>
                <p class="card-price">$<?= number_format((float)$product['product_price'], 2) ?></p>
                <div class="card-actions">
                    <a class="btn btn-outline" href="single_product.php?pro_id=<?= (int)$product['product_id'] ?>">Details</a>
                    <a class="btn btn-primary" href="<?= htmlspecialchars(APP_BASE) ?>/actions/add_to_cart_action.php?add_cart=<?= (int)$product['product_id'] ?>">Add to Cart</a>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>
