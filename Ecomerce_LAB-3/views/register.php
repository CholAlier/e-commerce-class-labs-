<?php
require_once __DIR__ . '/../core/core.php';
?>
<?php include __DIR__ . '/layout/header.php'; ?>

<h1>Create Account</h1>

<?php if (isset($_SESSION['error'])): ?>
    <p class="error"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form id="register-form" action="../actions/register_action.php" method="POST" novalidate>
    <label>Full Name
        <input type="text" name="customer_name" maxlength="100" required>
        <small class="field-error" data-error-for="customer_name" aria-live="polite"></small>
    </label>

    <label>Email
        <input type="email" name="customer_email" maxlength="50" required>
        <small class="field-error" data-error-for="customer_email" aria-live="polite"></small>
    </label>

    <label>Password
        <input type="password" name="customer_pass" minlength="8" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}" title="At least 8 characters, with uppercase and lowercase letters, a number, and a special character." required>
        <small class="field-error" data-error-for="customer_pass" aria-live="polite"></small>
    </label>

    <label>Country
        <select name="customer_country" required>
            <option value="">Select your country</option>
            <option value="Ghana">Ghana</option>
            <option value="Nigeria">Nigeria</option>
            <option value="South Sudan">South Sudan</option>
            <option value="Niger">Niger</option>
            <option value="Cameroon">Cameroon</option>
            <option value="Sudan">Sudan</option>
            <option value="Other">Other</option>
        </select>
        <small class="field-error" data-error-for="customer_country" aria-live="polite"></small>
    </label>

    <label>City
        <input type="text" name="customer_city" maxlength="30" required>
        <small class="field-error" data-error-for="customer_city" aria-live="polite"></small>
    </label>

    <label>Contact Number
        <input type="tel" name="customer_contact" maxlength="15" required>
        <small class="field-error" data-error-for="customer_contact" aria-live="polite"></small>
    </label>

    <label>Address
        <textarea name="customer_address"></textarea>
    </label>

    <button type="submit">Register</button>
</form>

<script src="../js/validate.js"></script>
<?php include __DIR__ . '/layout/footer.php'; ?>
