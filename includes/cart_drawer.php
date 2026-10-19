<?php
$drawerCart = $_SESSION['cart'] ?? [];
$drawerCartTotal = 0;
$drawerCartCount = 0;

if (is_array($drawerCart)) {
    foreach ($drawerCart as $item) {
        if (!is_array($item)) {
            continue;
        }

        $qty = max(0, (int) ($item['quantity'] ?? $item['qty'] ?? 0));
        $price = max(0, (float) ($item['price'] ?? 0));

        $drawerCartCount += $qty;
        $drawerCartTotal += $price * $qty;
    }
}
?>

<div class="cart-drawer-overlay" id="cartDrawerOverlay" aria-hidden="true"></div>

<aside class="cart-drawer"
       id="cartDrawer"
       role="dialog"
       aria-modal="true"
       aria-labelledby="cartDrawerTitle"
       aria-hidden="true"
       inert>

    <div class="cart-drawer-header">
        <div>
            <h2 id="cartDrawerTitle">Your Cart</h2>
            <p><span id="drawerCartCount"><?= $drawerCartCount ?></span> items in your cart</p>
        </div>

        <button type="button"
                class="cart-drawer-close"
                id="closeCartDrawer"
                aria-label="Close cart">&times;</button>
    </div>

    <div class="cart-drawer-items" id="cartDrawerItems">
        <?php if (empty($drawerCart)): ?>
            <div class="cart-drawer-empty">
                <span aria-hidden="true">🛒</span>
                <h3>Your cart is empty</h3>
                <p>Add products to see them here.</p>
            </div>
        <?php else: ?>
            <?php foreach ($drawerCart as $item): ?>
                <?php
                if (!is_array($item)) {
                    continue;
                }

                $name = (string) ($item['name'] ?? 'Product');
                $price = max(0, (float) ($item['price'] ?? 0));
                $qty = max(0, (int) ($item['quantity'] ?? $item['qty'] ?? 0));
                ?>
                <div class="cart-drawer-item">
                    <div class="cart-drawer-item-info">
                        <h3><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></h3>
                        <p>৳<?= number_format($price, 2) ?> each</p>
                    </div>
                    <div class="cart-drawer-item-quantity">
                        <div class="cart-quantity-controls">
                            <button
                                type="button"
                                class="cart-quantity-btn"
                                data-cart-action="decrease"
                                data-product-id="<?= (int) ($item['product_id'] ?? 0) ?>"
                                aria-label="Decrease quantity">
                                −
                            </button>

                            <span><?= $qty ?></span>

                            <button
                                type="button"
                                class="cart-quantity-btn"
                                data-cart-action="increase"
                                data-product-id="<?= (int) ($item['product_id'] ?? 0) ?>"
                                aria-label="Increase quantity">
                                +
                            </button>
                        </div>

                        <strong>৳<?= number_format($price * $qty, 2) ?></strong>

                        <button
                            type="button"
                            class="cart-delete-btn"
                            data-cart-action="delete"
                            data-product-id="<?= (int) ($item['product_id'] ?? 0) ?>"
                            aria-label="Remove <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>">
                            Delete
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="cart-drawer-footer">
        <div class="cart-drawer-total">
            <span>Subtotal</span>
            <strong id="cartDrawerSubtotal">৳<?= number_format($drawerCartTotal, 2) ?></strong>
        </div>

        <p class="cart-drawer-note">Delivery charges will be calculated at checkout.</p>

        <button type="button"
                class="cart-drawer-checkout"
                id="cartDrawerCheckout">
            Place Order →
        </button>
    </div>
</aside>
