// Use IIFE to avoid global scope pollution
const ProductManagement = (function($) {
    // Private variables
    let _subcategoriesByCategory = {};
    let _currentCategoryFilter = 'all';
    let _currentSubcategoryFilter = 'all';

    // Private functions
    function _updateSubcategoryFilter() {
        const categorySelect = document.getElementById('category-filter');
        const subcategorySelect = document.getElementById('subcategory-filter');
        
        if (!categorySelect || !subcategorySelect) {
            console.error('Category or subcategory select not found');
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
                
                console.log('Loaded subcategories:', _subcategoriesByCategory); // Debug log
                
                // Set initial category value
                const categoryFilter = document.getElementById('category-filter');
                if (categoryFilter) {
                    categoryFilter.value = _currentCategoryFilter;
                }
                
                // Update subcategory options
                _updateSubcategoryFilter();
            } catch (e) {
                console.error('Error parsing subcategories data:', e);
                console.log('Raw data:', subcategoriesData.dataset.subcategories);
            }
        } else {
            console.error('Subcategories data element not found');
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
        init: function() {
            $(document).ready(function() {
                _initializeFilters();
                _setupEventListeners();
            });
        },

        showAddProductForm: function() {
            const modal = document.getElementById('productModal');
            if (modal) {
                modal.style.display = 'block';
            }
        },

        closeProductModal: function() {
            const modal = document.getElementById('productModal');
            if (modal) {
                modal.style.display = 'none';
            }
        },

        editBook: function(bookId) {
            console.log('Editing book:', bookId);
            // Add your edit book logic here
        },

        confirmDeleteBook: function(bookId) {
            if (confirm('Are you sure you want to delete this book?')) {
                console.log('Deleting book:', bookId);
            }
        }
    };
})(jQuery);

// Initialize the module
ProductManagement.init();

// Make functions globally available for onclick events
window.showAddProductForm = ProductManagement.showAddProductForm;
window.closeProductModal = ProductManagement.closeProductModal;
window.editBook = ProductManagement.editBook;
window.confirmDeleteBook = ProductManagement.confirmDeleteBook;

$(document).ready(function() {
    initializeAdminForms();
    initializeProfilePicture();
    initializeProductManagement();
    initializeDeliveryRequests();

    // Show Add Product Form
    window.showAddProductForm = function() {
        $('#productModal').show();
        $('#modalTitle').text('Add New Book');
        $('#productForm')[0].reset();
        $('#book_id').val('');
        
        // Reset subcategory dropdown
        $('#subcategory').html('<option value="">-- Select Category First --</option>').prop('disabled', true);
        
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
        const modal = $('#orderModal');
        const contentDiv = $('#orderDetailsContent');
        
        // Show modal with loading state
        modal.show();
        contentDiv.html('<div class="loading"><i class="fas fa-spinner fa-spin"></i> Loading order details...</div>');

        // Fetch order details
        $.ajax({
            url: 'fetchOrderDetails.php',
            type: 'POST',
            data: { order_id: orderId },
            success: function(response) {
                try {
                    if (typeof response === 'string') {
                        response = JSON.parse(response);
                    }

                    if (response.error) {
                        contentDiv.html(`<p class="error">${response.error}</p>`);
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

                    contentDiv.html(html);
                } catch (e) {
                    console.error('Error parsing response:', e);
                    contentDiv.html('<p class="error">Error loading order details.</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                contentDiv.html('<p class="error">Error loading order details.</p>');
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
                if (response.includes('successfully')) {
                    $('#productModal').hide();
                    location.reload();
                } else {
                    submitBtn.text(originalText).prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                alert('Error saving book: ' + error);
                submitBtn.text(originalText).prop('disabled', false);
            }
        });
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
                if (response.includes('successfully')) {
                    $('#productModal').hide();
                    location.reload();
                } else {
                    submitBtn.text(originalText).prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                alert('Error saving book: ' + error);
                submitBtn.text(originalText).prop('disabled', false);
            }
        });
    });

    // Initialize subcategory filter on page load
    updateSubcategoryFilter();

    // Define the subcategoriesByCategory mapping based on your database structure
    const subcategoriesByCategory = {
        1: [ // Novel
            { id: 101, name: 'Romance' },
            { id: 102, name: 'Mystery' },
            { id: 103, name: 'ScienceFiction' },
            { id: 104, name: 'Fantasy' },
            { id: 105, name: 'Horror' }
        ],
        2: [ // Comic
            { id: 201, name: 'Romance' },
            { id: 202, name: 'Horror' },
            { id: 203, name: 'Superhero' },
            { id: 204, name: 'Comedy' },
            { id: 205, name: 'Adventure' }
        ],
        3: [ // Children
            { id: 301, name: 'Pictures' },
            { id: 302, name: 'FairyTales' },
            { id: 303, name: 'Educational' },
            { id: 304, name: 'Moral' },
            { id: 305, name: 'Animal' }
        ],
        4: [ // Education
            { id: 401, name: 'Mathematic' },
            { id: 402, name: 'Science' },
            { id: 403, name: 'History' },
            { id: 404, name: 'Language' },
            { id: 405, name: 'ComputerScience' },
            { id: 406, name: 'Business' },
            { id: 407, name: 'Engineering' },
            { id: 408, name: 'Psychology' }
        ]
    };

    // Update the subcategory filter function
    function updateSubcategoryFilter() {
        const categorySelect = $('#category-filter');
        const subcategorySelect = $('#subcategory-filter');
        const selectedCategory = categorySelect.val();
        
        // Clear subcategory options
        subcategorySelect.empty();
        subcategorySelect.append('<option value="all">All Subcategories</option>');
        
        // If a specific category is selected and it exists in our mapping
        if (selectedCategory && selectedCategory !== 'all' && subcategoriesByCategory[selectedCategory]) {
            // Add subcategories for the selected category
            subcategoriesByCategory[selectedCategory].forEach(subcategory => {
                const selected = subcategory.id == currentSubcategoryFilter ? 'selected' : '';
                subcategorySelect.append(`
                    <option value="${subcategory.id}" ${selected}>
                        ${subcategory.name}
                    </option>
                `);
            });
            subcategorySelect.prop('disabled', false);
        } else {
            // If "All Categories" is selected, show all subcategories
            if (selectedCategory === 'all') {
                Object.values(subcategoriesByCategory).flat().forEach(subcategory => {
                    const selected = subcategory.id == currentSubcategoryFilter ? 'selected' : '';
                    subcategorySelect.append(`
                        <option value="${subcategory.id}" ${selected}>
                            ${subcategory.name}
                        </option>
                    `);
                });
            }
            subcategorySelect.prop('disabled', selectedCategory === '');
        }
    }

    // Initialize filters when document is ready
    $(document).ready(function() {
        // ... existing document.ready code ...

        // Initialize subcategory filter
        updateSubcategoryFilter();

        // Add change event listener for category filter
        $('#category-filter').on('change', updateSubcategoryFilter);

        // Add form submit handler
        $('#filterForm').on('submit', function(e) {
            // If "All Categories" is selected, reset subcategory to "all" as well
            if ($('#category-filter').val() === 'all') {
                $('#subcategory-filter').val('all');
            }
        });
    });
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

function updateOrderStatus(orderId, currentStatus) {
    let newStatus;
    
    // Determine the next status
    if (currentStatus === 'Preparing') {
        newStatus = 'Delivering';
    } else if (currentStatus === 'Collected') {
        newStatus = 'Complete';
    } else {
        console.error('Invalid current status:', currentStatus);
        return;
    }

    if (confirm(`Are you sure you want to mark this order as ${newStatus}?`)) {
        $.ajax({
            url: 'adminupdateorderstatus.php',
            type: 'POST',
            data: {
                order_id: orderId,
                status: newStatus
            },
            success: function(response) {
                try {
                    if (response.success) {
                        showFloatingMessage('Order status updated successfully', 'success');
                        // Reload the page after a short delay
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        showFloatingMessage(response.message || 'Error updating order status', 'error');
                    }
                } catch (e) {
                    console.error('Error processing response:', e);
                    showFloatingMessage('Error processing response', 'error');
                }
            },
            error: function() {
                showFloatingMessage('Error connecting to server', 'error');
            }
        });
    }
}

function showFloatingMessage(message, type) {
    const messageDiv = $('<div>')
        .addClass('floating-message')
        .addClass(type)
        .text(message);
    
    $('body').append(messageDiv);
    
    setTimeout(function() {
        messageDiv.fadeOut(300, function() {
            $(this).remove();
        });
    }, 3000);
}

function initializeDeliveryRequests() {
    // Close modal when clicking the X
    $('.modal .close').on('click', function() {
        $('#orderModal').hide();
    });

    // Close modal when clicking outside
    $(window).on('click', function(event) {
        if ($(event.target).hasClass('modal')) {
            $('#orderModal').hide();
        }
    });
}

// Product Management Functions
function initializeProductManagement() {
    if ($('#category-filter').length) {
        // Initialize subcategory filter on page load
        updateSubcategoryFilter();

        // Add change event listener for category filter
        $('#category-filter').on('change', updateSubcategoryFilter);

        // Add form submit handler
        $('#filterForm').on('submit', function(e) {
            if ($('#category-filter').val() === 'all') {
                $('#subcategory-filter').val('all');
            }
        });

        // Category change event for add/edit form
        $('#category').on('change', function() {
            const categoryId = $(this).val();
            const subcategorySelect = $('#subcategory');
            
            subcategorySelect.html('<option value="">-- Select Category First --</option>');
            subcategorySelect.prop('disabled', !categoryId);
            
            if (categoryId && subcategoriesByCategory[categoryId]) {
                let options = '<option value="">-- Select Subcategory --</option>';
                subcategoriesByCategory[categoryId].forEach(function(sub) {
                    options += `<option value="${sub.id}">${sub.name}</option>`;
                });
                subcategorySelect.html(options);
                subcategorySelect.prop('disabled', false);
            }
        });
    }
}

function updateSubcategoryFilter() {
    const categorySelect = $('#category-filter');
    const subcategorySelect = $('#subcategory-filter');
    const selectedCategory = categorySelect.val();
    
    subcategorySelect.empty();
    subcategorySelect.append('<option value="all">All Subcategories</option>');
    
    if (selectedCategory && selectedCategory !== 'all') {
        const subcategories = subcategoriesByCategory[selectedCategory] || [];
        subcategories.forEach(subcategory => {
            const selected = subcategory.id == currentSubcategoryFilter ? 'selected' : '';
            subcategorySelect.append(`
                <option value="${subcategory.id}" ${selected}>
                    ${subcategory.name}
                </option>
            `);
        });
    } else if (selectedCategory === 'all') {
        Object.values(subcategoriesByCategory).flat().forEach(subcategory => {
            const selected = subcategory.id == currentSubcategoryFilter ? 'selected' : '';
            subcategorySelect.append(`
                <option value="${subcategory.id}" ${selected}>
                    ${subcategory.name}
                </option>
            `);
        });
    }
    
    subcategorySelect.prop('disabled', !selectedCategory);
}

// Global variables - declare at the top
const subcategoriesByCategory = {};
let currentCategoryFilter = 'all';
let currentSubcategoryFilter = 'all';

// Function declarations
function updateSubcategoryFilter() {
    const categorySelect = document.getElementById('category-filter');
    const subcategorySelect = document.getElementById('subcategory-filter');
    
    if (!categorySelect || !subcategorySelect) return;

    const selectedCategory = categorySelect.value;
    
    // Clear existing options
    subcategorySelect.innerHTML = '<option value="all">All Subcategories</option>';
    
    // If a specific category is selected, populate its subcategories
    if (selectedCategory !== 'all' && subcategoriesByCategory[selectedCategory]) {
        subcategoriesByCategory[selectedCategory].forEach(sub => {
            const option = document.createElement('option');
            option.value = sub.id;
            option.textContent = sub.name;
            if (sub.id.toString() === currentSubcategoryFilter) {
                option.selected = true;
            }
            subcategorySelect.appendChild(option);
        });
    }
}

function handleFilterReset(e) {
    e.preventDefault();
    window.location.href = 'AdminProductManagement.php';
}

function showAddProductForm() {
    const modal = document.getElementById('productModal');
    if (modal) {
        modal.style.display = 'block';
    }
}

function closeProductModal() {
    const modal = document.getElementById('productModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

function editBook(bookId) {
    console.log('Editing book:', bookId);
    // Add your edit book logic here
}

function confirmDeleteBook(bookId) {
    if (confirm('Are you sure you want to delete this book?')) {
        console.log('Deleting book:', bookId);
    }
}

function initializeFilters() {
    const subcategoriesData = document.getElementById('subcategories-data');
    if (subcategoriesData) {
        try {
            const parsedData = JSON.parse(subcategoriesData.dataset.subcategories || '{}');
            Object.assign(subcategoriesByCategory, parsedData);
            currentCategoryFilter = subcategoriesData.dataset.currentCategory || 'all';
            currentSubcategoryFilter = subcategoriesData.dataset.currentSubcategory || 'all';
        } catch (e) {
            console.error('Error parsing subcategories data:', e);
        }
    }

    const categoryFilter = document.getElementById('category-filter');
    if (categoryFilter) {
        categoryFilter.value = currentCategoryFilter;
    }

    updateSubcategoryFilter();
}

function setupEventListeners() {
    // Category filter change event
    const categoryFilter = document.getElementById('category-filter');
    if (categoryFilter) {
        categoryFilter.addEventListener('change', updateSubcategoryFilter);
    }

    // Filter form reset event
    const filterForm = document.getElementById('filterForm');
    if (filterForm) {
        filterForm.addEventListener('reset', handleFilterReset);
    }
}

// Initialize when document is ready (using jQuery since it's already included)
$(document).ready(function() {
    initializeFilters();
    setupEventListeners();
}); 