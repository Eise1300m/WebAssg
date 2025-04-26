// Use IIFE to avoid global scope pollution
const ProductManagement = (function ($) {
    // Private variables
    let _subcategoriesByCategory = {};
    let _currentCategoryFilter = 'all';
    let _currentSubcategoryFilter = 'all';

    // Private functions
    function _updateSubcategoryFilter() {
        const categorySelect = document.getElementById('category-filter');
        const subcategorySelect = document.getElementById('subcategory-filter');

        if (!categorySelect || !subcategorySelect) {
            return;
        }

        const selectedCategory = categorySelect.value;

        // Clear existing options
        subcategorySelect.innerHTML = '<option value="all">All Subcategories</option>';

        // If "all" is selected, we don't need to add any options
        if (selectedCategory === 'all') return;

        // Get subcategories for selected category
        const subcategoriesData = document.getElementById('subcategories-data');
        if (!subcategoriesData) return;

        try {
            const subcategoriesMap = JSON.parse(subcategoriesData.dataset.subcategories);
            const currentSubcategory = subcategoriesData.dataset.currentSubcategory;

            if (subcategoriesMap[selectedCategory]) {
                subcategoriesMap[selectedCategory].forEach(sub => {
                    const option = document.createElement('option');
                    option.value = sub.id;
                    option.textContent = sub.name;
                    if (sub.id.toString() === currentSubcategory) {
                        option.selected = true;
                    }
                    subcategorySelect.appendChild(option);
                });
            }
        } catch (e) {
            console.error('Error updating subcategories:', e);
        }
    }

    function _handleFilterReset(e) {
        e.preventDefault();
        window.location.href = 'AdminProductManagement.php';
    }

    function _initializeFilters() {
        const subcategoriesData = document.getElementById('subcategories-data');
        if (subcategoriesData) {
            try {
                // Parse the subcategories data
                const jsonStr = subcategoriesData.dataset.subcategories;
                _subcategoriesByCategory = JSON.parse(jsonStr);
                _currentCategoryFilter = subcategoriesData.dataset.currentCategory || 'all';
                _currentSubcategoryFilter = subcategoriesData.dataset.currentSubcategory || 'all';

                // Set initial category value
                const categoryFilter = document.getElementById('category-filter');
                if (categoryFilter) {
                    categoryFilter.value = _currentCategoryFilter;
                }

                // Update subcategory options
                _updateSubcategoryFilter();
            } catch (e) {
                console.error('Error parsing subcategories data:', e);
            }
        }
    }

    function _setupEventListeners() {
        // Category filter change event
        const categoryFilter = document.getElementById('category-filter');
        if (categoryFilter) {
            categoryFilter.addEventListener('change', _updateSubcategoryFilter);
        }

        // Filter form reset event
        const filterForm = document.getElementById('filterForm');
        if (filterForm) {
            filterForm.addEventListener('reset', _handleFilterReset);
        }
    }

    // Public methods
    return {
        init: function () {
            $(document).ready(function () {
                _initializeFilters();
                _setupEventListeners();
            });
        },

        showAddProductForm: function () {
            const modal = document.getElementById('productModal');
            if (modal) {
                modal.style.display = 'block';
            }
        },

        editBook: function (bookId) {
        // Reset any previous preview
        $('#image-preview-container').hide();
            $('#image-preview').attr('src', '');

        // Fetch book details via AJAX and populate the form
        $.ajax({
            url: 'fetchBookDetails.php',
            method: 'GET',
            data: { book_id: bookId },
                dataType: 'json',
            success: function (data) {
                    try {
                        // If data is already parsed JSON (from dataType:'json'), use it directly
                        const book = data;
                        
                        if (book.error) {
                            alert('Error: ' + book.error);
                            return;
                        }
                        
                $('#book_id').val(book.BookNo);
                $('#book_name').val(book.BookName);
                        if (book.Author) {
                $('#book_author').val(book.Author);
                        }
                $('#book_price').val(book.BookPrice);
                $('#book_description').val(book.Description || '');

                // Set category and trigger change to load subcategories
                $('#category').val(book.CategoryNo).trigger('change');

                // Set subcategory after a small delay to ensure subcategories are loaded
                setTimeout(function () {
                    $('#subcategory').val(book.SubcategoryNo);
                }, 100);

                // Show image preview if available
                if (book.BookImage) {
                    $('#image-preview').attr('src', book.BookImage);
                    $('#image-preview-container').show();
                            console.log('Book image path:', book.BookImage);
                        } else {
                            console.log('No book image available');
                            $('#image-preview-container').hide();
                }

                $('#productModal').show();
                $('#modalTitle').text('Edit Book');
                    } catch (e) {
                        console.error('Error processing book data:', e);
                        alert('Error loading book details. Please try again.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Ajax error:', xhr.responseText);
                    alert('Error: Could not load book details. Please check the console for more information.');
                }
            });
        },

        confirmDeleteBook: function (bookId) {
        if (confirm('Are you sure you want to delete this book?')) {
            // Perform delete operation via AJAX
            $.ajax({
                url: 'deleteBook.php',
                method: 'POST',
                data: { book_id: bookId },
                success: function (response) {
                    alert(response);
                    location.reload();
                }
            });
            }
        }
    };
})(jQuery);

// Initialize the module
$(document).ready(function() {
    // Initialize ProductManagement
    ProductManagement.init();
    
    // Expose functions to global scope for HTML onclick handlers
    window.showAddProductForm = ProductManagement.showAddProductForm;
    window.editBook = ProductManagement.editBook;
    window.confirmDeleteBook = ProductManagement.confirmDeleteBook;
    window.closeProductModal = function() {
        $('#productModal').hide();
        $('#productForm')[0].reset();
        $('#image-preview-container').hide();
    };

    // Initialize image preview functionality
    initializeImagePreview();

    // Add global function for subcategory filter used in inline HTML
    window.updateSubcategoryFilter = function() {
        const categorySelect = document.getElementById('category-filter');
        const subcategorySelect = document.getElementById('subcategory-filter');
        
        if (!categorySelect || !subcategorySelect) return;
        
        const selectedCategory = categorySelect.value;
        
        // Clear existing options
        subcategorySelect.innerHTML = '<option value="all">All Subcategories</option>';
        
        // If "all" is selected, we don't need to add any options
        if (selectedCategory === 'all') return;
        
        // Get subcategories for selected category
        const subcategoriesData = document.getElementById('subcategories-data');
        if (!subcategoriesData) return;
        
        try {
            const subcategoriesMap = JSON.parse(subcategoriesData.dataset.subcategories);
            const currentSubcategory = subcategoriesData.dataset.currentSubcategory;
            
            if (subcategoriesMap[selectedCategory]) {
                subcategoriesMap[selectedCategory].forEach(sub => {
                    const option = document.createElement('option');
                    option.value = sub.id;
                    option.textContent = sub.name;
                    if (sub.id.toString() === currentSubcategory) {
                        option.selected = true;
                    }
                    subcategorySelect.appendChild(option);
                });
            }
        } catch (e) {
            console.error('Error updating subcategories:', e);
        }
    };

    // Initialize other admin features
    initializeAdminForms();
    initializeProfilePicture();
    initializeDeliveryRequests();
    
    if ($('.customers-grid').length) {
        initializeCustomerManagement();
    }

    // Modal handling
    $('#closeModal').on('click', closeProductModal);
    $(window).on('click', function(event) {
        if ($(event.target).hasClass('modal')) {
            closeProductModal();
        }
    });
    
    // Form validation and submission
    $('#productForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        
        if (!validateFormFields()) {
            return false;
        }

        const formData = new FormData(this);
        const bookId = $('#book_id').val();
        const url = bookId ? 'updateBook.php' : 'addBook.php';
        
        const submitBtn = $(this).find('.save-btn');
        const originalText = submitBtn.text();
        submitBtn.text('Saving...').prop('disabled', true);
        
        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                try {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert(response.message || 'Error occurred while saving the book');
                        submitBtn.text(originalText).prop('disabled', false);
                    }
                } catch (e) {
                    console.error('Error processing response:', e);
                    alert('Error occurred while saving the book');
                    submitBtn.text(originalText).prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
                console.log('Response text:', xhr.responseText);
                alert('Error occurred while saving the book');
                submitBtn.text(originalText).prop('disabled', false);
            }
        });
    });

    // Book image preview
    $('#book_image').on('change', function () {
        if (this.files && this.files[0]) {
            const file = this.files[0];

            // Validate file size (5MB max)
            if (file.size > 5000000) {
                alert('Image file is too large. Maximum size is 5MB.');
                this.value = '';
                $('#image-preview-container').hide();
                return;
            }

            // Validate file type
            if (!file.type.match('image.*')) {
                alert('Only image files are allowed.');
                this.value = '';
                $('#image-preview-container').hide();
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                $('#image-preview').attr('src', e.target.result);
                $('#image-preview-container').show();
                console.log('Preview image updated from file input');
            };
            reader.readAsDataURL(file);
        } else {
            $('#image-preview-container').hide();
        }
    });

    // Handle category change in the add/edit form
    $('#category').on('change', function() {
        const categoryId = $(this).val();
        const subcategorySelect = $('#subcategory');
        
        subcategorySelect.html('<option value="">-- Select Category First --</option>');
        subcategorySelect.prop('disabled', !categoryId);
        
        if (!categoryId) return;
        
        // Get subcategories from data attribute
        const subcategoriesData = document.getElementById('subcategories-data');
        if (!subcategoriesData) return;
        
        try {
            const subcategoriesMap = JSON.parse(subcategoriesData.dataset.subcategories);
            
            if (subcategoriesMap[categoryId]) {
                let options = '<option value="">-- Select Subcategory --</option>';
                subcategoriesMap[categoryId].forEach(function(sub) {
                    options += `<option value="${sub.id}">${sub.name}</option>`;
                });
                subcategorySelect.html(options);
                subcategorySelect.prop('disabled', false);
            }
        } catch (e) {
            console.error('Error loading subcategories for form:', e);
        }
    });
    
    // Initialize filters on page load
    if (document.getElementById('category-filter')) {
        window.updateSubcategoryFilter();
    }
});

    function validateFormFields() {
        let isValid = true;

        // Check required fields
        $('#productForm [required]').each(function () {
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

        // Remove field-error class when typing
        $('#productForm input, #productForm select, #productForm textarea').on('input change', function () {
            $(this).removeClass('field-error');
        });

    return isValid;
}

function initializeAdminForms() {
    // Clear messages on input
    $('.admin-form input').on('input', function () {
        $('.admin-message').fadeOut();
    });

    // Handle form reset
    $('.admin-btn.secondary').on('click', function (e) {
        e.preventDefault();
        $(this).closest('form')[0].reset();
    });

    // Password validation if on password page
    if ($('#new_password').length) {
        initializePasswordValidation();
    }
}

function initializePasswordValidation() {
    $('#new_password, #confirm_password').on('input', function () {
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
    // Show upload button and preview when a file is selected
    $('#profile-pic-input').on('change', function() {
        if (this.files && this.files[0]) {
            // Get the file
            const file = this.files[0];
            
            // Show the upload button
            $('#upload-pic-btn').show();
            
            // Preview the image
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#profile-pic').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
            
            // Log file info for debugging
            console.log('File selected:', file.name, file.type, file.size);
        }
    });
    
    // Handle form submission
    $('#profile-pic-form').on('submit', function(e) {
        console.log('Profile picture form submitted');
        
        // Check if a file is selected
        const fileInput = $('#profile-pic-input')[0];
        if (!fileInput.files || !fileInput.files[0]) {
            console.error('No file selected');
            e.preventDefault();
            return false;
        }
        
        // Validate file type (additional client-side check)
        const file = fileInput.files[0];
        const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
        
        if (!validTypes.includes(file.type)) {
            alert('Invalid file type. Please select a JPEG, PNG, or GIF image.');
            e.preventDefault();
            return false;
        }
        
        // Validate file size (less than 2MB)
        const maxSize = 2 * 1024 * 1024; // 2MB
        if (file.size > maxSize) {
            alert('File is too large. Maximum size is 2MB.');
            e.preventDefault();
            return false;
        }
        
        // Continue with form submission
        return true;
    });
    
    // If upload button exists, ensure it's initially hidden
    if ($('#upload-pic-btn').length) {
        $('#upload-pic-btn').hide();
    }
}

function updateOrderStatus(orderId, newStatus) {
    let confirmMessage = '';
    switch(newStatus) {
        case 'Delivering':
            confirmMessage = 'Are you sure you want to mark this order as Delivering?';
            break;
        case 'Complete':
            confirmMessage = 'Are you sure you want to mark this order as Complete?';
            break;
        default:
            confirmMessage = 'Are you sure you want to update this order status?';
    }

    if (confirm(confirmMessage)) {
        $.ajax({
            url: 'AdminDeliveryRequests.php',
            type: 'POST',
            data: { 
                action: 'update_status',
                order_id: orderId,
                new_status: newStatus
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showFloatingMessage('Order status updated successfully!', 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    showFloatingMessage(response.message || 'Failed to update order status.', 'error');
                }
            },
            error: function() {
                showFloatingMessage('An error occurred. Please try again.', 'error');
            }
        });
    }
}

function showFloatingMessage(message, type) {
    // Remove any existing message
    $('.floating-message').remove();
    
    // Create message element
    const messageElement = $('<div>')
        .addClass('floating-message')
        .addClass(type)
        .text(message);
    
    // Add to body
    $('body').append(messageElement);
    
    // Remove after 3 seconds
    setTimeout(function() {
        messageElement.fadeOut(300, function() {
            $(this).remove();
        });
    }, 3000);
}

function initializeDeliveryRequests() {
    // Modal functionality
    const modal = document.getElementById("orderModal");
    const span = document.getElementsByClassName("close")[0];

    if (span) {
        span.onclick = function() {
            modal.style.display = "none";
        }
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

// Customer Management Functions
function initializeCustomerManagement() {
    const searchInput = $('.search-input');
    const resetButton = $('#resetButton');

    // Handle reset button click
    resetButton.on('click', function(e) {
        e.preventDefault();
        searchInput.val(''); // Clear the search input
        resetButton.hide(); // Hide the reset button
        window.location.href = 'AdminCheckCust.php'; // Redirect to clean URL
    });

    // Show/hide reset button based on search input
    searchInput.on('input', function() {
        const hasValue = this.value.trim().length > 0;
        resetButton.toggle(hasValue);
    });

    // Set initial reset button visibility
    resetButton.toggle(searchInput.val().trim().length > 0);
}

function filterCustomerCards(query) {
    query = query.toLowerCase();
    $('.customer-card').each(function() {
        const card = $(this);
        const username = card.find('.customer-basic-info h3').text().toLowerCase();
        const email = card.find('.info-group:contains("Email:") p').text().toLowerCase();
        const id = card.find('.customer-basic-info p').text().toLowerCase();

        if (username.includes(query) || email.includes(query) || id.includes(query)) {
            card.show();
        } else {
            card.hide();
        }
    });
}

// Order Details Modal
function viewOrderDetails(orderId) {

    $.ajax({
        url: '/WebAssg/php/Order/fetchOrderDetails.php',
        type: 'POST',
        data: { order_id: orderId },
        
        success: function(response) {
            try {
                if (typeof response === 'string') {
                    response = JSON.parse(response);
                }

                if (response.error) {
                    $('#orderDetailsContent').html(`<p class="error">${response.error}</p>`);
                    return;
                }

                const data = response;
                let html = `
                    <div class="order-details-grid">
                        <div class="order-info-section">
                            <h3>Order Information</h3>
                            <div class="info-row">
                                <span class="info-label">Order ID:</span>
                                <span>#${data.order.OrderNo}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Order Date:</span>
                                <span>${new Date(data.order.OrderDate).toLocaleDateString()}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Status:</span>
                                <span class="status-badge ${data.order.OrderStatus.toLowerCase()}">${data.order.OrderStatus}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Payment Method:</span>
                                <span>${data.order.PaymentType}</span>
                            </div>
                        </div>
                        
                        <div class="order-info-section">
                            <h3>Customer Information</h3>
                            <div class="info-row">
                                <span class="info-label">Name:</span>
                                <span>${data.order.Username}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Email:</span>
                                <span>${data.order.Email}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Contact:</span>
                                <span>${data.order.ContactNo}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Shipping Address:</span>
                                <span>${data.order.ShippingAddress}</span>
                            </div>
                        </div>
                    </div>

                    <div class="order-info-section">
                        <h3>Order Items</h3>
                        <table class="order-items-table">
                            <thead>
                                <tr>
                                    <th>Book</th>
                                    <th>Author</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>`;

                let totalAmount = 0;
                data.items.forEach(item => {
                    const subtotal = item.Quantity * item.Price;
                    totalAmount += subtotal;
                    html += `
                        <tr>
                            <td>
                                <div class="book-info">
                                    <img src="${item.BookImage}" alt="${item.BookName}" class="book-thumbnail">
                                    <span>${item.BookName}</span>
                                </div>
                            </td>
                            <td>${item.Author}</td>
                            <td>${item.Quantity}</td>
                            <td>RM ${parseFloat(item.Price).toFixed(2)}</td>
                            <td>RM ${subtotal.toFixed(2)}</td>
                        </tr>`;
                });

                html += `
                            <tr class="total-row">
                                <td colspan="4">Total Amount:</td>
                                <td>RM ${parseFloat(data.order.TotalAmount).toFixed(2)}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>`;

                $('#orderDetailsContent').html(html);
            } catch (e) {
                console.error('Error parsing response:', e);
                $('#orderDetailsContent').html('<p class="error">Error loading order details.</p>');
            }
            
            $('#orderModal').show();
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
            $('#orderDetailsContent').html('<p class="error">Error loading order details.</p>');
            $('#orderModal').show();
        }
    });
}

function closeOrderModal() {
    $('#orderModal').hide();
}

// Order cancellation functionality
(function() {
    
    // Private variable to store the order ID being cancelled
    // let orderIdToCancel = null;
    
    // Initialize event listeners when document is ready
    $(document).ready(function() {
        // Close cancel modal when clicking the close button
        $(document).on('click', '#cancelModal .close', function() {
            closeCancelModal();
        });
        
        // Close cancel modal when clicking outside of it
        $(window).on('click', function(event) {
            if ($(event.target).is('#cancelModal')) {
                closeCancelModal();
            }
        });
        
        // Handle confirm button click in cancel modal
        $(document).on('click', '#cancelModal .confirm-btn', function() {
            processOrderCancellation();
        });
        
        // Handle cancel button click in cancel modal
        $(document).on('click', '#cancelModal .cancel-btn', function() {
            closeCancelModal();
        });
        

    });
    
    // Function to show the cancel modal
    function showCancelModal(orderId) {
        orderIdToCancel = orderId;
        $('#cancelModal').show();
    }
    
    // Function to close the cancel modal
    function closeCancelModal() {
        $('#cancelModal').hide();
        orderIdToCancel = null;
    }
    
    // Expose functions to the global scope
    window.cancelOrder = showCancelModal;
    window.closeCancelModal = closeCancelModal;
    // window.confirmCancel = processOrderCancellation;
})();

// Function to initialize image preview in the book CRUD modal
function initializeImagePreview() {
    // Book image preview - make sure CSS is set correctly
    if ($('#image-preview-container').length) {
        // Set the CSS for the image preview container
        $('#image-preview-container').css({
            'margin-top': '10px',
            'max-width': '200px',
            'border': '1px solid #ddd',
            'padding': '5px',
            'background': '#fff'
        });

        // Set the CSS for the image preview
        $('#image-preview').css({
            'width': '100%',
            'height': 'auto',
            'display': 'block'
        });
        
        // Add error handler for image loading
        $('#image-preview').on('error', function() {
            console.error('Failed to load image:', $(this).attr('src'));
            // Try to load default image if loading fails
            $(this).attr('src', '/WebAssg/upload/bookPfp/BookCoverUnavailable.webp');
        });
        
        // Add load success handler
        $('#image-preview').on('load', function() {
            console.log('Successfully loaded image:', $(this).attr('src'));
            $('#image-preview-container').show();
        });
    }

    // Ensure book image is shown on edit
    $(document).on('click', '.edit-book-btn', function() {
        const bookId = $(this).data('book-id');
        if (bookId) {
            // First hide the preview container until we have data
            $('#image-preview-container').hide();
            editBook(bookId);
        }
    });
}

