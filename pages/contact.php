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
    <meta name="description" content="Contact NexoraFood for questions, assistance and product enquiries.">

    <title>Contact Us | NexoraFood</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/animations.js" defer></script>

    <style>
        .contact-page {
            color: #30352d;
            overflow: hidden;
        }

        .contact-page * {
            box-sizing: border-box;
        }

        .contact-container {
            width: min(1180px, calc(100% - 40px));
            margin: 0 auto;
        }

        .contact-hero {
            padding: 65px 0 75px;
            background: linear-gradient(125deg, #f2f5eb, #fff5e9);
            text-align: center;
        }

        .contact-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 15px;
            border: 1px solid #dce5d5;
            border-radius: 30px;
            background: #fff;
            color: #35552B;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .contact-eyebrow::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #F28C38;
        }

        .contact-hero h1 {
            margin: 22px 0 15px;
            color: #2b4124;
            font-size: clamp(36px, 5vw, 55px);
            line-height: 1.15;
            letter-spacing: -1.5px;
        }

        .contact-hero h1 span {
            color: #F28C38;
        }

        .contact-hero p {
            max-width: 610px;
            margin: 0 auto;
            color: #70766a;
            font-size: 16px;
            line-height: 1.9;
        }

        .contact-main {
            padding: 70px 0 85px;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: .85fr 1.15fr;
            gap: 30px;
            align-items: stretch;
        }

        .contact-info-panel {
            padding: 35px;
            border-radius: 20px;
            background: #35552B;
            color: #fff;
        }

        .contact-info-panel h2 {
            margin: 0 0 14px;
            color: #fff;
            font-size: 28px;
        }

        .contact-info-intro {
            margin: 0 0 32px;
            color: rgba(255,255,255,.78);
            font-size: 14px;
            line-height: 1.9;
        }

        .contact-info-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin: 0 0 25px;
        }

        .contact-info-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 46px;
            width: 46px;
            height: 46px;
            border-radius: 13px;
            background: rgba(255,255,255,.13);
            color: #ffd3a5;
            font-size: 22px;
        }

        .contact-info-item h3 {
            margin: 2px 0 7px;
            color: #fff;
            font-size: 15px;
        }

        .contact-info-item p,
        .contact-info-item a {
            margin: 0;
            color: rgba(255,255,255,.8);
            font-size: 14px;
            line-height: 1.8;
            overflow-wrap: anywhere;
        }

        .contact-info-item a {
            text-decoration: none;
        }

        .contact-info-item a:hover {
            color: #ffd3a5;
            text-decoration: underline;
        }

        .contact-social-heading {
            margin: 35px 0 15px;
            color: #fff;
            font-size: 15px;
        }

        .contact-socials {
            display: flex;
            flex-wrap: wrap;
            gap: 11px;
        }

        .contact-socials a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 43px;
            height: 43px;
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 12px;
            background: rgba(255,255,255,.08);
            transition: background .2s ease, transform .2s ease;
        }

        .contact-socials a:hover {
            transform: translateY(-3px);
            background: rgba(255,255,255,.18);
        }

        .contact-socials img {
            display: block;
            width: 21px;
            height: 21px;
        }

        .contact-form-panel {
            padding: 38px;
            border: 1px solid #e9ecdf;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 12px 40px rgba(38,60,33,.055);
        }

        .contact-form-panel h2 {
            margin: 0 0 10px;
            color: #2b4124;
            font-size: 27px;
        }

        .contact-form-description {
            margin: 0 0 28px;
            color: #777b72;
            font-size: 14px;
            line-height: 1.8;
        }

        .contact-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .contact-field {
            display: flex;
            flex-direction: column;
            gap: 9px;
            margin-bottom: 20px;
        }

        .contact-field.full-width {
            grid-column: 1 / -1;
        }

        .contact-field label {
            color: #394333;
            font-size: 13px;
            font-weight: 700;
        }

        .contact-field input,
        .contact-field select,
        .contact-field textarea {
            width: 100%;
            min-width: 0;
            padding: 13px 14px;
            border: 1px solid #e1e5db;
            border-radius: 9px;
            outline: none;
            background: #fbfcf9;
            color: #30352d;
            font: inherit;
            font-size: 14px;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .contact-field input,
        .contact-field select {
            min-height: 47px;
        }

        .contact-field textarea {
            min-height: 145px;
            resize: vertical;
        }

        .contact-field input:focus,
        .contact-field select:focus,
        .contact-field textarea:focus {
            border-color: #6d8b60;
            box-shadow: 0 0 0 3px rgba(53,85,43,.09);
        }

        .contact-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 49px;
            padding: 13px 24px;
            border: 0;
            border-radius: 9px;
            background: #F28C38;
            color: #fff;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            transition: background .2s ease, transform .2s ease;
        }

        .contact-submit:hover {
            transform: translateY(-2px);
            background: #df7625;
        }

        .contact-form-note {
            margin: 15px 0 0;
            color: #85897f;
            font-size: 12px;
            line-height: 1.7;
        }

        .contact-map-section {
            padding: 0 0 80px;
        }

        .contact-map-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
            padding: 30px 35px;
            border: 1px solid #e8ebdf;
            border-radius: 17px;
            background: #f8f9f4;
        }

        .contact-map-card h2 {
            margin: 0 0 9px;
            color: #304629;
            font-size: 23px;
        }

        .contact-map-card p {
            margin: 0;
            color: #73786e;
            font-size: 14px;
            line-height: 1.8;
        }

        .contact-map-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            flex-shrink: 0;
            padding: 13px 19px;
            border-radius: 9px;
            background: #35552B;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: background .2s ease;
        }

        .contact-map-button:hover {
            background: #263f20;
            color: #fff;
        }

        @media (max-width: 850px) {
            .contact-grid {
                grid-template-columns: 1fr;
            }

            .contact-info-panel {
                padding: 30px;
            }
        }

        @media (max-width: 560px) {
            .contact-container {
                width: calc(100% - 30px);
            }

            .contact-hero {
                padding: 48px 0 55px;
            }

            .contact-main {
                padding: 45px 0 55px;
            }

            .contact-form-panel {
                padding: 25px 20px;
            }

            .contact-form-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .contact-map-section {
                padding-bottom: 55px;
            }

            .contact-map-card {
                align-items: flex-start;
                flex-direction: column;
                padding: 25px 22px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .contact-submit,
            .contact-socials a {
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
            <input type="search" name="search"
                   placeholder="Search products..."
                   aria-label="Search products">
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
            <button class="category-menu" id="categoryToggle"
                    type="button" aria-expanded="false">
                ☰ All Categories
            </button>
        </div>

        <nav class="main-nav" aria-label="Main navigation">
            <a href="../index.php">Home</a>
            <a href="shop.php">Shop</a>
            <a href="about.php">About</a>
            <a href="contact.php" aria-current="page">Contact</a>
        </nav>

        <p class="header-tagline">Pure Origins, Trusted Quality</p>
    </div>
</header>

<main class="contact-page">

    <!-- Hero -->
    <section class="contact-hero">
        <div class="contact-container">
            <span class="contact-eyebrow">We're here to help</span>

            <h1>We'd Love to <span>Hear From You.</span></h1>

            <p>
                Have a question about a product or need assistance?
                Get in touch with NexoraFood. We're happy to hear from you.
            </p>
        </div>
    </section>

    <!-- Contact Information and Form -->
    <section class="contact-main">
        <div class="contact-container contact-grid">

            <aside class="contact-info-panel">
                <h2>Contact Information</h2>

                <p class="contact-info-intro">
                    Choose a contact method below or send us a message
                    using the form. We'll help you find the information
                    you need.
                </p>

                <div class="contact-info-item">
                    <div class="contact-info-icon" aria-hidden="true">☎</div>
                    <div>
                        <h3>Call Us</h3>
                        <a href="tel:+8801313552299">+880 1313552299</a>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="contact-info-icon" aria-hidden="true">✉</div>
                    <div>
                        <h3>Email Us</h3>
                        <a href="mailto:info@nexorafoods.com">
                            info@nexorafoods.com
                        </a>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="contact-info-icon" aria-hidden="true">📍</div>
                    <div>
                        <h3>Our Address</h3>
                        <p>
                            House #579 (Parabar), Road #09,<br>
                            Mirpur DOHS, Dhaka-1216,<br>
                            Bangladesh.
                        </p>
                    </div>
                </div>

                <h3 class="contact-social-heading">Connect With Us</h3>

                <div class="contact-socials">
                    <a href="https://www.facebook.com/nexorafoods/"
                       target="_blank" rel="noopener noreferrer"
                       aria-label="Facebook">
                        <img src="https://cdn.simpleicons.org/facebook/FFFFFF" alt="">
                    </a>

                    <a href="https://www.instagram.com/nexorafoods_official"
                       target="_blank" rel="noopener noreferrer"
                       aria-label="Instagram">
                        <img src="https://cdn.simpleicons.org/instagram/FFFFFF" alt="">
                    </a>

                    <a href="https://www.tiktok.com/@nexorafoods"
                       target="_blank" rel="noopener noreferrer"
                       aria-label="TikTok">
                        <img src="https://cdn.simpleicons.org/tiktok/FFFFFF" alt="">
                    </a>
                </div>
            </aside>

            <section class="contact-form-panel">
                <h2>Send Us a Message</h2>

                <p class="contact-form-description">
                    Fill in the details below and tell us how we can help.
                </p>

                <!-- UI only: backend submission will be added later. -->
                <form action="#" method="post"
                      onsubmit="event.preventDefault(); alert('The contact form is currently a UI preview. Message submission will be enabled when the backend is connected.');">

                    <div class="contact-form-grid">
                        <div class="contact-field">
                            <label for="contact-name">Full Name</label>
                            <input type="text" id="contact-name"
                                   name="name" placeholder="Your full name"
                                   autocomplete="name" required>
                        </div>

                        <div class="contact-field">
                            <label for="contact-email">Email Address</label>
                            <input type="email" id="contact-email"
                                   name="email" placeholder="you@example.com"
                                   autocomplete="email" required>
                        </div>

                        <div class="contact-field full-width">
                            <label for="contact-subject">Subject</label>
                            <select id="contact-subject" name="subject" required>
                                <option value="" disabled selected>
                                    Choose a subject
                                </option>
                                <option value="Product enquiry">Product enquiry</option>
                                <option value="Order assistance">Order assistance</option>
                                <option value="Payment issue">Payment issue</option>
                                <option value="Feedback">Feedback or suggestion</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="contact-field full-width">
                            <label for="contact-message">Your Message</label>
                            <textarea id="contact-message" name="message"
                                      placeholder="How can we help you?"
                                      required></textarea>
                        </div>
                    </div>

                    <button class="contact-submit" type="submit">
                        Send Message <span aria-hidden="true">→</span>
                    </button>

                    <p class="contact-form-note">
                        This form is currently a visual preview and does not
                        send or store messages yet.
                    </p>
                </form>
            </section>

        </div>
    </section>

    <!-- Location -->
    <section class="contact-map-section">
        <div class="contact-container">
            <div class="contact-map-card">
                <div>
                    <h2>Find Us on the Map</h2>
                    <p>
                        House #579 (Parabar), Road #09,
                        Mirpur DOHS, Dhaka-1216, Bangladesh.
                    </p>
                </div>

                <a class="contact-map-button"
                   href="https://maps.app.goo.gl/rZYg1sbisnkYfyMZ7?g_st=ac"
                   target="_blank" rel="noopener noreferrer">
                    View on Google Maps ↗
                </a>
            </div>
        </div>
    </section>

</main>

<a class="floating-cart" href="../cart/index.php"
   aria-label="View cart, <?= $cartCount ?> items">
    <span class="floating-cart-icon" aria-hidden="true">🛒</span>
    <span>View Cart</span>
    <span class="floating-cart-count" aria-live="polite"><?= $cartCount ?></span>
</a>

<div class="nexora-toast" id="nexoraToast" role="status" aria-live="polite"></div>
    <?php require_once __DIR__ . '/../includes/cart_drawer.php'; ?>

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
                   target="_blank" rel="noopener noreferrer"
                   aria-label="Facebook">
                    <img src="https://cdn.simpleicons.org/facebook/1877F2"
                         alt="" width="22" height="22">
                </a>

                <a href="https://www.instagram.com/nexorafoods_official"
                   target="_blank" rel="noopener noreferrer"
                   aria-label="Instagram">
                    <img src="https://cdn.simpleicons.org/instagram/E4405F"
                         alt="" width="22" height="22">
                </a>

                <a href="https://www.tiktok.com/@nexorafoods"
                   target="_blank" rel="noopener noreferrer"
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
               target="_blank" rel="noopener noreferrer"
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
               target="_blank" rel="noopener noreferrer">
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
