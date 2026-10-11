<?php
require_once __DIR__ . '/../../core/core.php';
require_login();
?>
<?php include __DIR__ . '/../layout/header.php'; ?>

<h1>My Account</h1>
<p>Welcome, <?= htmlspecialchars($_SESSION['customer_name']) ?>.</p>
<p>Email: <?= htmlspecialchars($_SESSION['customer_email']) ?></p>
<p>Role: <?= is_admin() ? 'Admin' : 'Customer' ?></p>

<?php include __DIR__ . '/../layout/footer.php'; ?>
