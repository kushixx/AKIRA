$(document).ready(function () {
    let cart = []; // Array to hold cart items

    // Function to fetch product details from the database
    async function fetchProductDetails(barcode) {
        try {
            const response = await $.ajax({
                url: 'get_product.php', // Replace with your backend endpoint
                method: 'GET',
                data: { barcode: barcode },
                dataType: 'json'
            });
            return response;
        } catch (error) {
            console.error('Error fetching product details:', error);
            return null;
        }
    }

    // Function to update the cart display
    function updateCartDisplay() {
        const cartBody = $('#cart-body');
        const grandTotal = $('#grand-total');
        let total = 0;

        // Clear the cart body
        cartBody.empty();

        // Loop through the cart and add rows
        cart.forEach((item, index) => {
            const rowTotal = item.price * item.quantity;
            total += rowTotal;

            const row = `
                <tr>
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                    <td>$${item.price.toFixed(2)}</td>
                    <td>$${rowTotal.toFixed(2)}</td>
                    <td>
                        <button class="btn btn-danger btn-sm remove-item" data-index="${index}">Remove</button>
                    </td>
                </tr>
            `;
            cartBody.append(row);
        });

        // Update the grand total
        grandTotal.text(total.toFixed(2));

        // Update the hidden input with the cart data
        $('#cart-data').val(JSON.stringify(cart));
    }

    // Function to add a product to the cart
    async function addToCart(barcode, quantity) {
        const product = await fetchProductDetails(barcode);

        if (product) {
            // Check if the product is already in the cart
            const existingItem = cart.find(item => item.prod_code === product.prod_code);

            if (existingItem) {
                // Update the quantity if the product is already in the cart
                existingItem.quantity += quantity;
            } else {
                // Add the product to the cart
                cart.push({
                    prod_code: product.prod_code,
                    name: product.name,
                    price: parseFloat(product.price),
                    quantity: quantity
                });
            }

            // Update the cart display
            updateCartDisplay();
        }
        // No alert for missing product, just do nothing if product is not found
    }

    // Event listener for barcode input
    $('#barcode').on('input', async function () {
        const barcode = $(this).val().trim();

        if (barcode) {
            const product = await fetchProductDetails(barcode);

            if (product) {
                // Show the quantity input and product info
                $('#quantity-container').removeClass('hidden');
                $('#product-info').removeClass('hidden');
                $('#add-to-cart').removeClass('hidden');

                // Populate product info
                $('#product-name').text(product.name);
                $('#product-price').text(product.price.toFixed(2));

                // Focus on the quantity input
                $('#quantity').focus();
            } else {
                // Instead of alerting, just hide the "add-to-cart" button and provide feedback in the UI
                $('#quantity-container').addClass('hidden');
                $('#product-info').addClass('hidden');
                $('#add-to-cart').addClass('hidden');
            }
        }
    });

    // Event listener for adding to cart
    $('#add-to-cart').on('click', function () {
        const barcode = $('#barcode').val().trim();
        const quantity = parseInt($('#quantity').val());

        if (barcode && quantity > 0) {
            addToCart(barcode, quantity);

            // Reset the inputs
            $('#barcode').val('').focus();
            $('#quantity').val('1');
            $('#quantity-container').addClass('hidden');
            $('#product-info').addClass('hidden');
            $('#add-to-cart').addClass('hidden');
        } else {
            // Only show the error if quantity is not valid
            if (quantity <= 0) {
                alert('Please enter a valid quantity!');
            }
        }
    });

    // Event listener for removing items from the cart
    $('#cart-body').on('click', '.remove-item', function () {
        const index = $(this).data('index');
        cart.splice(index, 1); // Remove the item from the cart
        updateCartDisplay(); // Update the cart display
    });

    // Event listener for checkout form submission
    $('#checkout-form').on('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Perform any additional validation or processing here
        alert('Checkout successful!');
        cart = []; // Clear the cart
        updateCartDisplay(); // Update the cart display
    });
});
