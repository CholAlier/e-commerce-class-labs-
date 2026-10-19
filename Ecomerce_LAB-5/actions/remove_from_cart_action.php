<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(APP_BASE . '/views/cart.php');
}

$products = $_POST['remove'] ?? [];
if (!is_array($products)) {
    $_SESSION['cart_notice'] = 'Please select valid cart items to remove.';
    redirect(APP_BASE . '/views/cart.php');
}

$controller = new CartController();
$removedAny = false;
$invalidSelection = false;
foreach ($products as $productId) {
    $productId = is_string($productId)
        ? filter_var($productId, FILTER_VALIDATE_INT)
        : false;
    if ($productId === false || $productId === null || $productId < 1) {
        $invalidSelection = true;
        continue;
    }
    $removedAny = $controller->removeFromCart($productId, get_ip()) || $removedAny;
}

if ($removedAny) {
    $_SESSION['cart_notice'] = 'Selected item(s) removed from your cart.';
} elseif ($invalidSelection) {
    $_SESSION['cart_notice'] = 'One or more selected cart items were invalid.';
} else {
    $_SESSION['cart_notice'] = 'Select at least one item to remove.';
}

redirect(APP_BASE . '/views/cart.php');
