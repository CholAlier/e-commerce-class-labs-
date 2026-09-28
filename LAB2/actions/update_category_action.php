<?php
require_once __DIR__ . '/../core/core.php';
require_admin();
require_once __DIR__ . '/../controllers/ProductController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/admin/category.php');
}

$id = filter_var($_POST['cat_id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id <= 0) {
    $_SESSION['error'] = 'Invalid category.';
    redirect('../views/admin/category.php');
}

$controller = new ProductController();
$name = $_POST['cat_name'] ?? '';
$result = $controller->saveCategory($name, $id);

if ($result['success']) {
    $_SESSION['success'] = $result['message'];
} else {
    $_SESSION['error'] = $result['error'];
}

redirect('../views/admin/category.php');
