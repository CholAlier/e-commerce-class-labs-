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
            <?php if (!empty($product['product_image'])): ?>
                <img src="../images/products/<?= htmlspecialchars($product['product_image']) ?>" alt="">
            <?php endif; ?>
            <h2><?= htmlspecialchars($product['product_title']) ?></h2>
            <p>$<?= number_format((float)$product['product_price'], 2) ?></p>
            <a href="single_product.php?pro_id=<?= (int)$product['product_id'] ?>">Details</a>
        </article>
    <?php endforeach; ?>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>
