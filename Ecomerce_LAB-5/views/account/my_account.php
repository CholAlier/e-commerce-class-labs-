<?php
require_once __DIR__ . '/../../core/core.php';
require_login();
?>
<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="account-card">
    <div class="account-avatar">
        <?= strtoupper(substr($_SESSION['customer_name'], 0, 1)) ?>
    </div>
    <h1><?= htmlspecialchars($_SESSION['customer_name']) ?></h1>
    <span class="account-role-badge <?= is_admin() ? 'badge-admin' : 'badge-customer' ?>">
        <?= is_admin() ? 'Admin' : 'Customer' ?>
    </span>

    <div class="account-details">
        <div class="account-detail-row">
            <span class="account-detail-label">Email</span>
            <span class="account-detail-value"><?= htmlspecialchars($_SESSION['customer_email']) ?></span>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
