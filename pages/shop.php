<?php
$pageTitle = 'Shop | Nexora Food';

require_once __DIR__ . '/../includes/header.php';

$shopCategories = [
    'All Products',
    'Fruits & Vegetables',
    'Meat & Fish',
    'Rice, Dal & Grains',
    'Dairy & Eggs',
    'Bakery & Snacks',
    'Beverages',
    'Cooking Essentials',
    'Frozen Food',
    'Sweets & Desserts',
    'Canned & Packaged Food',
    'Spices, Sauces & Seasonings',
    'Nuts & Dry Fruits',
    'Baby Food',
    'Organic',
];
?>

<link rel="stylesheet" href="/nexora_food/assets/css/style.css">

<main class="shop-page">

    <!-- Page Introduction -->
    <section class="shop-heading">
        <div class="shop-heading-content">
            <p class="shop-eyebrow">NEXORA FOOD</p>
            <h1>Shop All Products</h1>
            <p>Explore our grocery collection and find what you need.</p>
        </div>
    </section>

    <!-- Category Navigation -->
    <section class="shop-category-section" aria-label="Shop categories">

        <div class="shop-section-heading">
            <h2>Browse Categories</h2>
        </div>

        <nav class="shop-category-nav" aria-label="Product categories">
            <?php foreach ($shopCategories as $index => $category): ?>
                <a
                    class="shop-category-chip<?= $index === 0 ? ' is-active' : '' ?>"
                    href="#all-products"
                    data-category="<?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>"
                    <?= $index === 0 ? 'aria-current="page"' : '' ?>
                >
                    <?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>
                </a>
            <?php endforeach; ?>
        </nav>

    </section>

    <!-- Product Catalogue -->
    <section class="shop-catalogue" id="all-products">

        <!-- Catalogue Header -->
        <div class="shop-catalogue-header">

            <div class="shop-catalogue-title">
                <h2>All Products</h2>
                <p class="shop-results-count" id="shopResultsCount">
                    Browse our product collection.
                </p>
            </div>

            <div class="shop-catalogue-actions">

                <!-- Desktop sorting -->
                <div class="shop-desktop-sort">
                    <label for="shopSort">Sort by</label>

                    <select id="shopSort">
                        <option value="default">Recommended</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="name">Name: A to Z</option>
                    </select>
                </div>

                <!-- Mobile filter and sort trigger -->
                <button
                    type="button"
                    class="shop-filter-trigger"
                    id="shopFilterTrigger"
                    aria-haspopup="dialog"
                    aria-controls="shopFilterDrawer"
                    aria-expanded="false"
                >
                    <span aria-hidden="true">&#9776;</span>
                    <span>Filter &amp; Sort</span>
                </button>

            </div>

        </div>

        <!-- Search -->
        <form class="shop-search" id="shopSearchForm" role="search">
            <label class="visually-hidden" for="shopSearch">
                Search products
            </label>

            <input
                type="search"
                id="shopSearch"
                name="q"
                placeholder="Search products by name..."
                autocomplete="off"
            >

            <button type="submit" id="shopSearchButton">
                Search
            </button>
        </form>

        <!-- Active Filters -->
        <div
            class="shop-active-filters"
            id="shopActiveFilters"
            aria-live="polite"
            hidden
        >
            <div id="shopActiveFilterChips"></div>

            <button type="button" id="shopClearFilters">
                Clear all
            </button>
        </div>

        <!-- Product Grid -->
        <div
            class="shop-product-grid"
            id="shopProductGrid"
            aria-live="polite"
        >
            <div class="shop-empty-state">
                <h3>Products are coming soon</h3>

                <p>
                    Our product catalogue will appear here.
                    Please check back soon.
                </p>

                <a href="/nexora_food/index.php">
                    Back to Home
                </a>
            </div>
        </div>

    </section>

</main>

<!-- Mobile Filter and Sort Drawer -->
<div
    class="shop-filter-overlay"
    id="shopFilterOverlay"
    hidden
></div>

<aside
    class="shop-filter-drawer"
    id="shopFilterDrawer"
    role="dialog"
    aria-modal="true"
    aria-labelledby="shopFilterTitle"
    aria-hidden="true"
    inert
>
    <div class="shop-filter-drawer-header">
        <h2 id="shopFilterTitle">Filter &amp; Sort</h2>

        <button
            type="button"
            id="shopFilterClose"
            aria-label="Close filters"
        >
            &times;
        </button>
    </div>

    <div class="shop-filter-drawer-body">

        <section class="shop-filter-group">
            <h3>Category</h3>

            <label for="shopMobileCategory">Choose a category</label>

            <select id="shopMobileCategory">
                <?php foreach ($shopCategories as $category): ?>
                    <option value="<?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </section>

        <section class="shop-filter-group">
            <h3>Price Range</h3>

            <div class="shop-price-fields">
                <div>
                    <label for="shopMinPrice">Minimum (৳)</label>
                    <input
                        type="number"
                        id="shopMinPrice"
                        min="0"
                        step="1"
                        placeholder="0"
                    >
                </div>

                <div>
                    <label for="shopMaxPrice">Maximum (৳)</label>
                    <input
                        type="number"
                        id="shopMaxPrice"
                        min="0"
                        step="1"
                        placeholder="Any"
                    >
                </div>
            </div>
        </section>

        <section class="shop-filter-group">
            <label class="shop-stock-option" for="shopInStock">
                <input type="checkbox" id="shopInStock">
                <span>In-stock products only</span>
            </label>
        </section>

        <section class="shop-filter-group">
            <h3>Sort by</h3>

            <label for="shopMobileSort">Sort products</label>

            <select id="shopMobileSort">
                <option value="default">Recommended</option>
                <option value="price-low">Price: Low to High</option>
                <option value="price-high">Price: High to Low</option>
                <option value="name">Name: A to Z</option>
            </select>
        </section>

    </div>

    <div class="shop-filter-drawer-footer">
        <button type="button" id="shopResetFilters">
            Reset
        </button>

        <button type="button" id="shopApplyFilters">
            Apply Filters
        </button>
    </div>
</aside>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

<script src="/nexora_food/assets/js/shop.js" defer></script>
