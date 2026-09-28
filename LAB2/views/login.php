<?php
require_once __DIR__ . '/../core/core.php';
?>
<?php include __DIR__ . '/layout/header.php'; ?>

<h1>Login</h1>

<?php if (isset($_SESSION['success'])): ?>
    <p class="success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></p>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <p class="error"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form action="../actions/login_action.php" method="POST">
    <label>Email
        <input type="email" name="customer_email" required>
    </label>

    <label>Password
        <input type="password" name="customer_pass" required>
    </label>

    <button type="submit">Login</button>
</form>

<p><a href="register.php">Create an account</a></p>

<?php include __DIR__ . '/layout/footer.php'; ?>
