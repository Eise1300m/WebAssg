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

    // Review functionality
    initializeReviewStars();

    // Print receipt
    $("#print-receipt").on("click", function() {
        window.print();
    });
});

// Initialize review stars
function initializeReviewStars() {
    const starLabels = document.querySelectorAll('.stars-container label');
    
    if (!starLabels.length) return; // Exit if no stars on page
    
    starLabels.forEach(label => {
        label.addEventListener('mouseenter', function() {
            // Change to solid star icon on hover
            this.querySelector('i').classList.remove('far');
            this.querySelector('i').classList.add('fas');
            
            // Do the same for stars to the right
            let nextLabel = this;
            while (nextLabel = nextLabel.nextElementSibling) {
                if (nextLabel.tagName === 'LABEL') {
                    nextLabel.querySelector('i').classList.remove('far');
                    nextLabel.querySelector('i').classList.add('fas');
                }
            }
        });
        
        label.addEventListener('mouseleave', function() {
            // Reset all stars to outline unless checked
            document.querySelectorAll('.stars-container label i').forEach(icon => {
                if (!icon.parentElement.previousElementSibling.checked) {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                }
            });
            
            // Keep solid stars for checked rating
            const checkedInput = document.querySelector('.stars-container input:checked');
            if (checkedInput) {
                let currentLabel = checkedInput.nextElementSibling;
                currentLabel.querySelector('i').classList.remove('far');
                currentLabel.querySelector('i').classList.add('fas');
                
                while (currentLabel = currentLabel.nextElementSibling) {
                    if (currentLabel.tagName === 'LABEL') {
                        currentLabel.querySelector('i').classList.remove('far');
                        currentLabel.querySelector('i').classList.add('fas');
                    }
                }
            }
        });
    });
    
    // Initialize stars based on existing review
    const checkedInput = document.querySelector('.stars-container input:checked');
    if (checkedInput) {
        let currentLabel = checkedInput.nextElementSibling;
        currentLabel.querySelector('i').classList.remove('far');
        currentLabel.querySelector('i').classList.add('fas');
        
        while (currentLabel = currentLabel.nextElementSibling) {
            if (currentLabel.tagName === 'LABEL') {
                currentLabel.querySelector('i').classList.remove('far');
                currentLabel.querySelector('i').classList.add('fas');
            }
        }
    }
}