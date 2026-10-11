<?php
require_once __DIR__ . '/../core/core.php';
require_admin();
require_once __DIR__ . '/../controllers/ProductController.php';

function save_product_image($file) {
    if (!is_array($file) || !isset($file['tmp_name'])) {
        return false;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $mimeMap = [
        'image/jpeg' => 'jpg',
        'image/jpg' => 'jpg',
        'image/pjpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
    ];

    $mimeType = strtolower($file['type'] ?? '');
    if (!isset($mimeMap[$mimeType])) {
        return false;
    }

    if (!is_uploaded_file($file['tmp_name'])) {
        return false;
    }

    $ext = $mimeMap[$mimeType];
    $targetDir = __DIR__ . '/../images/products';
    if (!is_dir($targetDir) && !mkdir($targetDir, 0777, true) && !is_dir($targetDir)) {
        return false;
    }

    $filename = 'product_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $targetPath = $targetDir . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        return false;
    }

    return $filename;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(APP_BASE . '/views/admin/product.php');
}

$controller = new ProductController();
$cat = filter_var($_POST['product_cat'] ?? null, FILTER_VALIDATE_INT);
$brand = filter_var($_POST['product_brand'] ?? null, FILTER_VALIDATE_INT);
$title = isset($_POST['product_title']) && is_string($_POST['product_title'])
    ? trim(strip_tags($_POST['product_title']))
    : '';
$price = filter_var($_POST['product_price'] ?? null, FILTER_VALIDATE_FLOAT);
$description = isset($_POST['product_desc']) && is_string($_POST['product_desc'])
    ? trim(strip_tags($_POST['product_desc']))
    : '';
$keywords = isset($_POST['product_keywords']) && is_string($_POST['product_keywords'])
    ? trim(strip_tags($_POST['product_keywords']))
    : '';

if ($cat === false || $cat <= 0 || $brand === false || $brand <= 0 || $title === '' || $price === false || $price <= 0) {
    $_SESSION['error'] = 'Please provide valid product details.';
    redirect(APP_BASE . '/views/admin/product.php');
}

$imageFile = $_FILES['product_image'] ?? null;
if (!is_array($imageFile) || !isset($imageFile['tmp_name']) || $imageFile['error'] === UPLOAD_ERR_NO_FILE) {
    $_SESSION['error'] = 'Please upload a product image.';
    redirect(APP_BASE . '/views/admin/product.php');
}

$imageName = save_product_image($imageFile);
if ($imageName === false) {
    $_SESSION['error'] = 'The product image must be a valid JPG, PNG, GIF, or WebP file.';
    redirect(APP_BASE . '/views/admin/product.php');
}

$result = $controller->addProduct($cat, $brand, $title, $price, $description, $imageName, $keywords);
if ($result['success']) {
    $_SESSION['success'] = $result['message'];
} else {
    $_SESSION['error'] = $result['error'];
}

redirect(APP_BASE . '/views/admin/product.php');
