<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

function respond(array $data, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($data);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond([
        'success' => false,
        'message' => 'Invalid request method.'
    ], 405);
}

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$action = $_POST['action'] ?? '';

if (!$productId || !isset($_SESSION['cart'][$productId])) {
    respond([
        'success' => false,
        'message' => 'Product not found in cart.'
    ], 404);
}

if ($action === 'increase') {
    $_SESSION['cart'][$productId]['quantity']++;

} elseif ($action === 'decrease') {
    $_SESSION['cart'][$productId]['quantity']--;

    if ($_SESSION['cart'][$productId]['quantity'] <= 0) {
        unset($_SESSION['cart'][$productId]);
    }

} elseif ($action === 'delete') {
    unset($_SESSION['cart'][$productId]);

} else {
    respond([
        'success' => false,
        'message' => 'Invalid cart action.'
    ], 400);
}

$items = [];
$cartCount = 0;
$cartSubtotal = 0.0;

foreach ($_SESSION['cart'] as $id => $item) {
    if (!is_array($item)) {
        continue;
    }

    $qty = max(0, (int) ($item['quantity'] ?? $item['qty'] ?? 0));
    $price = max(0, (float) ($item['price'] ?? 0));

    if ($qty < 1) {
        continue;
    }

    $lineTotal = $price * $qty;

    $cartCount += $qty;
    $cartSubtotal += $lineTotal;

    $items[] = [
        'product_id' => (int) ($item['product_id'] ?? $id),
        'name' => (string) ($item['name'] ?? 'Product'),
        'price' => $price,
        'quantity' => $qty,
        'lineTotal' => $lineTotal
    ];
}

session_write_close();

respond([
    'success' => true,
    'cartCount' => $cartCount,
    'cartSubtotal' => number_format($cartSubtotal, 2, '.', ''),
    'items' => $items
]);
