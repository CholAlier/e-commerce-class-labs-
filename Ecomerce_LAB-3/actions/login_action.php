<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CustomerController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(APP_BASE . '/views/login.php');
}

$email = isset($_POST['customer_email']) && is_string($_POST['customer_email'])
    ? trim($_POST['customer_email'])
    : '';
$pass = isset($_POST['customer_pass']) && is_string($_POST['customer_pass'])
    ? $_POST['customer_pass']
    : '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 50) {
    $_SESSION['error'] = 'Please enter a valid email.';
    redirect(APP_BASE . '/views/login.php');
}

$controller = new CustomerController();
$result = $controller->login($email, $pass);

if (isset($result['success']) && $result['success'] === false) {
    $_SESSION['error'] = $result['error'];
    redirect(APP_BASE . '/views/login.php');
}

session_regenerate_id(true);
$_SESSION['customer_id'] = $result['customer_id'];
$_SESSION['customer_name'] = $result['customer_name'];
$_SESSION['customer_email'] = $result['customer_email'];
$_SESSION['user_role'] = (int)($result['user_role'] ?? 2);

// Send administrators to their dashboard after login.
if (is_admin()) {
    redirect(APP_BASE . '/views/admin/dashboard.php');
}
redirect(APP_BASE . '/index.php');
