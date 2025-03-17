$(document).ready(function () {
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
});