$(document).ready(function () {
    // Initialize all necessary functions
    initializeLoginForm();
    initializeProfileMenu();
    initializeOrderHistory();
    initializeSignupForm();
    initializeSlider();
    initializeSearch();
    initializeRedirectButtons();
});

// Login Form Handling
function initializeLoginForm() {
    const form = document.getElementById("login-form");
    if (form) {
        // Clear error messages when user types
        form.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                const errorElement = this.nextElementSibling;
                if (errorElement && errorElement.classList.contains('error-message')) {
                    errorElement.textContent = '';
                }
            });
        });

        // Handle form submission
        form.addEventListener('submit', function(event) {
            let isValid = true;
            const username = form.querySelector('input[name="Username"]').value.trim();
            const password = form.querySelector('input[name="Userpwd"]').value.trim();

            if (!username) {
                showFieldError('Username', 'Please enter your username');
                isValid = false;
            }

            if (!password) {
                showFieldError('Userpwd', 'Please enter your password');
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    }
}

// Profile Menu Handling
function initializeProfileMenu() {
    $("#profileIcon").click(function(e) {
        e.stopPropagation();
        $("#profileDropdown").toggleClass("show");
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('.profile-dropdown').length) {
            $("#profileDropdown").removeClass("show");
        }
    });

    $(".profile-menu-items a").click(function() {
        $("#profileDropdown").removeClass("show");
    });
}

// Order History Handling
function initializeOrderHistory() {
    $('.collect-btn').on('click', function() {
        const orderId = $(this).data('order-id');
        $.ajax({
            url: 'UserOrderHistory.php',
            type: 'POST',
            data: {
                action: 'confirm_collection',
                order_id: orderId
            },
            success: function(response) {
                try {
                    const result = JSON.parse(response);
                    if (result.success) {
                        showFloatingMessage('Order collection confirmed successfully!', 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        showFloatingMessage(result.message || 'Failed to confirm collection.', 'error');
                    }
                } catch (e) {
                    showFloatingMessage('Error processing response.', 'error');
                }
            },
            error: function() {
                showFloatingMessage('Error confirming collection. Please try again.', 'error');
            }
        });
    });
}

// Utility Functions
function showFieldError(fieldName, message) {
    const input = document.querySelector(`input[name="${fieldName}"]`);
    if (input) {
        let errorElement = input.nextElementSibling;
        if (!errorElement || !errorElement.classList.contains('error-message')) {
            errorElement = document.createElement('small');
            errorElement.className = 'error-message';
            input.parentNode.insertBefore(errorElement, input.nextSibling);
        }
        errorElement.textContent = message;
    }
}

function showFloatingMessage(message, type = 'error') {
    const messageElement = $('<div>')
        .addClass('floating-message')
        .addClass(type)
        .text(message)
        .appendTo('body');

    setTimeout(() => {
        messageElement.fadeOut(300, function() {
            $(this).remove();
        });
    }, 3000);
}

function validateForm(formId) {
    const form = $(`#${formId}`);
    let isValid = true;

    form.find('input[required]').each(function() {
        const input = $(this);
        const value = input.val().trim();
        const fieldName = input.attr('name');
        const errorElement = $(`#${fieldName}Error`);

        if (!value) {
            errorElement.text(`${fieldName} is required`);
            input.addClass('invalid');
            isValid = false;
        } else {
            errorElement.text('');
            input.removeClass('invalid');
        }
    });

    return isValid;
}

function initializeSignupForm() {
    const form = $('#signupForm');
    if (!form.length) return;

    // Function to show error message below an input
    function showInputError(input, message) {
        const container = $(input).closest('.input-container');
        let errorDiv = container.find('.error-message');
        
        if (errorDiv.length === 0) {
            errorDiv = $('<div class="error-message"></div>');
            container.append(errorDiv);
        }
        
        errorDiv.text(message);
        $(input).addClass('error');
    }

    // Function to clear error message
    function clearInputError(input) {
        const container = $(input).closest('.input-container');
        const errorDiv = container.find('.error-message');
        errorDiv.text('');
        $(input).removeClass('error');
    }

    // Validate signup form
    form.on('submit', function(e) {
        let isValid = true;
        
        // Clear all previous error messages
        $('.error-message').text('');
        $('input').removeClass('error');
        
        // Validate each required field
        $(this).find('input[required]').each(function() {
            if (!$(this).val().trim()) {
                showInputError(this, 'This field is required');
                isValid = false;
            } else {
                clearInputError(this);
                
                // Additional validation for specific fields
                if ($(this).attr('type') === 'email') {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test($(this).val())) {
                        showInputError(this, 'Invalid email format');
                        isValid = false;
                    }
                }
                
                if ($(this).attr('name') === 'tel') {
                    const phoneRegex = /^01[0-9]{8,9}$/;
                    if (!phoneRegex.test($(this).val())) {
                        showInputError(this, 'Invalid phone number format');
                        isValid = false;
                    }
                }
            }
        });
        
        // Check if passwords match
        const password = $('input[name="psw"]');
        const confirmPassword = $('input[name="pswcfm"]');
        if (password.val() && confirmPassword.val() && password.val() !== confirmPassword.val()) {
            showInputError(confirmPassword, 'Passwords do not match');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
        }
    });

    // Clear error message when user starts typing
    form.find('input').on('input', function() {
        clearInputError(this);
    });
}

// Slider functionality
function initializeSlider() {
    const sliderContent = $('.slider-content');
    const backBtn = $('#back');
    const nextBtn = $('#next');
    const images = [
        '../img/Intro1.png',
        '../img/Intro2.png',
        '../img/Intro3.png'
    ];
    let currentIndex = 0;

    // Function to update slider image
    function updateSlider() {
        sliderContent.find('img').fadeOut(500, function() {
            $(this).attr('src', images[currentIndex]).fadeIn(500);
        });
    }

    // Next button click handler
    nextBtn.on('click', function() {
        currentIndex = (currentIndex + 1) % images.length;
        updateSlider();
    });

    // Back button click handler
    backBtn.on('click', function() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateSlider();
    });

    // Auto slide every 5 seconds
    let slideInterval = setInterval(function() {
        currentIndex = (currentIndex + 1) % images.length;
        updateSlider();
    }, 5000);

    // Pause auto-slide on hover
    sliderContent.hover(
        function() {
            clearInterval(slideInterval);
        },
        function() {
            slideInterval = setInterval(function() {
                currentIndex = (currentIndex + 1) % images.length;
                updateSlider();
            }, 5000);
        }
    );

    // Initialize slider
    updateSlider();
}

// Search functionality
function initializeSearch() {
    // Check if elements exist
    const searchButton = $("#searchButton");
    const searchInput = $("#searchInput");
    
    if (searchButton.length && searchInput.length) {
        // Click handler for search button
        searchButton.on('click', function() {
            performSearch();
        });
        
        // Enter key handler for search input
        searchInput.on('keypress', function(event) {
            if (event.key === "Enter") {
                performSearch();
            }
        });
    } 
}

function performSearch() {
    const searchQuery = $("#searchInput").val().trim();
    
    if (searchQuery) {
        const searchUrl = `MainPage.php?search=${encodeURIComponent(searchQuery)}`;
        window.location.href = searchUrl;
    } else {
        alert("Please enter a search term");
    }
}

function initializeRedirectButtons() {
    $('.redirect-button').on('click', function() {
        const url = $(this).data('redirect-url');
        if (url) {
            window.location.href = url;
        }
    });
}