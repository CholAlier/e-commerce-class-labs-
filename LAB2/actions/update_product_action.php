<?php
require_once __DIR__ . '/../core/core.php';
require_admin();
require_once __DIR__ . '/../controllers/ProductController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/admin/product.php');
}

$id = filter_var($_POST['product_id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id <= 0) {
    $_SESSION['error'] = 'Invalid product.';
    redirect('../views/admin/product.php');
}

$controller = new ProductController();
$result = $controller->saveProduct($_POST, $_FILES['product_image'] ?? null, $id);

if ($result['success']) {
    $_SESSION['success'] = $result['message'];
} else {
    $_SESSION['error'] = $result['error'];
}

redirect('../views/admin/product.php');
