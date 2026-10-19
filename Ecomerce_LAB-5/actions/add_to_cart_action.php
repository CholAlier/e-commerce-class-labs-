<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

$returnTo = APP_BASE . '/index.php';
$referer = $_SERVER['HTTP_REFERER'] ?? '';
$refererParts = parse_url($referer);
$currentHost = parse_url('//' . ($_SERVER['HTTP_HOST'] ?? ''), PHP_URL_HOST);

if (
    !preg_match('/[\r\n]/', $referer)
    &&
    is_array($refererParts)
    && isset($refererParts['host'], $refererParts['path'])
    && $currentHost !== false
    && strcasecmp($refererParts['host'], $currentHost) === 0
    && str_starts_with($refererParts['path'], '/')
) {
    $returnTo = $refererParts['path'];
    if (isset($refererParts['query'])) {
        $returnTo .= '?' . $refererParts['query'];
    }
}

$rawProductId = $_GET['add_cart'] ?? null;
$productId = is_string($rawProductId)
    ? filter_var($rawProductId, FILTER_VALIDATE_INT)
    : false;
if ($productId === false || $productId === null || $productId < 1) {
    $_SESSION['cart_notice'] = 'Please select a valid product to add to your cart.';
    redirect($returnTo);
}

$controller = new CartController();
$ip = get_ip();

if ($controller->isInCart($productId, $ip)) {
    $_SESSION['cart_notice'] = 'This item is already in your cart. Go to cart to update quantity.';
    redirect($returnTo);
}

if ($controller->addToCart($productId, 1, $ip, $_SESSION['customer_id'] ?? null)) {
    $_SESSION['cart_notice'] = 'Item added to your cart.';
} else {
    $_SESSION['cart_notice'] = 'Unable to add this item to your cart.';
}

redirect($returnTo);
