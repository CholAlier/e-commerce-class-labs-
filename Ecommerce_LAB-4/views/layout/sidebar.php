<?php
require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/ProductController.php';
$sidebarController = new ProductController();
$categories = $sidebarController->getAllCategories();
$brands = $sidebarController->getAllBrands();
?>
<aside>
    <h3>Categories</h3>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li><a href="<?= htmlspecialchars(APP_BASE) ?>/index.php?cat=<?= (int)$category['cat_id'] ?>">
                <?= htmlspecialchars($category['cat_name']) ?>
            </a></li>
        <?php endforeach; ?>
    </ul>

    <h3>Brands</h3>
    <ul>
        <?php foreach ($brands as $brand): ?>
            <li><a href="<?= htmlspecialchars(APP_BASE) ?>/index.php?brand=<?= (int)$brand['brand_id'] ?>">
                <?= htmlspecialchars($brand['brand_name']) ?>
            </a></li>
        <?php endforeach; ?>
    </ul>
</aside>
