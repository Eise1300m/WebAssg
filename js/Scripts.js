$(document).ready(function () {
    /** =================== FORM VALIDATION =================== **/
    initializeFormValidation();
    
    /** =================== LOGIN VALIDATION =================== **/
    initForms();
    handleLoginRedirect();
    
    /** =================== SEARCH FUNCTIONALITY =================== **/
    initializeSearch();
    
    /** =================== IMAGE SLIDER =================== **/
    initializeImageSlider();
    
    /** =================== PROFILE MANAGEMENT =================== **/
    initializeProfileManagement();
    
    /** =================== ADMIN FUNCTIONALITY =================== **/
    initializeAdminFeatures();
    
    /** =================== BOOK PREVIEW FUNCTIONALITY =================== **/
    initializeBookPreview();
    
    /** =================== LOGIN BUFFER =================== **/
    if (document.getElementById('countdown')) {
        initializeLoginBuffer();
    }

    /** =================== PROFILE MENU FUNCTIONS =================== **/
    initializeProfileMenu();

    // Order History Functionality
    initializeOrderHistory();
});

/** =================== FORM VALIDATION FUNCTIONS =================== **/
function initializeFormValidation() {
    // Clears error messages on input change
    $("input").on("input", function () {
        $(this).next(".error-message").text("");
    });

    // Password confirmation check
    $("#psw, #pswcfm").on("input", function () {
        let password = $("#psw").val();
        let confirmPassword = $("#pswcfm").val();

        if (confirmPassword !== "" && password !== confirmPassword) {
            $("#pswcfmError").text("Passwords do not match!");
        } else {
            $("#pswcfmError").text("");
        }
    });

    // Signup form validation
    $("#signupForm").submit(function (event) {
        validateSignupForm(event);
    });
}

function validateSignupForm(event) {
        let phoneNumber = $("#tel").val().trim();
    let phonePattern = /^01\d{8,9}$/;
        let email = $("#emails").val().trim();
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        let isValid = true;

    $(".error-message").text("");

        if ($("#UName").val() === "") {
            $("#nameError").text("Name is required!");
            isValid = false;
        }

        if ($("#psw").val() === "") {
            $("#pswError").text("Password is required!");
            isValid = false;
        }

        if ($("#psw").val() !== $("#pswcfm").val()) {
            $("#pswcfmError").text("Passwords do not match!");
            isValid = false;
        } else if ($("#pswcfm").val() === "") {
            $("#pswcfmError").text("Confirmation password is required!");
            isValid = false;
        }

        if (email === "") {
            $("#emailError").text("Email is required!");
            isValid = false;
        } else if (!emailPattern.test(email)) {
            $("#emailError").text("Invalid email format! (e.g., example@domain.com)");
            isValid = false;
        }

        if (phoneNumber === "") {
            $("#telError").text("Phone number is required!");
            isValid = false;
        } else if (!phonePattern.test(phoneNumber)) {
            $("#telError").text("Invalid phone number format! (01XXXX..)");
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
    }
}

/** =================== LOGIN VALIDATION FUNCTIONS =================== **/
function initForms() {
    let form = document.getElementById("login-form");
    if (form) {
        form.addEventListener("submit", validateLoginForm);
    }
}

function validateLoginForm(event) {
    let username = document.getElementById("UserID").value.trim();
    let password = document.getElementById("Userpwd").value.trim();
    let userError = document.getElementById("user-error");
    let passError = document.getElementById("pass-error");
    let isValid = true;

    userError.textContent = "";
    passError.textContent = "";

    if (username === "") {
        userError.textContent = "Please enter your username.";
        userError.style.display = "block";
        isValid = false;
    }

    if (password === "") {
        passError.textContent = "Password cannot be empty.";
        passError.style.display = "block";
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault();
    }
}

function handleLoginRedirect() {
    let loginMessage = $("#loginMessage").text().trim();
    let redirectUrl = $("#redirectUrl").text().trim();

    if (loginMessage !== "") {
        $("#loginMessage").text(loginMessage);
        setTimeout(function () {
            window.location.href = redirectUrl || "MainPage.php";
        }, 3000);
    }
}

/** =================== SEARCH FUNCTIONS =================== **/
function initializeSearch() {
    $("#searchButton").click(performSearch);
    $("#searchInput").keypress(function (event) {
        if (event.key === "Enter") {
            performSearch();
        }
    });
}

function performSearch() {
    const searchQuery = $("#searchInput").val().trim();
    if (searchQuery) {
        window.location.href = `MainPage.php?search=${encodeURIComponent(searchQuery)}`;
    }
}

/** =================== IMAGE SLIDER FUNCTIONS =================== **/
function initializeImageSlider() {
    const coverArr = [
        '../img/Intro3.png',
        '../img/Intro2.png',
        '../img/Intro1.png'
    ];

    let i = 0;
    let total = coverArr.length;
    let slideInterval;

    function updateContent() {
        $("#mainImg").fadeOut(500, function () {
            $(this).attr("src", coverArr[i]).fadeIn(1500);
        });
    }

    function nextSlide() {
        i = (i + 1) % total;
        updateContent();
    }

    function prevSlide() {
        i = (i - 1 + total) % total;
        updateContent();
    }

    function startAutoSlide() {
        stopAutoSlide();
        slideInterval = setInterval(nextSlide, 3500);
    }

    function stopAutoSlide() {
        clearInterval(slideInterval);
    }

    $("#next").click(function () {
        stopAutoSlide();
        nextSlide();
        startAutoSlide();
    });

    $("#back").click(function () {
        stopAutoSlide();
        prevSlide();
        startAutoSlide();
    });

    startAutoSlide();
}

/** =================== PROFILE MANAGEMENT FUNCTIONS =================== **/
    function initializeProfileManagement() {
        const toggleEditBtn = document.getElementById('toggleEdit');
        const cancelEditBtn = document.getElementById('cancelEdit');
        const formInputs = document.querySelectorAll('.profile-form input, .profile-form textarea');
        const formActions = document.querySelector('.form-actions');
        const navLinks = document.querySelectorAll('.profile-nav a');
        const sections = document.querySelectorAll('.profile-section');

    if (toggleEditBtn && cancelEditBtn) {
        toggleEditBtn.addEventListener('click', function () {
                formInputs.forEach(input => input.removeAttribute('readonly'));
                formActions.style.display = 'flex';
                toggleEditBtn.style.display = 'none';
            });

        cancelEditBtn.addEventListener('click', function () {
                formInputs.forEach(input => input.setAttribute('readonly', true));
                formActions.style.display = 'none';
                toggleEditBtn.style.display = 'block';
            });
        }

    if (navLinks.length > 0) {
            navLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                    if (this.getAttribute('href').startsWith('#')) {
                        e.preventDefault();
                        const sectionId = this.getAttribute('data-section');
                        
                        sections.forEach(section => {
                            section.style.display = 'none';
                            section.classList.remove('active');
                        });
                        
                        document.getElementById(sectionId).style.display = 'block';
                        document.getElementById(sectionId).classList.add('active');
                        
                        navLinks.forEach(navLink => navLink.classList.remove('active'));
                        this.classList.add('active');
                    }
                });
            });
        }

    // Profile picture upload handling
        const profilePicInput = document.getElementById('profile-pic-input');
        const uploadButton = document.getElementById('upload-pic-btn');
        
        if (profilePicInput) {
        profilePicInput.addEventListener('change', handleProfilePictureUpload);
    }
}

function handleProfilePictureUpload(e) {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    
                    if (file.size > 5000000) {
                        alert('File is too large. Maximum size is 5MB.');
            this.value = '';
                        return;
                    }

                    const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!validTypes.includes(file.type)) {
                        alert('Only JPG, PNG & GIF files are allowed.');
            this.value = '';
                        return;
                    }

                    const reader = new FileReader();
        reader.onload = function (e) {
                        document.getElementById('profile-pic').src = e.target.result;
                    }
                    reader.readAsDataURL(file);

        document.getElementById('upload-pic-btn').style.display = 'inline-block';
                }
        }

/** =================== ADMIN FUNCTIONS =================== **/
    function initializeAdminFeatures() {
        if (document.querySelector('.admin-form')) {
            initializeAdminForms();
            initializeProfilePicture();
        }
    }

    function initializeAdminForms() {
    $('.admin-form input').on('input', function () {
            $('.admin-message').fadeOut();
        });

    $('.admin-btn.secondary').on('click', function (e) {
            e.preventDefault();
            $(this).closest('form')[0].reset();
        });

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

/** =================== BOOK PREVIEW FUNCTIONS =================== **/
function initializeBookPreview() {
    if (document.querySelector('.book-container')) {
        initializeReviewStars();
    }
}

    function initializeReviewStars() {
        const starLabels = document.querySelectorAll('.stars-container label');
        
    if (!starLabels.length) return;
        
        starLabels.forEach(label => {
        label.addEventListener('mouseenter', handleStarHover);
        label.addEventListener('mouseleave', handleStarLeave);
        label.addEventListener('click', handleStarClick);
    });

    initializeExistingStars();
}

function handleStarHover() {
                this.querySelector('i').classList.remove('far');
                this.querySelector('i').classList.add('fas');
                
                let prevLabel = this;
                while (prevLabel = prevLabel.previousElementSibling) {
                    if (prevLabel.tagName === 'LABEL') {
                        prevLabel.querySelector('i').classList.remove('far');
                        prevLabel.querySelector('i').classList.add('fas');
                    }
                }
}
            
function handleStarLeave() {
                document.querySelectorAll('.stars-container label i').forEach(icon => {
                    const input = icon.parentElement.previousElementSibling;
                    if (input && !input.checked) {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                    }
                });
                
                const checkedInput = document.querySelector('.stars-container input:checked');
                if (checkedInput) {
                    let allInputs = document.querySelectorAll('.stars-container input');
                    allInputs.forEach(input => {
                        if (parseInt(input.value) <= parseInt(checkedInput.value)) {
                            let nextLabel = input.nextElementSibling;
                            if (nextLabel) {
                                nextLabel.querySelector('i').classList.remove('far');
                                nextLabel.querySelector('i').classList.add('fas');
                            }
                        }
                    });
                }
}
            
function handleStarClick() {
                const input = this.previousElementSibling;
                if (input && input.type === 'radio') {
                    input.checked = true;
                    
                    document.querySelectorAll('.stars-container label i').forEach(icon => {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                    });
                    
                    let value = parseInt(input.value);
                    let allLabels = document.querySelectorAll('.stars-container label');
                    for (let i = 0; i < value; i++) {
                        if (allLabels[i]) {
                            allLabels[i].querySelector('i').classList.remove('far');
                            allLabels[i].querySelector('i').classList.add('fas');
                        }
                    }
                }
}
        
function initializeExistingStars() {
        const checkedInput = document.querySelector('.stars-container input:checked');
        if (checkedInput) {
            const value = parseInt(checkedInput.value);
            const labels = document.querySelectorAll('.stars-container label');
            
            for (let i = 0; i < value; i++) {
                if (labels[i]) {
                    labels[i].querySelector('i').classList.remove('far');
                    labels[i].querySelector('i').classList.add('fas');
                }
            }
        }
    }

/** =================== LOGIN BUFFER FUNCTIONS =================== **/
function initializeLoginBuffer() {
    const countdownElement = document.getElementById('countdown');
    const redirectUrlElement = document.getElementById('redirectUrl');

    if (countdownElement && redirectUrlElement) {
        let count = 3;
        
        // Immediately update the initial count
        countdownElement.textContent = count;
        
        // Update countdown display
        const updateCountdown = () => {
            count--;
            countdownElement.textContent = count;
            
            if (count < 0) {
                // Redirect when countdown reaches 0
                const redirectUrl = redirectUrlElement.getAttribute('data-url');
                if (redirectUrl) {
                    window.location.href = redirectUrl;
                }
            } else {
                // Continue countdown
                setTimeout(updateCountdown, 1000);
            }
        };
        
        // Start countdown after a short delay
        setTimeout(updateCountdown, 1000);
    }
}

/** =================== PROFILE MENU FUNCTIONS =================== **/
function initializeProfileMenu() {
    // Profile dropdown toggle
    $("#profileIcon").click(function(e) {
        e.stopPropagation();
        $("#profileDropdown").toggleClass("show");
    });

    // Close dropdown when clicking elsewhere
    $(document).click(function(e) {
        if (!$(e.target).closest('.profile-dropdown').length) {
            $("#profileDropdown").removeClass("show");
        }
    });

    // Close dropdown when clicking on a menu item
    $(".profile-menu-items a").click(function() {
        $("#profileDropdown").removeClass("show");
    });
}

// Order History Functionality
function initializeOrderHistory() {
    // Handle confirm collection button clicks
    $('.collect-btn').on('click', function() {
        const orderId = $(this).data('order-id');
        if (confirm('Are you sure you want to confirm collection of this order?')) {
            $.ajax({
                url: 'php/confirm_collection.php',
                type: 'POST',
                data: { order_id: orderId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        showMessage('Order collection confirmed successfully!', 'success');
                        // Reload the page after a short delay
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        showMessage(response.message || 'Failed to confirm collection.', 'error');
                    }
                },
                error: function() {
                    showMessage('An error occurred. Please try again.', 'error');
                }
            });
        }
    });
}

// Show message function
function showMessage(message, type) {
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