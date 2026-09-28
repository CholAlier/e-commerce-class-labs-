<?php
require_once __DIR__ . '/../../core/core.php';
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
    </nav>

    <form class="search" action="<?= htmlspecialchars(APP_BASE) ?>/views/search_results.php" method="GET">
        <input type="text" name="user_query" placeholder="Search products">
        <button type="submit">Search</button>
    </form>
</header>
<main class="container">
