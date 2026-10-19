<?php
require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/CartController.php';

$headerCartController = new CartController();
$headerCartIp = get_ip();
$headerCartCount = $headerCartController->getCartCount($headerCartIp);
$headerCartTotal = $headerCartController->getCartTotal($headerCartIp);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="<?= htmlspecialchars(APP_BASE) ?>/css/style.css">
</head>
<body>
<header>
    <nav>
        <a href="<?= htmlspecialchars(APP_BASE) ?>/index.php">Home</a>
        <?php if (is_admin()): ?>
            <a href="<?= htmlspecialchars(APP_BASE) ?>/views/admin/dashboard.php">Admin Dashboard</a>
            <a href="<?= htmlspecialchars(APP_BASE) ?>/views/admin/brand.php">Brands</a>
            <a href="<?= htmlspecialchars(APP_BASE) ?>/views/admin/category.php">Categories</a>
            <a href="<?= htmlspecialchars(APP_BASE) ?>/views/admin/product.php">Products</a>
        <?php endif; ?>

        <?php if (!is_logged_in()): ?>
            <a href="<?= htmlspecialchars(APP_BASE) ?>/views/register.php">Register</a>
            <a href="<?= htmlspecialchars(APP_BASE) ?>/views/login.php">Login</a>
        <?php else: ?>
            <span>Welcome <?= htmlspecialchars($_SESSION['customer_name']) ?></span>
            <a href="<?= htmlspecialchars(APP_BASE) ?>/views/account/my_account.php">My Account</a>
            <a href="<?= htmlspecialchars(APP_BASE) ?>/logout.php">Logout</a>
        <?php endif; ?>

        <form class="search" action="<?= htmlspecialchars(APP_BASE) ?>/views/search_results.php" method="GET">
            <input type="text" name="user_query" placeholder="Search products">
            <button type="submit">Search</button>
        </form>

        <div class="cart-summary">
            <div class="cart-summary-top">
                <svg class="cart-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
                <span class="cart-title">Shopping Cart</span>
            </div>
            <div class="cart-summary-bottom">
                <span class="cart-meta"><?= (int)$headerCartCount ?> item<?= $headerCartCount != 1 ? 's' : '' ?> &middot; $<?= number_format($headerCartTotal, 2) ?></span>
                <a href="<?= htmlspecialchars(APP_BASE) ?>/views/cart.php" class="cart-btn">Cart &rarr;</a>
            </div>
        </div>
    </nav>
</header>
<main class="container">
<?php if (!empty($_SESSION['cart_notice'])): ?>
    <p class="cart-notice"><?= htmlspecialchars($_SESSION['cart_notice']); unset($_SESSION['cart_notice']); ?></p>
<?php endif; ?>
