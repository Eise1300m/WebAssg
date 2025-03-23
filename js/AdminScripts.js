$(document).ready(function() {
    initializeAdminForms();
    initializeProfilePicture();

    // Show Add Product Form
    window.showAddProductForm = function() {
        $('#productModal').show();
        $('#modalTitle').text('Add New Book');
        $('#productForm')[0].reset();
        $('#book_id').val('');
        
        // Reset subcategory dropdown
        $('#subcategory').html('<option value="">-- Select Category First --</option>');
        $('#subcategory').prop('disabled', true);
        
        // Hide any existing image preview
        $('#image-preview-container').hide();
    };

    // Close Product Modal
    window.closeProductModal = function() {
        $('#productModal').hide();
    };

    // Edit Book
    window.editBook = function(bookId) {
        // Reset any previous preview
        $('#image-preview-container').hide();
        
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
                $('#book_description').val(book.Description || '');
                
                // Set category and trigger change to load subcategories
                $('#category').val(book.CategoryNo).trigger('change');
                
                // Set subcategory after a small delay to ensure subcategories are loaded
                setTimeout(function() {
                    $('#subcategory').val(book.SubcategoryNo);
                }, 100);
                
                // Show image preview if available
                if (book.BookImage) {
                    $('#image-preview').attr('src', book.BookImage);
                    $('#image-preview-container').show();
                }
                
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
        
        // Validate required fields
        if (!$('#book_name').val() || !$('#book_price').val() || !$('#category').val() || !$('#subcategory').val()) {
            alert('Please fill in all required fields.');
            return;
        }
        
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
            },
            error: function(xhr, status, error) {
                alert('Error saving book: ' + error);
            }
        });
    });

    // Function to toggle subcategories

    // Category and Subcategory Relationship
    $('#category').on('change', function() {
        const categoryId = $(this).val();
        const subcategorySelect = $('#subcategory');
        
        // Clear and disable subcategory if no category is selected
        if (!categoryId) {
            subcategorySelect.html('<option value="">-- Select Category First --</option>');
            subcategorySelect.prop('disabled', true);
            return;
        }
        
        // Get subcategories for the selected category
        const subcategories = subcategoriesByCategory[categoryId] || [];
        
        if (subcategories.length === 0) {
            subcategorySelect.html('<option value="">No subcategories available</option>');
            subcategorySelect.prop('disabled', true);
            return;
        }
        
        // Populate subcategory dropdown
        let options = '<option value="">-- Select Subcategory --</option>';
        subcategories.forEach(function(sub) {
            options += `<option value="${sub.id}">${sub.name}</option>`;
        });
        
        subcategorySelect.html(options);
        subcategorySelect.prop('disabled', false);
    });

    // Book image preview
    $('#book_image').on('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            // Validate file size (5MB max)
            if (file.size > 5000000) {
                alert('Image file is too large. Maximum size is 5MB.');
                this.value = '';
                return;
            }

            // Validate file type
            if (!file.type.match('image.*')) {
                alert('Only image files are allowed.');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                $('#image-preview').attr('src', e.target.result);
                $('#image-preview-container').show();
            };
            reader.readAsDataURL(file);
        }
    });

    // Add form field validation styling
    function validateFormFields() {
        let isValid = true;
        
        // Check required fields
        $('#productForm [required]').each(function() {
            if (!$(this).val()) {
                $(this).addClass('field-error');
                isValid = false;
            } else {
                $(this).removeClass('field-error');
            }
        });
        
        // Price validation
        const price = parseFloat($('#book_price').val());
        if (isNaN(price) || price <= 0) {
            $('#book_price').addClass('field-error');
            alert('Please enter a valid price.');
            isValid = false;
        }
        
        return isValid;
    }

    // Update the form submission to use the validation
    $('#productForm').off('submit').on('submit', function(event) {
        event.preventDefault();
        
        // Remove field-error class when typing
        $('#productForm input, #productForm select, #productForm textarea').on('input change', function() {
            $(this).removeClass('field-error');
        });
        
        if (!validateFormFields()) {
            return false;
        }
        
        const formData = new FormData(this);
        
        // Show loading state
        const submitBtn = $(this).find('.save-btn');
        const originalText = submitBtn.text();
        submitBtn.text('Saving...').prop('disabled', true);
        
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
            },
            error: function(xhr, status, error) {
                alert('Error saving book: ' + error);
                submitBtn.text(originalText).prop('disabled', false);
            }
        });
    });

    // Initialize subcategory filter on page load
    updateSubcategoryFilter();
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

// Function to update subcategory filter based on selected category
function updateSubcategoryFilter() {
    const categoryId = $('#category-filter').val();
    const subcategorySelect = $('#subcategory-filter');
    
    // Clear current options and add "All" option
    subcategorySelect.html('<option value="all">All Subcategories</option>');
    
    // If not "all" and category exists in our mapping
    if (categoryId !== 'all' && subcategoriesByCategory[categoryId]) {
        // Add subcategories for the selected category
        subcategoriesByCategory[categoryId].forEach(function(sub) {
            const selected = (sub.id == currentSubcategoryFilter) ? 'selected' : '';
            subcategorySelect.append(`<option value="${sub.id}" ${selected}>${sub.name}</option>`);
        });
    } else {
        // If "All Categories" is selected or no subcategories for the category
        // We need to add all subcategories from all categories
        Object.keys(subcategoriesByCategory).forEach(function(catId) {
            subcategoriesByCategory[catId].forEach(function(sub) {
                const selected = (sub.id == currentSubcategoryFilter) ? 'selected' : '';
                subcategorySelect.append(`<option value="${sub.id}" ${selected}>${sub.name}</option>`);
            });
        });
    }
} 