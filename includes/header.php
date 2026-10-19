<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cartCount = 0;
$cartSubtotal = 0.0;
$cartItems = $_SESSION['cart'] ?? [];

if (!is_array($cartItems)) {
    $cartItems = [];
}

foreach ($cartItems as $item) {
    if (!is_array($item)) {
        continue;
    }

    $quantity = max(0, (int) ($item['quantity'] ?? $item['qty'] ?? 0));
    $price = max(0, (float) ($item['price'] ?? 0));

    $cartCount += $quantity;
    $cartSubtotal += $quantity * $price;
}
?>
