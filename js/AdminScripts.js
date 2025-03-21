$(document).ready(function() {
    initializeAdminForms();
    initializeProfilePicture();

    // Show Add Product Form
    window.showAddProductForm = function() {
        $('#productModal').show();
        $('#modalTitle').text('Add New Book');
        $('#productForm')[0].reset();
        $('#book_id').val('');
    };

    // Close Product Modal
    window.closeProductModal = function() {
        $('#productModal').hide();
    };

    // Edit Book
    window.editBook = function(bookId) {
        // Fetch book details via AJAX and populate the form
        $.ajax({
            url: 'fetchBookDetails.php',
            method: 'GET',
            data: { book_id: bookId },
            success: function(data) {
                const book = JSON.parse(data);
                $('#book_id').val(book.BookNo);
                $('#book_name').val(book.BookName);
                $('#book_price').val(book.BookPrice);
                $('#category').val(book.CategoryNo);
                $('#productModal').show();
                $('#modalTitle').text('Edit Book');
            }
        });
    };

    // Confirm Delete Book
    window.confirmDeleteBook = function(bookId) {
        if (confirm('Are you sure you want to delete this book?')) {
            // Perform delete operation via AJAX
            $.ajax({
                url: 'deleteBook.php',
                method: 'POST',
                data: { book_id: bookId },
                success: function(response) {
                    alert(response);
                    location.reload();
                }
            });
        }
    };

    // View Order Details
    window.viewOrderDetails = function(orderId) {
        // Fetch order details via AJAX and display in modal
        $.ajax({
            url: 'fetchOrderDetails.php',
            method: 'GET',
            data: { order_id: orderId },
            success: function(data) {
                $('#orderDetailsContent').html(data);
                $('#orderModal').show();
            }
        });
    };

    // Close Order Modal
    window.closeOrderModal = function() {
        $('#orderModal').hide();
    };

    // Handle Product Form Submission
    $('#productForm').submit(function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        $.ajax({
            url: 'saveBook.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response);
                $('#productModal').hide();
                location.reload();
            }
        });
    });

    // Function to toggle subcategories

});

function initializeAdminForms() {
    // Clear messages on input
    $('.admin-form input').on('input', function() {
        $('.admin-message').fadeOut();
    });

    // Handle form reset
    $('.admin-btn.secondary').on('click', function(e) {
        e.preventDefault();
        $(this).closest('form')[0].reset();
    });

    // Password validation if on password page
    if ($('#new_password').length) {
        initializePasswordValidation();
    }
}

function initializePasswordValidation() {
    $('#new_password, #confirm_password').on('input', function() {
        let newPass = $('#new_password').val();
        let confirmPass = $('#confirm_password').val();

        if (confirmPass && newPass !== confirmPass) {
            $('#confirm_password')[0].setCustomValidity("Passwords do not match!");
        } else {
            $('#confirm_password')[0].setCustomValidity("");
        }
    });
}

function initializeProfilePicture() {
    // Show preview and upload button when file is selected
    $('#profile-pic-input').on('change', function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            // Validate file size (5MB max)
            if (file.size > 5000000) {
                alert('File is too large. Maximum size is 5MB.');
                this.value = '';
                return;
            }

            // Validate file type
            if (!file.type.match('image.*')) {
                alert('Only image files are allowed.');
                this.value = '';
                return;
            }

            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                $('.admin-avatar').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);

            // Show upload button
            $('#upload-pic-btn').show();
        }
    });
} 