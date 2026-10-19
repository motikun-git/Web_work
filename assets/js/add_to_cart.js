document.addEventListener('DOMContentLoaded', function () {
    const cartForms = document.querySelectorAll(
        '.home-featured-cart-form'
    );

    cartForms.forEach(function (form) {
        form.addEventListener('submit', async function (event) {
            event.preventDefault();

            const button = form.querySelector('button[type="submit"]');

            if (!button || button.disabled) return;

            const originalText = button.textContent;
            button.disabled = true;
            button.textContent = 'Adding...';

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Could not add product.');
                }

                // Update header and floating cart counts.
                document.querySelectorAll(
                    '.header-cart-count, .floating-cart-count'
                ).forEach(function (element) {
                    element.textContent = data.cartCount;
                });

                // Update drawer item count.
                const drawerCount = document.getElementById('drawerCartCount');

                if (drawerCount) {
                    drawerCount.textContent = data.cartCount;
                }

                // Update drawer product list.
                const drawerItems = document.getElementById('cartDrawerItems');

                if (drawerItems && Array.isArray(data.items)) {
                    drawerItems.replaceChildren();

                    if (data.items.length === 0) {
                        drawerItems.innerHTML = `
                            <div class="cart-drawer-empty">
                                <span aria-hidden="true">🛒</span>
                                <h3>Your cart is empty</h3>
                                <p>Add products to see them here.</p>
                            </div>
                        `;
                    } else {
                        data.items.forEach(function (item) {
                            const row = document.createElement('div');
                            row.className = 'cart-drawer-item';

                            const info = document.createElement('div');
                            info.className = 'cart-drawer-item-info';

                            const name = document.createElement('h3');
                            name.textContent = item.name;

                            const price = document.createElement('p');
                            price.textContent =
                                '৳' + Number(item.price).toFixed(2) + ' each';

                            info.append(name, price);

                            const quantity = document.createElement('div');
                            quantity.className = 'cart-drawer-item-quantity';

                            const qty = document.createElement('span');
                            qty.textContent = 'Qty: ' + item.quantity;

                            const total = document.createElement('strong');
                            total.textContent =
                                '৳' + Number(item.lineTotal).toFixed(2);

                            quantity.append(qty, total);
                            row.append(info, quantity);
                            drawerItems.appendChild(row);
                        });
                    }
                }

                // Update subtotal.
                const subtotal = document.getElementById('cartDrawerSubtotal');

                if (subtotal) {
                    subtotal.textContent =
                        '৳' + Number(data.cartSubtotal).toFixed(2);
                }

                button.textContent = 'Added ✓';

            } catch (error) {
                console.error('Add to Cart error:', error);
                button.textContent = 'Try Again';

            } finally {
                setTimeout(function () {
                    button.textContent = originalText;
                    button.disabled = false;
                }, 1200);
            }
        });
    });
});



document.addEventListener('click', async function (event) {
    const button = event.target.closest('[data-cart-action]');

    if (!button) return;

    const action = button.dataset.cartAction;
    const productId = button.dataset.productId;

    if (!action || !productId || button.disabled) return;

    button.disabled = true;

    try {
        const response = await fetch('cart/update.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Accept': 'application/json'
            },
            body: new URLSearchParams({
                action: action,
                product_id: productId
            })
        });

        const data = await response.json();

        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Cart update failed.');
        }

        // Update cart count everywhere.
        document.querySelectorAll(
            '.header-cart-count, .floating-cart-count'
        ).forEach(function (element) {
            element.textContent = data.cartCount;
        });

        // Update drawer item count.
        const drawerCount = document.getElementById('drawerCartCount');

        if (drawerCount) {
            drawerCount.textContent = data.cartCount;
        }

        // Rebuild drawer product list safely.
        const drawerItems = document.getElementById('cartDrawerItems');

        if (drawerItems) {
            drawerItems.replaceChildren();

            if (data.items.length === 0) {
                const empty = document.createElement('div');
                empty.className = 'cart-drawer-empty';

                const heading = document.createElement('h3');
                heading.textContent = 'Your cart is empty';

                const message = document.createElement('p');
                message.textContent = 'Add products to see them here.';

                empty.append(heading, message);
                drawerItems.appendChild(empty);
            } else {
                data.items.forEach(function (item) {
                    const row = document.createElement('div');
                    row.className = 'cart-drawer-item';

                    const info = document.createElement('div');
                    info.className = 'cart-drawer-item-info';

                    const name = document.createElement('h3');
                    name.textContent = item.name;

                    const price = document.createElement('p');
                    price.textContent =
                        '৳' + Number(item.price).toFixed(2) + ' each';

                    info.append(name, price);

                    const controls = document.createElement('div');
                    controls.className = 'cart-drawer-item-quantity';

                    const quantityControls = document.createElement('div');
                    quantityControls.className = 'cart-quantity-controls';

                    function makeButton(label, actionName, ariaLabel) {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'cart-quantity-btn';
                        btn.textContent = label;
                        btn.dataset.cartAction = actionName;
                        btn.dataset.productId = item.product_id;
                        btn.setAttribute('aria-label', ariaLabel);
                        return btn;
                    }

                    quantityControls.append(
                        makeButton('−', 'decrease', 'Decrease quantity'),
                        Object.assign(document.createElement('span'), {
                            textContent: item.quantity
                        }),
                        makeButton('+', 'increase', 'Increase quantity')
                    );

                    const lineTotal = document.createElement('strong');
                    lineTotal.textContent =
                        '৳' + Number(item.lineTotal).toFixed(2);

                    const deleteButton = document.createElement('button');
                    deleteButton.type = 'button';
                    deleteButton.className = 'cart-delete-btn';
                    deleteButton.dataset.cartAction = 'delete';
                    deleteButton.dataset.productId = item.product_id;
                    deleteButton.textContent = 'Delete';

                    controls.append(
                        quantityControls,
                        lineTotal,
                        deleteButton
                    );

                    row.append(info, controls);
                    drawerItems.appendChild(row);
                });
            }
        }

        // Update subtotal.
        const subtotal = document.getElementById('cartDrawerSubtotal');

        if (subtotal) {
            subtotal.textContent =
                '৳' + Number(data.cartSubtotal).toFixed(2);
        }

    } catch (error) {
        console.error('Cart update error:', error);
        alert('Could not update cart. Please try again.');
    } finally {
        button.disabled = false;
    }
});
