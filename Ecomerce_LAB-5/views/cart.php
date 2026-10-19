<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

$controller = new CartController();
$ip = get_ip();
$items = $controller->getCartItems($ip);
$total = $controller->getCartTotal($ip);
?>
<?php include __DIR__ . '/layout/header.php'; ?>

<h1>Shopping Cart</h1>

<?php if (!$items): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <form id="remove-cart-form" action="<?= htmlspecialchars(APP_BASE) ?>/actions/remove_from_cart_action.php" method="POST"></form>
    <form id="update-cart-form" action="<?= htmlspecialchars(APP_BASE) ?>/actions/update_qty_action.php" method="POST"></form>

    <table>
        <thead>
            <tr>
                <th>Remove</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="remove[]" value="<?= (int)$item['p_id'] ?>"
                               form="remove-cart-form" aria-label="Remove <?= htmlspecialchars($item['product_title']) ?>">
                    </td>
                    <td>
                        <?php if (!empty($item['product_image'])): ?>
                            <img class="cart-product-image"
                                 src="<?= htmlspecialchars(APP_BASE) ?>/images/products/<?= htmlspecialchars($item['product_image']) ?>"
                                 alt="">
                        <?php endif; ?>
                        <?= htmlspecialchars($item['product_title']) ?>
                    </td>
                    <td>
                        <input type="number" name="qty[]" min="1" step="1" required
                               value="<?= max(1, (int)$item['qty']) ?>" form="update-cart-form"
                               aria-label="Quantity for <?= htmlspecialchars($item['product_title']) ?>">
                        <input type="hidden" name="update[]" value="<?= (int)$item['p_id'] ?>"
                               form="update-cart-form">
                    </td>
                    <td>$<?= number_format((float)$item['product_price'], 2) ?></td>
                    <td>$<?= number_format((int)$item['qty'] * (float)$item['product_price'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <th colspan="4">Subtotal</th>
                <th>$<?= number_format($total, 2) ?></th>
            </tr>
        </tbody>
    </table>

    <p>
        <button type="submit" form="remove-cart-form">Remove from Cart</button>
        <button type="submit" form="update-cart-form">Update Quantity</button>
    </p>
<?php endif; ?>

<p>
    <a class="button-link" href="<?= htmlspecialchars(APP_BASE) ?>/index.php">Continue Shopping</a>
</p>

<?php include __DIR__ . '/layout/footer.php'; ?>
