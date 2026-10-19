<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(APP_BASE . '/views/cart.php');
}

$quantities = $_POST['qty'] ?? [];
$products = $_POST['update'] ?? [];
if (!is_array($quantities) || !is_array($products)) {
    $_SESSION['cart_notice'] = 'Please provide valid quantities.';
    redirect(APP_BASE . '/views/cart.php');
}

$controller = new CartController();
$updatedAny = false;
$invalidQuantity = false;
foreach ($products as $key => $productId) {
    $rawQuantity = $quantities[$key] ?? null;
    $productId = is_string($productId)
        ? filter_var($productId, FILTER_VALIDATE_INT)
        : false;
    $quantity = is_string($rawQuantity)
        ? filter_var($rawQuantity, FILTER_VALIDATE_INT)
        : false;
    if (
        $productId === false || $productId === null || $productId < 1
        || $quantity === false || $quantity === null || $quantity < 1
    ) {
        $invalidQuantity = true;
        continue;
    }

    $updatedAny = $controller->updateQty($productId, $quantity, get_ip()) || $updatedAny;
}

if ($invalidQuantity) {
    $_SESSION['cart_notice'] = 'Quantities must be positive whole numbers; invalid entries were not updated.';
} elseif ($updatedAny) {
    $_SESSION['cart_notice'] = 'Cart quantities updated.';
} else {
    $_SESSION['cart_notice'] = 'No cart quantities were updated.';
}

redirect(APP_BASE . '/views/cart.php');
