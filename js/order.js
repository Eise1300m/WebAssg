$(document).ready(function () {
    // Cart functionality
    $(".cart-but").click(function () {
        let book_id = $(this).closest(".book-card").find("a").attr("href").split("=")[1]; // Extract book_id
        $.ajax({
            url: "Addtocart.php",
            method: "POST",
            data: { book_id: book_id },
            success: function (response) {
                alert(response);
                updateCartCount();
            },
            error: function () {
                alert("Error adding to cart");
            }
        });
    });

    function updateCartCount() {
        $.ajax({
            url: "CartCount.php", // This file will return the cart count
            method: "GET",
            success: function (response) {
                $(".cart-count").text(response);
            }
        });
    }

    // Calculate cart total
    function calculateTotal() {
        let total = 0;
        $('.quantity').each(function() {
            const price = parseFloat($(this).data('price'));
            const quantity = parseInt($(this).val());
            total += price * quantity;
        });
        $('#cart-total').text('RM' + total.toFixed(2));
    }

    // Update item total
    function updateItemTotal(input) {
        const price = parseFloat($(input).data('price'));
        const quantity = parseInt($(input).val());
        const total = price * quantity;
        $(input).closest('tr').find('.item-total').text('RM' + total.toFixed(2));
    }

    // Handle quantity change
    $('.quantity').on('change', function() {
        const bookId = $(this).data('id');
        const quantity = $(this).val();
        const input = $(this);

        $.ajax({
            url: "UpdateCart.php",
            method: "POST",
            data: { book_id: bookId, quantity: quantity },
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    updateItemTotal(input);
                    calculateTotal();
                    updateCartCount();
                }
            }
        });
    });

    // Handle remove item
    $('.remove-item').on('click', function() {
        const bookId = $(this).data('id');
        const row = $(this).closest('tr');

        $.ajax({
            url: "UpdateCart.php",
            method: "POST",
            data: { book_id: bookId, quantity: 0 },
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    row.fadeOut(300, function() {
                        $(this).remove();
                        calculateTotal();
                        updateCartCount();
                        
                        // Check if cart is empty
                        if ($('tbody tr').length === 0) {
                            $('#cart-container').html('<p>Your cart is empty.</p>');
                        }
                    });
                }
            }
        });
    });

    // Book Preview quantity control
    window.incrementQuantity = function() {
        const input = document.getElementById('quantity');
        const value = parseInt(input.value) || 1;
        input.value = value + 1;
    };

    window.decrementQuantity = function() {
        const input = document.getElementById('quantity');
        const value = parseInt(input.value) || 1;
        if (value > 1) {
            input.value = value - 1;
        }
    };

    // Add to cart from book preview
    window.addToCart = function(bookId) {
        const quantity = document.getElementById('quantity').value;
        
        $.ajax({
            url: "Addtocart.php",
            method: "POST",
            data: { 
                book_id: bookId,
                quantity: quantity
            },
            success: function(response) {
                alert(response);
                updateCartCount();
            },
            error: function() {
                alert("Error adding to cart");
            }
        });
    };

    // Payment option handling for checkout page
    if ($('#payment-form').length > 0) {
        // Get all payment options
        const paymentOptions = $('.payment-option');
        
        // Make payment options more obvious when selected
        paymentOptions.each(function() {
            $(this).on('click', function() {
                // First, reset all options to unselected state
                paymentOptions.each(function() {
                    $(this).css({
                        'borderColor': '#e0e0e0',
                        'backgroundColor': 'transparent'
                    });
                });
                
                // Then highlight the selected option
                $(this).css({
                    'borderColor': '#47186e',
                    'backgroundColor': '#f5f0ff'
                });
                
                // Set the radio input as checked
                const radio = $(this).find('input[type="radio"]');
                radio.prop('checked', true);
            });
        });
        
        // Form validation on submit
        $('#payment-form').on('submit', function(e) {
            // Get the clicked button
            const clickedBtn = e.originalEvent ? e.originalEvent.submitter : null;
            
            // Only validate if confirming payment (not cancelling)
            if (clickedBtn && clickedBtn.name === 'confirm_payment') {
                const paymentSelected = $('input[name="payment_type"]:checked').length > 0;
                
                if (!paymentSelected) {
                    e.preventDefault();
                    alert('Please select a payment method.');
                    return false;
                }
            }
        });
    }

    // Print receipt
    $("#print-receipt").on("click", function() {
        window.print();
    });
});

// Initialize review stars

        // Highlight selected payment option
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', function() {
                // Select the radio button when clicking anywhere in the option
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
            });
        });
    
