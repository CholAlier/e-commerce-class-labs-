<?php
session_start();
date_default_timezone_set('Africa/Accra');

require_once __DIR__ . '/db_class.php';

if (!defined('APP_BASE')) {
    $appBase = getenv('SHOPPN_APP_BASE');
    if ($appBase === false || $appBase === '') {
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        if (preg_match('#/views/(?:account|admin)$#', $scriptDir)) {
            $scriptDir = dirname(dirname($scriptDir));
        } elseif (preg_match('#/(?:views|actions)$#', $scriptDir)) {
            $scriptDir = dirname($scriptDir);
        }
        $appBase = rtrim($scriptDir, '/');
        if ($appBase === '.') {
            $appBase = '';
        }
    }
    define('APP_BASE', $appBase);
}

function get_ip() {
    return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function log_error($message) {
    $message = str_replace(["\r", "\n"], ' ', (string)$message);
    $entry = sprintf("[%s] %s\n", date('c'), $message);
    $logFile = __DIR__ . '/../error/error.log';

    if (!error_log($entry, 3, $logFile)) {
        error_log($message);
    }
}

function is_logged_in() {
    return isset($_SESSION['customer_id']);
}

function is_admin() {
    return isset($_SESSION['user_role']) && (int) $_SESSION['user_role'] === 1;
}

function require_login() {
    if (!is_logged_in()) {
        $_SESSION['error'] = 'Please log in first.';
        redirect(APP_BASE . '/views/login.php');
    }
}

function require_admin() {
    if (!is_admin()) {
        $_SESSION['error'] = 'Admin access required.';
        redirect(APP_BASE . '/index.php');
    }
}
