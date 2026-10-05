<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CustomerController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/register.php');
}

$readPost = static function ($key) {
    return isset($_POST[$key]) && is_string($_POST[$key]) ? $_POST[$key] : '';
};

$name = trim(strip_tags($readPost('customer_name')));
$email = trim($readPost('customer_email'));
$pass = $readPost('customer_pass');
$country = trim(strip_tags($readPost('customer_country')));
$city = trim(strip_tags($readPost('customer_city')));
$contact = trim(strip_tags($readPost('customer_contact')));

if ($name === '' || strlen($name) < 2 || strlen($name) > 100) {
    $_SESSION['error'] = 'Please enter a name between 2 and 100 characters.';
    redirect('../views/register.php');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 50) {
    $_SESSION['error'] = 'Please enter a valid email.';
    redirect('../views/register.php');
}

if ($country === '' || strlen($country) > 30 || $city === '' || strlen($city) > 30) {
    $_SESSION['error'] = 'Country and city are required and must be 30 characters or fewer.';
    redirect('../views/register.php');
}

if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/', $pass)) {
    $_SESSION['error'] = 'Password must be at least 8 characters and include uppercase and lowercase letters, a number, and a special character.';
    redirect('../views/register.php');
}

if (!preg_match('/^[0-9+\-\s]{7,15}$/', $contact)) {
    $_SESSION['error'] = 'Please enter a valid contact number.';
    redirect('../views/register.php');
}

$controller = new CustomerController();
$result = $controller->register([
    'name' => $name,
    'email' => $email,
    'pass' => $pass,
    'country' => $country,
    'city' => $city,
    'contact' => $contact
]);

if ($result['success']) {
    session_regenerate_id(true);
    $_SESSION['customer_id'] = $result['customer_id'];
    $_SESSION['customer_name'] = $result['customer_name'];
    $_SESSION['customer_email'] = $result['customer_email'];
    $_SESSION['user_role'] = $result['user_role'];
    redirect('../views/account/my_account.php');
}

$_SESSION['error'] = $result['error'];
redirect('../views/register.php');
