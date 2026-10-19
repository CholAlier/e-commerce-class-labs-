<?php
require_once __DIR__ . '/../core/core.php';
?>
<?php include __DIR__ . '/layout/header.php'; ?>

<div class="auth-card">
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

        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>

    <p class="auth-footer">Don't have an account? <a href="register.php">Create one</a></p>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>
