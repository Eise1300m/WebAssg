$(document).ready(function () {

    initializeHelp();
    initializeLoginForm();
    initializeProfileMenu();
    initializeSignupForm();
    initializeSlider();
    initializeSearch();
    initializeRedirectButtons();
    initializeBackButtons();
    initializeProfilePicture();
    initializeLoginBuffer();
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

function initializeSignupValidationForm() {
    const form = document.getElementById("signupForm");
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
                
                if ($(this).attr('name') === 'psw') {
                    const passwordValidation = validatePassword($(this).val());
                    if (!passwordValidation.isValid) {
                        showInputError(this, 'minimun 6 char, uppercase, lowercase, special char');
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

// Validate password against security requirements
function validatePassword(password) {
    const hasLowercase = /[a-z]/.test(password);
    const hasUppercase = /[A-Z]/.test(password);
    const hasSpecial = /[\W_]/.test(password);
    const isLongEnough = password.length >= 6;
    
    return {
        isValid: hasLowercase && hasUppercase && hasSpecial && isLongEnough,
        requirements: {
            hasLowercase,
            hasUppercase,
            hasSpecial,
            isLongEnough
        }
    };
}


function initializeProfilePicture() {
    // Profile picture preview and upload handling
    const profilePicInput = document.getElementById('profile-pic-input');
    const uploadPicBtn = document.getElementById('upload-pic-btn');
    const profilePic = document.getElementById('profile-pic');
    
    if (profilePicInput && uploadPicBtn && profilePic) {
        // Show upload button and preview when a file is selected
        profilePicInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                // Show the upload button
                uploadPicBtn.style.display = 'block';
                
                // Create and use FileReader for preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePic.src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
                
                // Validate file type and size
                const file = this.files[0];
                const fileType = file.type;
                const fileSize = file.size;
                
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                const maxSize = 5 * 1024 * 1024; // 5MB
                
                if (!allowedTypes.includes(fileType)) {
                    alert('Invalid file type! Only JPG, PNG & GIF files are allowed.');
                    this.value = '';
                    uploadPicBtn.style.display = 'none';
                    return;
                }
                
                if (fileSize > maxSize) {
                    alert('File is too large! Maximum size is 5MB.');
                    this.value = '';
                    uploadPicBtn.style.display = 'none';
                    return;
                }
            }
        });
        
        // Handle form submission
        const profilePicForm = document.getElementById('profile-pic-form');
        if (profilePicForm) {
            profilePicForm.addEventListener('submit', function() {
                // Show loading indicator or disable button if needed
                uploadPicBtn.textContent = 'Uploading...';
                uploadPicBtn.disabled = true;
            });
        }
    }
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
        alert("Please enter something to search");
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

function initializeBackButtons() {
    $('.back-button').on('click', function() {
        history.back(); // Go to the previous page in browser history
    });
}

function initializeLoginBuffer() {
    let countdown = 3;
    const countdownElement = document.getElementById('countdown');
    const redirectUrl = document.getElementById('redirectUrl').getAttribute('data-url');
    
    const timer = setInterval(function() {
        countdown--;
        countdownElement.textContent = countdown;
        
        if (countdown <= 0) {
            clearInterval(timer);
            window.location.href = redirectUrl;
        }
    }, 1000);
}

function initializeHelp() {
    // Toggle FAQ answers
    $('.faq-question').on('click', function() {
        $(this).toggleClass('active');
        $(this).next('.faq-answer').slideToggle();
    });
    
    // Tab switching
    $('.help-tab').on('click', function() {
        const tabId = $(this).data('tab');
        console.log('Tab clicked:', tabId);
        
        // Update active tab
        $('.help-tab').removeClass('active');
        $(this).addClass('active');
        
        // Show the corresponding content
        $('.tab-content').removeClass('active');
        $('#' + tabId).addClass('active');
    });
}