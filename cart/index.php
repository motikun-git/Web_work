<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cart = $_SESSION['cart'] ?? [];

if (!is_array($cart)) {
    $cart = [];
}

$cartCount = 0;
$grandTotal = 0.0;

foreach ($cart as $item) {
    if (!is_array($item)) {
        continue;
    }

    $quantity = max(0, (int) ($item['quantity'] ?? 0));
    $price = max(0, (float) ($item['price'] ?? 0));

    $cartCount += $quantity;
    $grandTotal += $price * $quantity;
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart | Nexora Food</title>
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        .cart-page {
            width: min(1100px, calc(100% - 32px));
            margin: 45px auto;
        }

        .cart-page h1 {
            color: #35552b;
            margin-bottom: 8px;
        }

        .cart-subtitle {
            color: #777;
            margin-bottom: 28px;
        }

        .cart-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 300px;
            gap: 24px;
            align-items: start;
        }

        .cart-items,
        .cart-summary {
            background: #fff;
            border: 1px solid #e8ece4;
            border-radius: 14px;
            padding: 20px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding: 18px 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item:first-child {
            padding-top: 0;
        }

        .cart-item:last-child {
            border-bottom: 0;
        }

        .cart-item h3 {
            margin: 0 0 7px;
            color: #263522;
            font-size: 16px;
        }

        .cart-item p {
            margin: 4px 0;
            color: #777;
            font-size: 13px;
        }

        .cart-item-total {
            color: #35552b;
            font-weight: 700;
            white-space: nowrap;
        }

        .cart-summary h2 {
            margin-top: 0;
            font-size: 20px;
        }

        .cart-summary-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin: 18px 0;
        }

        .cart-grand-total {
            border-top: 1px solid #eee;
            padding-top: 18px;
            font-weight: 750;
            font-size: 18px;
        }

        .cart-action {
            display: block;
            width: 100%;
            padding: 12px;
            margin-top: 14px;
            border: 0;
            border-radius: 8px;
            background: #35552b;
            color: white;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }

        .cart-continue {
            display: inline-block;
            margin-top: 22px;
            color: #35552b;
            text-decoration: none;
            font-weight: 600;
        }

        .cart-empty {
            padding: 40px 12px;
            text-align: center;
        }

        .cart-empty p {
            color: #777;
        }

        @media (max-width: 700px) {
            .cart-layout {
                grid-template-columns: 1fr;
            }

            .cart-page {
                margin: 28px auto;
            }

            .cart-items,
            .cart-summary {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

<main class="cart-page">

    <h1>My Shopping Cart</h1>
    <p class="cart-subtitle">
        <?= $cartCount ?> item(s) in your cart
    </p>

    <?php if (empty($cart)): ?>

        <section class="cart-items cart-empty">
            <h2>Your cart is empty</h2>
            <p>Explore our products and add something you like.</p>
            <a class="cart-action" href="../index.php">
                Continue Shopping
            </a>
        </section>

    <?php else: ?>

        <div class="cart-layout">

            <section class="cart-items" aria-label="Cart items">

                <?php foreach ($cart as $item): ?>
                    <?php
                    if (!is_array($item)) {
                        continue;
                    }

                    $name = (string) ($item['name'] ?? 'Product');
                    $unit = (string) ($item['unit'] ?? '');
                    $price = max(0, (float) ($item['price'] ?? 0));
                    $quantity = max(0, (int) ($item['quantity'] ?? 0));
                    $subtotal = $price * $quantity;
                    ?>

                    <article class="cart-item">

                        <div>
                            <h3><?= e($name) ?></h3>

                            <p>
                                ৳<?= number_format($price, 2) ?>
                                <?= $unit !== '' ? '/ ' . e($unit) : '' ?>
                            </p>

                            <p>Quantity: <?= $quantity ?></p>
                        </div>

                        <div class="cart-item-total">
                            ৳<?= number_format($subtotal, 2) ?>
                        </div>

                    </article>

                <?php endforeach; ?>

            </section>

            <aside class="cart-summary">

                <h2>Order Summary</h2>

                <div class="cart-summary-row">
                    <span>Total items</span>
                    <span><?= $cartCount ?></span>
                </div>

                <div class="cart-summary-row cart-grand-total">
                    <span>Grand Total</span>
                    <span>৳<?= number_format($grandTotal, 2) ?></span>
                </div>

                <a class="cart-action" href="../pages/shop.php">
                    Continue Shopping
                </a>

                <p style="font-size:12px;color:#777;line-height:1.6;">
                    Checkout will be connected in a later step.
                </p>

            </aside>

        </div>

    <?php endif; ?>

    <a class="cart-continue" href="../index.php">
        ← Back to Home
    </a>

</main>

</body>
</html>
