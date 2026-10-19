<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$products = [
    ['name' => 'Potato', 'price' => 40, 'unit' => 'kg', 'icon' => '🥔'],
    ['name' => 'Onion', 'price' => 60, 'unit' => 'kg', 'icon' => '🧅'],
    ['name' => 'Tomato', 'price' => 50, 'unit' => 'kg', 'icon' => '🍅'],
    ['name' => 'Eggs', 'price' => 150, 'unit' => 'dozen', 'icon' => '🥚'],
];

$featuredProducts = [
    [
        'id' => 1,
        'name' => 'Potato',
        'price' => 40,
        'discount_price' => null,
        'unit' => 'kg',
        'image' => 'assets/images/products/potato.jpg',
        'icon' => '🥔'
    ],
    [
        'id' => 2,
        'name' => 'Onion',
        'price' => 60,
        'discount_price' => 50,
        'unit' => 'kg',
        'image' => 'assets/images/products/onion.jpg',
        'icon' => '🧅'
    ],
    [
        'id' => 3,
        'name' => 'Tomato',
        'price' => 50,
        'discount_price' => null,
        'unit' => 'kg',
        'image' => 'assets/images/products/tomato.jpg',
        'icon' => '🍅'
    ],
    [
        'id' => 4,
        'name' => 'Eggs',
        'price' => 150,
        'discount_price' => null,
        'unit' => 'dozen',
        'image' => 'assets/images/products/eggs.jpg',
        'icon' => '🥚'
    ],
    [
        'id' => 5,
        'name' => 'Milk',
        'price' => 100,
        'discount_price' => 90,
        'unit' => 'litre',
        'image' => 'assets/images/products/milk.jpg',
        'icon' => '🥛'
    ],
    [
        'id' => 6,
        'name' => 'Rice',
        'price' => 75,
        'discount_price' => null,
        'unit' => 'kg',
        'image' => 'assets/images/products/rice.jpg',
        'icon' => '🍚'
    ],
    [
        'id' => 7,
        'name' => 'Apple',
        'price' => 220,
        'discount_price' => 200,
        'unit' => 'kg',
        'image' => 'assets/images/products/apple.jpg',
        'icon' => '🍎'
    ],
    [
        'id' => 8,
        'name' => 'Banana',
        'price' => 80,
        'discount_price' => null,
        'unit' => 'dozen',
        'image' => 'assets/images/products/banana.jpg',
        'icon' => '🍌'
    ],
    [
        'id' => 9,
        'name' => 'Bread',
        'price' => 60,
        'discount_price' => null,
        'unit' => 'pack',
        'image' => 'assets/images/products/bread.jpg',
        'icon' => '🍞'
    ],
    [
        'id' => 10,
        'name' => 'Juice',
        'price' => 120,
        'discount_price' => 100,
        'unit' => 'pack',
        'image' => 'assets/images/products/juice.jpg',
        'icon' => '🧃'
    ],
];

$cartCount = 0;

if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        if (is_array($item)) {
            $cartCount += max(0, (int) ($item['quantity'] ?? $item['qty'] ?? 0));
        }
    }
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
    <meta name="theme-color" content="#35552B">
    <meta name="description" content="Shop food, snacks, beverages and everyday essentials at Nexora Food.">

    <title>Nexora Food | Everyday Food Destination</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/animations.js" defer></script>
</head>

<body>

<header class="site-header">
    <div class="header-top">

        
<a class="logo" href="index.php" aria-label="Nexora Food Home">
    <img src="assets/images/logo.png" alt="" class="brand-logo">
    <span class="logo-text">Nexora<span>Food</span></span>
</a>


        <form class="search-box" action="pages/shop.php" method="get" role="search">
            <input
                type="search"
                name="search"
                placeholder="Search products..."
                aria-label="Search products"
            >
            <button type="submit" aria-label="Search">⌕</button>
        </form>

        <div class="header-actions">
            <a class="chat-link" href="pages/contact.php" aria-label="Contact support">
                <span aria-hidden="true">☏</span>
                <small>Chat</small>
            </a>

            <a class="account-link" href="auth/login.php">Account</a>

            <a class="header-cart" href="cart/index.php">
                <span aria-hidden="true">🛒</span>
                Cart
                <span class="header-cart-count"><?= $cartCount ?></span>
            </a>
        </div>

    </div>

    <div class="header-bottom">


<div class="category-dropdown">
    <button
        class="category-menu"
        id="categoryToggle"
        type="button"
        aria-expanded="false"
        aria-controls="categoryDropdown"
    >
        ☰ All Categories
    </button>
</div>


<nav class="main-nav" aria-label="Main navigation">
    <a href="index.php">Home</a>
    <a href="pages/shop.php">Shop</a>
    <a href="pages/about.php">About</a>
    <a href="pages/contact.php">Contact</a>
</nav>

<p class="header-tagline">Pure Origins, Trusted Quality</p>

    </div>
</header>

<main>

    <section class="hero hero-compact" aria-labelledby="hero-title">

        <div class="hero-content" data-hero-content>
            <span class="hero-badge">YOUR EVERYDAY FOOD DESTINATION</span>

            <h1 id="hero-title">
                Everything You Love,
                <span>All in One Place.</span>
            </h1>

            <p>
                Discover food, snacks, beverages and everyday essentials
                at great prices.
            </p>

            <a class="btn" href="pages/shop.php">
                Explore Products →
            </a>
        </div>

        

<div class="hero-visual" data-hero-visual>
    <div class="hero-image-placeholder hero-slideshow">

        <div class="hero-slides">
            <img src="assets/images/hero-s1.jpg"
                 class="hero-slide active"
                 alt="Fruits and vegetables">

            <img src="assets/images/hero-s2.jpg"
                 class="hero-slide"
                 alt="Dairy and eggs">

            <img src="assets/images/hero-s3.jpg"
                 class="hero-slide"
                 alt="Bakery and snacks">

            <img src="assets/images/hero-s4.jpg"
                 class="hero-slide"
                 alt="Rice, dal and grains">
        </div>

        <button class="hero-slide-arrow prev"
                type="button"
                aria-label="Previous slide">&#10094;</button>

        <button class="hero-slide-arrow next"
                type="button"
                aria-label="Next slide">&#10095;</button>

        <div class="hero-slide-dots">
            <button type="button" class="active" aria-label="Slide 1"></button>
            <button type="button" aria-label="Slide 2"></button>
            <button type="button" aria-label="Slide 3"></button>
            <button type="button" aria-label="Slide 4"></button>
        </div>

    </div>
</div>



    </section>


<section class="home-featured-section" aria-labelledby="featured-title">

    <div class="home-featured-heading">
        <div>
            <h2 id="featured-title">Featured Products</h2>
            <p>Explore our selected products.</p>
        </div>
    </div>

    <div class="home-featured-grid">

        <?php foreach (array_slice($featuredProducts, 0, 10) as $product): ?>

            <?php
                $hasDiscount = $product['discount_price'] !== null
                    && $product['discount_price'] > 0
                    && $product['discount_price'] < $product['price'];

                $currentPrice = $hasDiscount
                    ? $product['discount_price']
                    : $product['price'];
            ?>

            <article class="home-featured-card">

                <a class="home-featured-image"
                   href="pages/shop.php">

                    <?php if (is_file(__DIR__ . '/' . $product['image'])): ?>

                        <img
                            src="<?= e($product['image']) ?>"
                            alt="<?= e($product['name']) ?>"
                            loading="lazy"
                        >

                    <?php else: ?>

                        <span class="home-featured-placeholder"
                              aria-hidden="true">
                            <?= e($product['icon']) ?>
                        </span>

                    <?php endif; ?>

                    <?php if ($hasDiscount): ?>
                        <span class="home-featured-badge">
                            Save ৳<?= number_format(
                                $product['price'] - $currentPrice,
                                0
                            ) ?>
                        </span>
                    <?php endif; ?>

                </a>

                <div class="home-featured-info">

                    <h3>
                        <a href="pages/shop.php">
                            <?= e($product['name']) ?>
                        </a>
                    </h3>

                    <p class="home-featured-unit">
                        Per <?= e($product['unit']) ?>
                    </p>

                    <div class="home-featured-prices">

                        <strong>
                            ৳<?= number_format($currentPrice, 2) ?>
                        </strong>

                        <?php if ($hasDiscount): ?>
                            <del>
                                ৳<?= number_format($product['price'], 2) ?>
                            </del>
                        <?php endif; ?>

                    </div>

                    
            <form class="home-featured-cart-form"
                action="cart/add.php"
                method="POST">

                <input
                    type="hidden"
                    name="product_id"
                    value="<?= (int) $product['id'] ?>"
                >

                <button
                    class="home-featured-add-btn"
                    type="submit">
                    Add to Cart
                </button>

            </form>


                </div>

            </article>

        <?php endforeach; ?>

    </div>

    <div class="home-featured-more">
        <a href="pages/shop.php?featured=1">
            Show More <span aria-hidden="true">→</span>
        </a>
    </div>

</section>

    <section class="featured-products" aria-labelledby="popular-title">
        <h2 id="popular-title">Popular Products</h2>
        <p class="section-subtitle">
            Explore some everyday essentials.
        </p>

        <div class="product-list">
            <?php foreach ($products as $product): ?>
                <article class="product-card">

                    <div class="product-image" aria-hidden="true">
                        <span><?= $product['icon'] ?></span>
                    </div>

                    <h3><?= e($product['name']) ?></h3>

                    <p class="product-price">
                        ৳<?= number_format($product['price'], 2) ?>
                        / <?= e($product['unit']) ?>
                    </p>

                    <a class="cart-btn" href="pages/shop.php">
                        View Product
                    </a>

                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <!--<section class="products" id="categories" aria-labelledby="categories-title">
        <h2 id="categories-title">Shop by Category</h2>
        <p class="section-subtitle">
            Find what you need by browsing our categories.
        </p>

        <div class="category-list">
            <?php foreach ($categories as $category): ?>
                <a
                    class="category-card"
                    href="pages/shop.php?category=<?= e($category['slug']) ?>"
                >
                    <div class="category-image-placeholder" aria-hidden="true">
                        <?= $category['icon'] ?>
                    </div>

                    <h3><?= e($category['name']) ?></h3>
                </a>
            <?php endforeach; ?>
        </div>
    </section>-->

</main>

<a class="floating-cart" href="cart/index.php" aria-label="View cart, <?= $cartCount ?> items">
    <span class="floating-cart-icon" aria-hidden="true">🛒</span>
    <span>View Cart</span>
    <span class="floating-cart-count" aria-live="polite"><?= $cartCount ?></span>
</a>

<div class="nexora-toast" id="nexoraToast" role="status" aria-live="polite"></div>



<?php require_once __DIR__ . '/includes/cart_drawer.php'; ?>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('categoryToggle');
    const dropdown = document.getElementById('categoryDropdown');

    if (!toggle || !dropdown) {
        return;
    }

    toggle.addEventListener('click', function (event) {
        event.stopPropagation();

        const isOpen = dropdown.classList.toggle('show');
        toggle.setAttribute('aria-expanded', String(isOpen));
    });

    document.addEventListener('click', function (event) {
        if (!dropdown.contains(event.target) && !toggle.contains(event.target)) {
            dropdown.classList.remove('show');
            toggle.setAttribute('aria-expanded', 'false');
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            dropdown.classList.remove('show');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.focus();
        }
    });
});


</script>

            

<footer class="site-footer">
    <div class="footer-container">

        <!-- Brand -->
        <div class="footer-brand">
            <a href="index.php" class="footer-logo">
                Nexora<span>Food</span>
            </a>

            <p class="footer-description">
                Your everyday destination for food, snacks,
                beverages and everyday essentials.
            </p>

            <h3 class="footer-heading">Follow Us</h3>

            <div class="footer-socials">
                <a href="https://www.facebook.com/nexorafoods/"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="Facebook">
                    <img src="https://cdn.simpleicons.org/facebook/1877F2"
                         alt="" width="22" height="22">
                </a>

                <a href="https://www.instagram.com/nexorafoods_official"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="Instagram">
                    <img src="https://cdn.simpleicons.org/instagram/E4405F"
                         alt="" width="22" height="22">
                </a>

                <a href="https://www.tiktok.com/@nexorafoods"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="TikTok">
                    <img src="https://cdn.simpleicons.org/tiktok/FFFFFF"
                         alt="" width="22" height="22">
                </a>

                <!--a href="https://maps.app.goo.gl/rZYg1sbisnkYfyMZ7?g_st=ac"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="Google Maps">
                    <img src="https://cdn.simpleicons.org/googlemaps/34A853"
                         alt="" width="22" height="22">
                </a>-->
            </div>
        </div>

        <!-- Quick Links -->
        <div class="footer-links">
            <h3 class="footer-heading">Quick Links</h3>

            <a href="index.php">Home</a>
            <a href="pages/shop.php">Shop Products</a>
            <a href="pages/about.php">About Us</a>
            <a href="pages/contact.php">Contact Us</a>
            <a href="cart/index.php">View Cart</a>
            <a href="auth/login.php">My Account</a>
        </div>

        <!-- Contact Information -->
        <div class="footer-contact">
            <h3 class="footer-heading">Contact Information</h3>

            <a href="https://nexorafoods.com"
               target="_blank"
               rel="noopener noreferrer"
               class="footer-contact-item">
                <span class="footer-contact-symbol">↗</span>
                <span>nexorafoods.com</span>
            </a>

            <a href="tel:+8801313552299"
               class="footer-contact-item">
                <span class="footer-contact-symbol">☎</span>
                <span>+880 1313552299</span>
            </a>

            <a href="mailto:info@nexorafoods.com"
               class="footer-contact-item">
                <span class="footer-contact-symbol">✉</span>
                <span>info@nexorafoods.com</span>
            </a>

            <div class="footer-address">
                <span class="footer-contact-symbol">📍</span>
                <p>
                    House #579 (Parabar), Road #09,
                    Mirpur DOHS, Dhaka-1216,
                    Bangladesh.
                </p>
            </div>

            <a class="footer-map"
               href="https://maps.app.goo.gl/rZYg1sbisnkYfyMZ7?g_st=ac"
               target="_blank"
               rel="noopener noreferrer">
                View Location on Google Maps
                <span aria-hidden="true">↗</span>
            </a>
        </div>

    </div>

    <!-- Copyright -->
    <div class="footer-bottom">
        <p>
            &copy; <?= date('Y') ?> NexoraFood.
            All rights reserved.
        </p>
    </div>
</footer>


<script src="assets/js/add_to_cart.js" defer></script>
<script src="assets/js/cart_drawer.js" defer></script>




</body>
</html>
