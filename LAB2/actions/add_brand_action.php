<?php
require_once __DIR__ . '/../core/core.php';
require_admin();
require_once __DIR__ . '/../controllers/ProductController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/admin/brand.php');
}

$controller = new ProductController();
$name = $_POST['brand_name'] ?? '';
$result = $controller->saveBrand($name);

if ($result['success']) {
    $_SESSION['success'] = $result['message'];
} else {
    $_SESSION['error'] = $result['error'];
}

redirect('../views/admin/brand.php');
