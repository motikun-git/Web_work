<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

$productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

if (!$productId || $productId < 1) {
    header('Location: ../index.php?cart_error=invalid_product');
    exit;
}

/*
 * Temporary sample products.
 * Later, these details will come from MySQL.
 */
$products = [
    1  => ['name' => 'Potato', 'price' => 40,  'unit' => 'kg'],
    2  => ['name' => 'Onion',  'price' => 60,  'unit' => 'kg'],
    3  => ['name' => 'Tomato', 'price' => 50,  'unit' => 'kg'],
    4  => ['name' => 'Eggs',   'price' => 150, 'unit' => 'dozen'],
    5  => ['name' => 'Milk',   'price' => 90,  'unit' => 'litre'],
    6  => ['name' => 'Rice',   'price' => 75,  'unit' => 'kg'],
    7  => ['name' => 'Apple',  'price' => 200, 'unit' => 'kg'],
    8  => ['name' => 'Banana', 'price' => 80,  'unit' => 'dozen'],
    9  => ['name' => 'Bread',  'price' => 60,  'unit' => 'pack'],
    10 => ['name' => 'Juice',  'price' => 100, 'unit' => 'pack'],
];

if (!isset($products[$productId])) {
    header('Location: ../index.php?cart_error=invalid_product');
    exit;
}

$product = $products[$productId];

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/*
 * Same product: increase quantity.
 * New product: create a cart entry.
 */
if (isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId]['quantity']++;
} else {
    $_SESSION['cart'][$productId] = [
        'product_id' => $productId,
        'name'       => $product['name'],
        'price'      => $product['price'],
        'unit'       => $product['unit'],
        'quantity'   => 1,
    ];
}

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($isAjax) {
    header('Content-Type: application/json; charset=utf-8');

    $cartCount = 0;

    foreach ($_SESSION['cart'] as $item) {
        if (is_array($item)) {
            $cartCount += max(
                0,
                (int) ($item['quantity'] ?? $item['qty'] ?? 0)
            );
        }
    }

    $cartItems = [];
    $cartCount = 0;
    $cartSubtotal = 0;

    foreach ($_SESSION['cart'] as $item) {
        if (!is_array($item)) {
            continue;
        }

        $qty = max(0, (int) ($item['quantity'] ?? $item['qty'] ?? 0));
        $price = max(0, (float) ($item['price'] ?? 0));

        $cartCount += $qty;
        $cartSubtotal += $price * $qty;

        $cartItems[] = [
            'name' => (string) ($item['name'] ?? 'Product'),
            'price' => $price,
            'quantity' => $qty,
            'lineTotal' => $price * $qty
        ];
    }

    echo json_encode([
        'success' => true,
        'message' => 'Product added to cart!',
        'cartCount' => $cartCount,
        'cartSubtotal' => number_format($cartSubtotal, 2, '.', ''),
        'items' => $cartItems
    ]);
    exit;
}

header('Location: ../index.php?added=1');
exit;