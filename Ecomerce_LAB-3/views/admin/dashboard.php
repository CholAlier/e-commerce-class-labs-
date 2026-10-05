<?php
require_once __DIR__ . '/../../core/core.php';
require_admin();
require_once __DIR__ . '/../../controllers/ProductController.php';

$controller = new ProductController();
$stats = $controller->getAdminDashboardStats();
?>
<?php include __DIR__ . '/../layout/header.php'; ?>

<section class="admin-dashboard">
    <div class="dashboard-heading">
        <div>
            <p class="dashboard-eyebrow">SHOPPN ADMIN</p>
            <h1>Admin Dashboard</h1>
            <p>Welcome, <?= htmlspecialchars($_SESSION['customer_name']) ?>. Manage your store from here.</p>
        </div>
    </div>

    <div class="dashboard-stats" aria-label="Store overview">
        <article class="stat-card">
            <span class="stat-label">Brands</span>
            <strong><?= (int)$stats['brand_count'] ?></strong>
        </article>
        <article class="stat-card">
            <span class="stat-label">Categories</span>
            <strong><?= (int)$stats['category_count'] ?></strong>
        </article>
        <article class="stat-card">
            <span class="stat-label">Customer Accounts</span>
            <strong><?= (int)$stats['customer_count'] ?></strong>
        </article>
    </div>

    <section class="dashboard-section">
        <h2>Store management</h2>
        <div class="dashboard-actions">
            <a class="dashboard-action-card" href="category.php">
                <strong>Categories</strong>
                <span>Create and update product categories.</span>
            </a>
            <a class="dashboard-action-card" href="brand.php">
                <strong>Brands</strong>
                <span>Create and update the brands in your catalog.</span>
            </a>
        </div>
    </section>

</section>

<?php include __DIR__ . '/../layout/footer.php'; ?>