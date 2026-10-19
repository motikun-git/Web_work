<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
    <meta name="description" content="Learn more about NexoraFood, your everyday destination for food and household essentials.">

    <title>About Us | NexoraFood</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/animations.js" defer></script>

    <style>
        /* About page */
        .about-page {
            color: #30352d;
            overflow: hidden;
        }

        .about-page * {
            box-sizing: border-box;
        }

        .about-container {
            width: min(1180px, calc(100% - 40px));
            margin: 0 auto;
        }

        .about-hero {
            position: relative;
            padding: 76px 0 72px;
            background: linear-gradient(125deg, #f4f6ed 0%, #fbf8ef 65%, #fff1df 100%);
        }

        .about-hero-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            align-items: center;
            gap: 60px;
        }

        .about-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 9px 15px;
            border: 1px solid #dce5d5;
            border-radius: 30px;
            background: #fff;
            color: #35552B;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1.1px;
            text-transform: uppercase;
        }

        .about-eyebrow::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #F28C38;
        }

        .about-hero h1 {
            margin: 23px 0 20px;
            color: #253b20;
            font-size: clamp(38px, 5vw, 62px);
            line-height: 1.12;
            letter-spacing: -2px;
        }

        .about-hero h1 span {
            color: #F28C38;
        }

        .about-hero-copy {
            max-width: 540px;
            color: #666c61;
            font-size: 16px;
            line-height: 1.9;
        }

        .about-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 30px;
        }

        .about-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 49px;
            padding: 13px 23px;
            border: 1px solid #35552B;
            border-radius: 9px;
            background: #35552B;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: transform .2s ease, background .2s ease;
        }

        .about-btn:hover {
            transform: translateY(-3px);
            background: #263f20;
            color: #fff;
        }

        .about-btn-secondary {
            background: #fff;
            color: #35552B;
        }

        .about-btn-secondary:hover {
            background: #f0f3eb;
            color: #35552B;
        }

        .about-hero-art {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 340px;
        }

        .about-art-circle {
            position: absolute;
            width: min(340px, 90%);
            aspect-ratio: 1;
            border-radius: 50%;
            background: #e5ebd9;
        }

        .about-art-card {
            position: relative;
            width: min(340px, 90%);
            padding: 34px 25px;
            border: 1px solid rgba(255,255,255,.9);
            border-radius: 24px;
            background: rgba(255,255,255,.88);
            box-shadow: 0 22px 65px rgba(53,85,43,.13);
            text-align: center;
        }

        .about-art-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100px;
            height: 100px;
            margin: 0 auto 22px;
            border-radius: 28px;
            background: #f8eddd;
            font-size: 55px;
        }

        .about-art-card h2 {
            margin: 0 0 10px;
            color: #35552B;
            font-size: 25px;
        }

        .about-art-card p {
            margin: 0;
            color: #70766a;
            font-size: 14px;
            line-height: 1.8;
        }

        .about-section {
            padding: 82px 0;
        }

        .about-section-heading {
            max-width: 680px;
            margin: 0 auto 45px;
            text-align: center;
        }

        .about-section-label {
            margin: 0 0 12px;
            color: #F28C38;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .about-section-heading h2 {
            margin: 0 0 16px;
            color: #263c21;
            font-size: clamp(28px, 3.5vw, 40px);
            line-height: 1.25;
        }

        .about-section-heading > p:last-child {
            margin: 0;
            color: #73776f;
            font-size: 15px;
            line-height: 1.9;
        }

        .about-story-grid {
            display: grid;
            grid-template-columns: .85fr 1.15fr;
            gap: 55px;
            align-items: center;
        }

        .about-story-visual {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 300px;
            padding: 30px;
            border-radius: 22px;
            background: linear-gradient(145deg, #edf1e6, #fff4e7);
        }

        .about-story-visual-inner {
            width: 100%;
            padding: 35px 24px;
            border: 1px solid rgba(255,255,255,.9);
            border-radius: 18px;
            background: rgba(255,255,255,.8);
            text-align: center;
        }

        .about-story-visual-inner span {
            display: block;
            margin-bottom: 17px;
            font-size: 58px;
        }

        .about-story-visual-inner h3 {
            margin: 0 0 10px;
            color: #35552B;
            font-size: 23px;
        }

        .about-story-visual-inner p {
            margin: 0;
            color: #74796e;
            font-size: 14px;
            line-height: 1.8;
        }

        .about-story-copy h2 {
            margin: 0 0 18px;
            color: #263c21;
            font-size: clamp(28px, 3vw, 36px);
            line-height: 1.3;
        }

        .about-story-copy p {
            margin: 0 0 17px;
            color: #6c7168;
            font-size: 15px;
            line-height: 1.95;
        }

        .about-values {
            background: #f7f8f3;
        }

        .about-value-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 22px;
        }

        .about-value-card {
            padding: 28px 22px;
            border: 1px solid #e9ecdf;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 6px 20px rgba(38,60,33,.035);
            transition: transform .22s ease, box-shadow .22s ease;
        }

        .about-value-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(38,60,33,.09);
        }

        .about-value-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            margin-bottom: 22px;
            border-radius: 15px;
            background: #edf2e7;
            font-size: 28px;
        }

        .about-value-card:nth-child(even) .about-value-icon {
            background: #fff0df;
        }

        .about-value-card h3 {
            margin: 0 0 12px;
            color: #304629;
            font-size: 18px;
        }

        .about-value-card p {
            margin: 0;
            color: #74786f;
            font-size: 14px;
            line-height: 1.85;
        }

        .about-mission-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .about-mission-card {
            padding: 35px;
            border: 1px solid #e7ebdf;
            border-radius: 18px;
            background: #fff;
        }

        .about-mission-card.highlight {
            border-color: #35552B;
            background: #35552B;
        }

        .about-mission-card > span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            margin-bottom: 22px;
            border-radius: 14px;
            background: #edf2e7;
            font-size: 24px;
        }

        .about-mission-card.highlight > span {
            background: rgba(255,255,255,.14);
        }

        .about-mission-card h3 {
            margin: 0 0 14px;
            color: #304629;
            font-size: 24px;
        }

        .about-mission-card p {
            margin: 0;
            color: #72776d;
            font-size: 15px;
            line-height: 1.9;
        }

        .about-mission-card.highlight h3,
        .about-mission-card.highlight p {
            color: #fff;
        }

        .about-cta-wrap {
            padding: 0 0 82px;
        }

        .about-cta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
            padding: 42px 45px;
            border-radius: 22px;
            background: linear-gradient(115deg, #f2f5eb, #fff1df);
        }

        .about-cta h2 {
            margin: 0 0 12px;
            color: #2c4225;
            font-size: clamp(25px, 3vw, 34px);
        }

        .about-cta p {
            max-width: 620px;
            margin: 0;
            color: #6f7568;
            font-size: 15px;
            line-height: 1.8;
        }

        .about-cta-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            flex-shrink: 0;
        }

        @media (max-width: 950px) {
            .about-hero-grid {
                gap: 25px;
            }

            .about-value-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .about-story-grid {
                gap: 30px;
            }

            .about-cta {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 650px) {
            .about-container {
                width: min(100% - 30px, 1180px);
            }

            .about-hero {
                padding: 48px 0;
            }

            .about-hero-grid,
            .about-story-grid,
            .about-mission-grid {
                grid-template-columns: 1fr;
            }

            .about-hero h1 {
                letter-spacing: -1px;
            }

            .about-hero-art {
                min-height: 290px;
            }

            .about-section {
                padding: 58px 0;
            }

            .about-section-heading {
                margin-bottom: 30px;
            }

            .about-value-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .about-value-card {
                padding: 24px;
            }

            .about-mission-card {
                padding: 27px;
            }

            .about-cta-wrap {
                padding-bottom: 55px;
            }

            .about-cta {
                padding: 30px 23px;
            }

            .about-cta-actions,
            .about-hero-actions {
                width: 100%;
            }

            .about-cta-actions .about-btn,
            .about-hero-actions .about-btn {
                flex: 1;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .about-value-card,
            .about-btn {
                transition: none;
            }
        }
    </style>
</head>

<body>

<header class="site-header">
    <div class="header-top">
        <a class="logo" href="../index.php" aria-label="Nexora Food Home">
            <img src="../assets/images/logo.png" alt="" class="brand-logo">
            <span class="logo-text">Nexora<span>Food</span></span>
        </a>

        <form class="search-box" action="shop.php" method="get" role="search">
            <input
                type="search"
                name="search"
                placeholder="Search products..."
                aria-label="Search products"
            >
            <button type="submit" aria-label="Search">⌕</button>
        </form>

        <div class="header-actions">
            <a class="chat-link" href="contact.php" aria-label="Contact support">
                <span aria-hidden="true">☏</span>
                <small>Chat</small>
            </a>

            <a class="account-link" href="../auth/login.php">Account</a>

            <a class="header-cart" href="../cart/index.php">
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
            >
                ☰ All Categories
            </button>
        </div>

        <nav class="main-nav" aria-label="Main navigation">
            <a href="../index.php">Home</a>
            <a href="shop.php">Shop</a>
            <a href="about.php" aria-current="page">About</a>
            <a href="contact.php">Contact</a>
        </nav>

        <p class="header-tagline">Pure Origins, Trusted Quality</p>
    </div>
</header>

<main class="about-page">

    <!-- About Hero -->
    <section class="about-hero">
        <div class="about-container about-hero-grid">
            <div>
                <span class="about-eyebrow">Get to know us</span>

                <h1>
                    Welcome to<br>
                    <span>NexoraFood.</span>
                </h1>

                <p class="about-hero-copy">
                    Your everyday destination for food, snacks, beverages
                    and essential groceries. We aim to make discovering
                    everyday products simple, convenient and enjoyable.
                </p>

                <div class="about-hero-actions">
                    <a class="about-btn" href="../index.php">
                         Explore Products <span aria-hidden="true">→</span>
                    </a>

                    <a class="about-btn about-btn-secondary" href="contact.php">
                         Contact Us
                    </a>
                </div>
            </div>

            <div class="about-hero-art" aria-hidden="true">
                <div class="about-art-circle"></div>

                <div class="about-art-card">
                    <div class="about-art-icon">🛒</div>
                    <h2>Everyday Made Easier</h2>
                    <p>
                        Discover products for your kitchen and daily needs
                        in one convenient place.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Who We Are -->
    <section class="about-section">
        <div class="about-container about-story-grid">
            <div class="about-story-visual" aria-hidden="true">
                <div class="about-story-visual-inner">
                    <span>🥗</span>
                    <h3>Food & Everyday Essentials</h3>
                    <p>
                        A convenient place to explore products for your
                        everyday shopping needs.
                    </p>
                </div>
            </div>

            <div class="about-story-copy">
                <p class="about-section-label">Who we are</p>

                <h2>A simpler way to shop for everyday essentials.</h2>

                <p>
                    NexoraFood is an online shopping destination focused
                    on food, beverages, snacks and other everyday
                    essentials. Our goal is to make browsing products
                    straightforward and shopping more convenient.
                </p>

                <p>
                    From exploring different product categories to
                    reviewing your cart, we want your shopping experience
                    to feel clear, organised and easy to use.
                </p>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="about-section about-values">
        <div class="about-container">
            <div class="about-section-heading">
                <p class="about-section-label">The NexoraFood approach</p>

                <h2>Why shop with us?</h2>

                <p>
                    We focus on the things that matter when shopping
                    for everyday products: choice, clarity and convenience.
                </p>
            </div>

            <div class="about-value-grid">
                <article class="about-value-card">
                    <div class="about-value-icon" aria-hidden="true">🛍️</div>
                    <h3>Everyday Selection</h3>
                    <p>
                        Explore a range of food, snacks, beverages
                        and daily essentials in one place.
                    </p>
                </article>

                <article class="about-value-card">
                    <div class="about-value-icon" aria-hidden="true">🔎</div>
                    <h3>Easy Discovery</h3>
                    <p>
                        Browse categories and search for the products
                        you need with a simple shopping experience.
                    </p>
                </article>

                <article class="about-value-card">
                    <div class="about-value-icon" aria-hidden="true">🛒</div>
                    <h3>Convenient Shopping</h3>
                    <p>
                        Review selected items and check your cart
                        before proceeding to checkout.
                    </p>
                </article>

                <article class="about-value-card">
                    <div class="about-value-icon" aria-hidden="true">💬</div>
                    <h3>Customer Support</h3>
                    <p>
                        Have a question? Visit our contact page
                        to find the available ways to reach us.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <!-- Mission and Vision -->
    <section class="about-section">
        <div class="about-container">
            <div class="about-section-heading">
                <p class="about-section-label">Our purpose</p>
                <h2>What guides NexoraFood</h2>
                <p>
                    We want to make online shopping for everyday
                    essentials a more straightforward experience.
                </p>
            </div>

            <div class="about-mission-grid">
                <article class="about-mission-card highlight">
                    <span aria-hidden="true">🎯</span>
                    <h3>Our Mission</h3>
                    <p>
                        To provide a convenient online destination where
                        customers can explore everyday products, compare
                        options and manage their shopping with ease.
                    </p>
                </article>

                <article class="about-mission-card">
                    <span aria-hidden="true">🌱</span>
                    <h3>Our Vision</h3>
                    <p>
                        To build a dependable and user-friendly shopping
                        experience that continues to improve with the
                        needs of our customers.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
   <!-- <section class="about-cta-wrap">
        <div class="about-container">
            <div class="about-cta">
                <div>
                    <h2>Ready to explore?</h2>
                    <p>
                        Browse our available products and discover
                        what you need for your everyday shopping.
                    </p>
                </div>

                <div class="about-cta-actions">
                    <a class="about-btn" href="shop.php">
                        Shop Products →
                    </a>

                   <!-- <a class="about-btn about-btn-secondary" href="contact.php">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>-->

</main>

<!-- Floating Cart -->
<a
    class="floating-cart"
    href="../cart/index.php"
    aria-label="View cart, <?= $cartCount ?> items"
>
    <span class="floating-cart-icon" aria-hidden="true">🛒</span>
    <span>View Cart</span>
    <span class="floating-cart-count" aria-live="polite"><?= $cartCount ?></span>
</a>

<div class="nexora-toast" id="nexoraToast" role="status" aria-live="polite"></div>
<?php require_once __DIR__ . '/../includes/cart_drawer.php'; ?>

<!-- Footer -->
<footer class="site-footer">
    <div class="footer-container">

        <div class="footer-brand">
            <a href="../index.php" class="footer-logo">
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
            </div>
        </div>

        <div class="footer-links">
            <h3 class="footer-heading">Quick Links</h3>
            <a href="../index.php">Home</a>
            <a href="shop.php">Shop Products</a>
            <a href="about.php">About Us</a>
            <a href="contact.php">Contact Us</a>
            <a href="../cart/index.php">View Cart</a>
            <a href="../auth/login.php">My Account</a>
        </div>

        <div class="footer-contact">
            <h3 class="footer-heading">Contact Information</h3>

            <a href="https://nexorafoods.com"
               target="_blank"
               rel="noopener noreferrer"
               class="footer-contact-item">
                <span class="footer-contact-symbol">↗</span>
                <span>nexorafoods.com</span>
            </a>

            <a href="tel:+8801313552299" class="footer-contact-item">
                <span class="footer-contact-symbol">☎</span>
                <span>+880 1313552299</span>
            </a>

            <a href="mailto:info@nexorafoods.com" class="footer-contact-item">
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

    <div class="footer-bottom">
        <p>
            &copy; <?= date('Y') ?> NexoraFood.
            All rights reserved.
        </p>
    </div>
</footer>

    <script src="../assets/js/cart_drawer.js" defer></script>

</body>
</html>
