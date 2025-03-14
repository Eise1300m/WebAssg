$(document).ready(function () {
    $(".cart-but").click(function () {
        let book_id = $(this).closest(".book-card").find("a").attr("href").split("=")[1]; // Extract book_id
        $.ajax({
            url: "Addtocart.php",
            method: "POST",
            data: { book_id: book_id },
            success: function (response) {
                alert(response);
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


        // Also update when the "Add to Cart" button is clicked
        $(".cart-but").click(function () {
            updateCartCount();
        })

    
        $(".quantity").on("change", function () {
            let bookId = $(this).data("id");
            let quantity = $(this).val();
    
            $.ajax({
                url: "UpdateCart.php",
                method: "POST",
                data: { book_id: bookId, quantity: quantity },
                success: function (response) {
                    let data = JSON.parse(response);
                    if (data.status === "success") {
                        location.reload(); // Refresh cart page to reflect changes
                    }
                }
            });
        });
    
        // Remove item from cart
        $(".quantity").on("change", function () {
            let bookId = $(this).data("id");
            let quantity = $(this).val();
    
            $.ajax({
                url: "UpdateCart.php",
                method: "POST",
                data: { book_id: bookId, quantity: quantity },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        location.reload(); // Reload cart page to show new quantity
                    }
                }
            });
        });
    
        // Remove item from cart
        $(".remove-item").on("click", function () {
            let bookId = $(this).data("id");
    
            $.ajax({
                url: "UpdateCart.php",
                method: "POST",
                data: { book_id: bookId, quantity: 0 }, // Setting quantity to 0 removes item
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        location.reload();
                    }
                }
            });
        });

});