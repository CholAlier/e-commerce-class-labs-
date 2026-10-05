<?php
require_once __DIR__ . '/../core/core.php';
require_admin();
require_once __DIR__ . '/../controllers/ProductController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/admin/category.php');
}

$controller = new ProductController();
$name = isset($_POST['cat_name']) && is_string($_POST['cat_name'])
    ? trim(strip_tags($_POST['cat_name']))
    : '';
$result = $controller->addCategory($name);

if ($result['success']) {
    $_SESSION['success'] = $result['message'];
} else {
    $_SESSION['error'] = $result['error'];
}

redirect('../views/admin/category.php');
