$(document).ready(function () {

    // Add to cart from product listing
    $(".cart-but").click(function () {
        const bookId = $(this).data('book-id');
        if (!bookId) return; 
        let quantity = 1; 

        const quantityId = $(this).data('quantity-id');
        if (quantityId) {
            const quantityInput = $('#' + quantityId);
            if (quantityInput.length) {
                quantity = parseInt(quantityInput.val()) || 1;
            }
        }

        console.log("Adding to cart: Book ID=" + bookId + ", Quantity=" + quantity); // debug


        $.ajax({
            url: "/WebAssg/php/Order/Addtocart.php",
            method: "POST",
            data: {
                book_id: bookId,
                quantity: quantity
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    showFloatingMessage(response.message, "success");
                    updateCartCount();
                } else {
                    showFloatingMessage(response.message, "error");
                }
            },
            error: function () {
                showFloatingMessage("Error adding to cart", "error");
            }
        });
    });

    // Add to cart from book preview page
    $(document).on('click', '.add-to-cart', function () {
        const bookId = $(this).data('book-id');
        const quantity = parseInt($('#quantity').val()) || 1;

        addToCart(bookId, quantity);
    });

    // Main add to cart function
    function addToCart(bookId, quantity) {
        $.ajax({
            url: "Addtocart.php",
            method: "POST",
            data: {
                book_id: bookId,
                quantity: quantity
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    showFloatingMessage(response.message, "success");
                    updateCartCount();

                } else {
                    showFloatingMessage(response.message, "error");
                }
            },
            error: function () {
                showFloatingMessage("Error adding to cart", "error");
            }
        });
    }

    // Update cart count in navbar
    function updateCartCount() {
        $.ajax({
            url: "/WebAssg/php/Order/CartCount.php",
            method: "GET",
            success: function (response) {
                $(".cart-count").text(response);
            }
        });
    }

    // Calculate and update all totals in the cart
    function updateAllTotals() {
        let subtotal = 0;

        // Calculate each item's total and the subtotal
        $('.cart-item').each(function () {
            const price = parseFloat($(this).find('.quantity-input').data('price'));
            const quantity = parseInt($(this).find('.quantity-input').val());
            const itemTotal = price * quantity;

            // Update individual item total
            $(this).find('.total span').text('RM' + itemTotal.toFixed(2));
            subtotal += itemTotal;
        });

        // Update summary totals
        $('.summary-row:first span:last').text('RM' + subtotal.toFixed(2));
        $('.summary-total span:last').text('RM' + subtotal.toFixed(2));

        // Update item count
        $('.item-count').text($('.cart-item').length + ' Item(s)');
    }

    // Handle quantity buttons in cart
    $('.quantity-btn').click(function () {
        const input = $(this).siblings('.quantity-input');
        const bookId = input.data('id');
        let quantity = parseInt(input.val());
        const errorMsg = $(this).closest('.quantity-section').find('.quantity-error');

        if ($(this).hasClass('plus')) {
            if (quantity >= 10) {
                errorMsg.addClass('error-active');
                setTimeout(() => {
                    errorMsg.removeClass('error-active');
                }, 3000);
                return;
            }
            quantity++;
        } else if ($(this).hasClass('minus') && quantity > 1) {
            quantity--;
            errorMsg.removeClass('error-active');
        }


        updateQuantity(bookId, quantity, input);
    });

    // Function to update quantity
    function updateQuantity(bookId, quantity, input) {
        $.ajax({
            url: "UpdateCart.php",
            method: "POST",
            data: {
                book_id: bookId,
                quantity: quantity
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    input.val(quantity);
                    updateAllTotals();
                    updateCartCount();
                    showFloatingMessage("Cart updated successfully", "success");
                } else {
                    showFloatingMessage(response.message || "Error updating cart", "error");
                }
            },
            error: function () {
                showFloatingMessage("Failed to update cart", "error");
            }
        });
    }

    // Handle remove item
    $('.remove-item').click(function () {
        const button = $(this);
        const bookId = button.data('id');
        const cartItem = button.closest('.cart-item');

        $.ajax({
            url: "/WebAssg/php/Order/UpdateCart.php",
            method: "POST",
            data: {
                book_id: bookId,
                quantity: 0
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    cartItem.fadeOut(300, function () {
                        $(this).remove();
                        updateAllTotals();
                        updateCartCount();
                        showFloatingMessage("Item removed from cart", "success");


                    });
                } else {
                    showFloatingMessage(response.message || "Error removing item", "error");
                }
            },
            error: function () {
                showFloatingMessage("Failed to remove item", "error");
            }
        });
    });


    // Initialize quantity controls for the book preview page
    if ($('#quantity').length) {

        window.incrementQuantity = function () {
            const input = $('#quantity');
            let value = parseInt(input.val()) || 1;
            if (value < 10) {
                input.val(value + 1);
            }
        };

        window.decrementQuantity = function () {
            const input = $('#quantity');
            let value = parseInt(input.val()) || 1;
            if (value > 1) {
                input.val(value - 1);
            }
        };
    }


    // Payment option for checkout page
    if ($('#payment-form').length > 0) {

        $('.payment-option').on('click', function () {
            // First, reset all options to unselected state
            $('.payment-option').css({
                'borderColor': '#e0e0e0',
                'backgroundColor': 'transparent'
            });

            // Then highlight the selected option
            $(this).css({
                'borderColor': '#47186e',
                'backgroundColor': '#f5f0ff'
            });

            // Set the radio input as checked
            $(this).find('input[type="radio"]').prop('checked', true);
        });

        // Also handle when radio button is directly clicked
        $('input[name="payment_type"]').on('change', function () {
            // Reset all options
            $('.payment-option').css({
                'borderColor': '#e0e0e0',
                'backgroundColor': 'transparent'
            });

            // Highlight container of selected radio
            $(this).closest('.payment-option').css({
                'borderColor': '#47186e',
                'backgroundColor': '#f5f0ff'
            });
        });

        // Form validation on submit
        $('#payment-form').on('submit', function (e) {
            // Get the clicked button
            const clickedButton = $(document.activeElement);

            // Only validate if confirming payment (not cancelling)
            if (clickedButton.attr('name') === 'confirm_payment') {
                const paymentSelected = $('input[name="payment_type"]:checked').length > 0;

                if (!paymentSelected) {
                    e.preventDefault();
                    showFloatingMessage('Please select a payment method.', 'error');
                    return false;
                }
            }
        });
    }

    // Print receipt
    $("#print-receipt").on("click", function () {
        window.print();
    });

    // Handle checkout button click
    $('.checkout-btn').on('click', function (e) {
        e.preventDefault();
        checkCartAndProceed();
    });


    // Handle collection confirmation
    $('.collect-btn').on('click', function () {
        const orderNo = $(this).data('order-id');
        console.log("Collection button clicked for order:", orderNo);

        const confirmed = confirm('Have you received your order? This action cannot be undone.');
        console.log("User confirmed:", confirmed);

        if (confirmed) {
            console.log("Sending AJAX request to update status");
            $.ajax({
                url: 'updateOrderStatus.php',
                type: 'POST',
                data: {
                    order_id: orderNo,
                    status: 'Collected'
                },
                dataType: 'json', // Ensure expected response type is json
                success: function (response) {
                    try {
                        console.log('Response:', response);
                        if (response.success) {
                            showFloatingMessage('Thank you for confirming your collection!', 'success');
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showFloatingMessage(response.message || 'Error updating order status', 'error');
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e, response);
                        showFloatingMessage('Error processing server response', 'error');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Ajax error:', xhr.responseText);
                    showFloatingMessage('Error connecting to server', 'error');
                }
            });
        } else {
            console.log("User cancelled - no status update will be sent");
        }
    });



    // Handle order cancellation
    $('.cancel-btn').on('click', function () {
        const orderId = $(this).data('order-id');
        if (confirm('Are you sure you want to cancel this order?')) {
            $.ajax({
                url: 'updateOrderStatus.php',
                type: 'POST',
                data: {
                    order_id: orderId,
                    status: 'Cancelled'
                },
                dataType: 'json',
                success: function (response) {
                    try {
                        console.log('Response:', response);
                        if (response.success) {
                            showFloatingMessage('Order cancelled successfully', 'success');
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showFloatingMessage(response.message || 'Error cancelling order', 'error');
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e, response);
                        showFloatingMessage('Error processing server response', 'error');
                        location.reload();
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Ajax error:', xhr.responseText);
                    showFloatingMessage('Error connecting to server', 'error');
                    location.reload();
                }
            });
        }
    });
});


// Message display function
function showFloatingMessage(message, type) {
    console.log('Showing message:', message, 'Type:', type);
    const messageDiv = $('<div>')
        .addClass('floating-message')
        .addClass(type)
        .text(message);

    $('body').append(messageDiv);

    setTimeout(function () {
        messageDiv.fadeOut(300, function () {
            $(this).remove();
        });
    }, 3000);
}

// Update or add the checkCartAndProceed function
function checkCartAndProceed() {
    const cartItems = $('.cart-item').length;

    if (cartItems === 0) {
        showFloatingMessage("Your cart is empty. Please add items before proceeding to checkout.", "error");
        return;
    }

    // If cart has items, proceed to checkout
    window.location.href = 'CheckOut.php';
}