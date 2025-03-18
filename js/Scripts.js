$(document).ready(function () {
    /** =================== FORM VALIDATION =================== **/

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
        let phoneNumber = $("#tel").val().trim();
        let phonePattern = /^01\d{8,9}$/; // Malaysian phone number format
        let email = $("#emails").val().trim();
        let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/; // Standard email format
        let isValid = true;

        $(".error-message").text(""); // Clear all previous error messages

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
            console.log("Form validation failed");
        } else {
            console.log("Form validation passed");
        }
    });

    /** =================== LOGIN VALIDATION =================== **/

    // Initialize forms and handle login redirect
    initForms();
    handleLoginRedirect();

    /** =================== SEARCH FUNCTIONALITY =================== **/
    $("#searchButton").click(function () {
        performSearch();
    });

    $("#searchInput").keypress(function (event) {
        if (event.key === "Enter") {
            performSearch();
        }
    });

    /** =================== IMAGE SLIDER =================== **/
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

    /** =================== HELPER FUNCTIONS =================== **/

    // Form initialization function
    function initForms() {
        let form = document.getElementById("login-form");

        if (form) { // Ensure form exists before adding event listener
            form.addEventListener("submit", function (event) {
                let username = document.getElementById("UserID").value.trim();
                let password = document.getElementById("Userpwd").value.trim();
                let userError = document.getElementById("user-error");
                let passError = document.getElementById("pass-error");
                let isValid = true;

                // Reset previous error messages
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
                    event.preventDefault(); // Stop form submission if validation fails
                }
            });
        }
    }

    // Login redirect function
    function handleLoginRedirect() {
        let loginMessage = $("#loginMessage").text().trim();
        let redirectUrl = $("#redirectUrl").text().trim();

        if (loginMessage !== "") {
            console.log("Redirecting to:", redirectUrl);

            // Prevent multiple executions
            $("#loginMessage").text(loginMessage); // Keep the message visible

            setTimeout(function () {
                window.location.href = redirectUrl || "MainPage.php";
            }, 3000);
        }
    }

    /** =================== ERROR AND REDIRECT HANDLING =================== **/
    
    // Handle login redirect using data attributes (new method)
    const redirectElement = document.getElementById('redirectUrl');
    if (redirectElement && redirectElement.hasAttribute('data-url')) {
        const redirectUrl = redirectElement.getAttribute('data-url');
        console.log("Redirecting to:", redirectUrl);
        
        setTimeout(function() {
            window.location.href = redirectUrl;
        }, 2000);
    }
    
    // Handle floating error messages
    if ($("#floating-error").length > 0) {
        setTimeout(function() {
            $("#floating-error").fadeOut("slow", function() {
                $(this).remove();
            });
        }, 3000); // Hide after 3 seconds
    }
    // Search function
    function performSearch() {
        let query = $("#searchInput").val();
        if (query) {
            alert("Searching for: " + query);
        } else {
            alert("Please enter a search query.");
        }
    }

    // Profile Nav
    const profileIcon = document.getElementById('profileIcon');
    const profileDropdown = document.getElementById('profileDropdown');

    $("#profileIcon").click(function(e) {
        console.log("Profile icon clicked");  // Debugging

        $("#profileDropdown").toggleClass("show");
        e.stopPropagation();
    });
    
    // Close dropdown when clicking elsewhere
    $(document).click(function(e) {
        console.log("Profile icon vlose");  // Debugging
        if ($("#profileDropdown").hasClass("show") && 
            !$("#profileDropdown").is(e.target) && 
            $("#profileDropdown").has(e.target).length === 0 &&
            !$("#profileIcon").is(e.target)) {
            $("#profileDropdown").removeClass("show");
        }
    })

    // Profile Management Scripts
    function initializeProfileManagement() {
        const toggleEditBtn = document.getElementById('toggleEdit');
        const cancelEditBtn = document.getElementById('cancelEdit');
        const formInputs = document.querySelectorAll('.profile-form input, .profile-form textarea');
        const formActions = document.querySelector('.form-actions');
        const navLinks = document.querySelectorAll('.profile-nav a');
        const sections = document.querySelectorAll('.profile-section');

        if (toggleEditBtn && cancelEditBtn) { // Check if we're on the profile page
            // Toggle edit mode
            toggleEditBtn.addEventListener('click', function() {
                formInputs.forEach(input => input.removeAttribute('readonly'));
                formActions.style.display = 'flex';
                toggleEditBtn.style.display = 'none';
            });

            // Cancel edit mode
            cancelEditBtn.addEventListener('click', function() {
                formInputs.forEach(input => input.setAttribute('readonly', true));
                formActions.style.display = 'none';
                toggleEditBtn.style.display = 'block';
            });
        }

        // Profile Navigation
        if (navLinks.length > 0) { // Check if we're on the profile page
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
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
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // ... any existing initialization code ...
        
        // Initialize profile management if we're on the profile page
        initializeProfileManagement();

        // Phone number validation
        const phoneInput = document.getElementById('phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                const phoneNumber = e.target.value;
                const malaysianPhoneRegex = /^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/;
                
                if (!malaysianPhoneRegex.test(phoneNumber)) {
                    phoneInput.setCustomValidity('Please enter a valid Malaysian phone number');
                } else {
                    phoneInput.setCustomValidity('');
                }
            });
        }
    });

    // Profile picture upload handling
    $(document).ready(function() {
        const profilePicInput = document.getElementById('profile-pic-input');
        const uploadButton = document.getElementById('upload-pic-btn');
        
        if (profilePicInput) {
            profilePicInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    
                    // File size validation (5MB max)
                    if (file.size > 5000000) {
                        alert('File is too large. Maximum size is 5MB.');
                        this.value = ''; // Clear the input
                        return;
                    }

                    // File type validation
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!validTypes.includes(file.type)) {
                        alert('Only JPG, PNG & GIF files are allowed.');
                        this.value = ''; // Clear the input
                        return;
                    }

                    // Show preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('profile-pic').src = e.target.result;
                    }
                    reader.readAsDataURL(file);

                    // Show upload button
                    uploadButton.style.display = 'inline-block';
                }
            });
        }
    });

    /** =================== ADMIN FUNCTIONALITY =================== **/
    function initializeAdminFeatures() {
        if (document.querySelector('.admin-form')) {
            initializeAdminForms();
            initializeProfilePicture();
        }
    }

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
                    $('.admin-avatar, #profile-pic').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);

                // Show upload button
                $('#upload-pic-btn').show();
            }
        });
    }

    /** =================== BOOK PREVIEW FUNCTIONALITY =================== **/
    
    // Book Quantity Controls
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

    // Add to Cart Function
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
    
    // Review Star Rating Functionality
    function initializeReviewStars() {
        const starLabels = document.querySelectorAll('.stars-container label');
        
        if (!starLabels.length) return; // Exit if no stars on page
        
        starLabels.forEach(label => {
            label.addEventListener('mouseenter', function() {
                // Change to solid star icon on hover
                this.querySelector('i').classList.remove('far');
                this.querySelector('i').classList.add('fas');
                
                // Also for previous stars (for rating)
                let prevLabel = this;
                while (prevLabel = prevLabel.previousElementSibling) {
                    if (prevLabel.tagName === 'LABEL') {
                        prevLabel.querySelector('i').classList.remove('far');
                        prevLabel.querySelector('i').classList.add('fas');
                    }
                }
            });
            
            label.addEventListener('mouseleave', function() {
                // Reset all stars to outline unless checked
                document.querySelectorAll('.stars-container label i').forEach(icon => {
                    const input = icon.parentElement.previousElementSibling;
                    if (input && !input.checked) {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                    }
                });
                
                // Keep solid stars for checked rating
                const checkedInput = document.querySelector('.stars-container input:checked');
                if (checkedInput) {
                    // Set all stars up to the selected one to solid
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
            });
            
            // Handle click on stars
            label.addEventListener('click', function() {
                const input = this.previousElementSibling;
                if (input && input.type === 'radio') {
                    input.checked = true;
                    
                    // Reset all stars
                    document.querySelectorAll('.stars-container label i').forEach(icon => {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                    });
                    
                    // Fill in stars up to selected rating
                    let value = parseInt(input.value);
                    let allLabels = document.querySelectorAll('.stars-container label');
                    for (let i = 0; i < value; i++) {
                        if (allLabels[i]) {
                            allLabels[i].querySelector('i').classList.remove('far');
                            allLabels[i].querySelector('i').classList.add('fas');
                        }
                    }
                }
            });
        });
        
        // Initialize stars based on existing review
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

    // Initialize Book Preview features
    function initializeBookPreview() {
        if (document.querySelector('.book-container')) {
            // Initialize reviews functionality
            initializeReviewStars();
        }
    }

    // Add to the existing document ready function
    $(document).ready(function() {
        // ... existing ready function code ...
        
        // Initialize admin features if on admin page
        initializeAdminFeatures();
        
        // Initialize book preview features if on book preview page
        initializeBookPreview();
    });

    /** =================== BOOK REVIEWS FUNCTIONALITY =================== **/

    // Sort reviews
    window.sortReviews = function(sortBy) {
        const reviewsList = document.getElementById('reviewsList');
        if (!reviewsList) return;
        
        const reviews = Array.from(reviewsList.querySelectorAll('.review-item'));
        if (reviews.length <= 1) return;
        
        reviews.sort((a, b) => {
            if (sortBy === 'newest') {
                return parseInt(b.dataset.date) - parseInt(a.dataset.date);
            } else if (sortBy === 'oldest') {
                return parseInt(a.dataset.date) - parseInt(b.dataset.date);
            } else if (sortBy === 'highest') {
                return parseInt(b.dataset.rating) - parseInt(a.dataset.rating);
            } else if (sortBy === 'lowest') {
                return parseInt(a.dataset.rating) - parseInt(b.dataset.rating);
            }
            return 0;
        });
        
        // Remove all current reviews
        reviews.forEach(review => review.remove());
        
        // Add sorted reviews back
        reviews.forEach(review => reviewsList.appendChild(review));
    };

    // Initialize reviews functionality
    function initializeReviews() {
        // Set up "Load More" functionality
        const reviewItems = document.querySelectorAll('.review-item');
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        
        if (reviewItems.length > 3 && loadMoreBtn) {
            // Hide reviews beyond the first 3
            reviewItems.forEach((item, index) => {
                if (index >= 3) {
                    item.style.display = 'none';
                }
            });
            
            let visibleCount = 3;
            
            loadMoreBtn.addEventListener('click', function() {
                // Show next 3 reviews
                for (let i = visibleCount; i < visibleCount + 3 && i < reviewItems.length; i++) {
                    reviewItems[i].style.display = 'block';
                    // Add fade-in animation
                    reviewItems[i].style.animation = 'fadeIn 0.5s';
                }
                
                visibleCount += 3;
                
                // Hide button if all reviews are shown
                if (visibleCount >= reviewItems.length) {
                    loadMoreBtn.style.display = 'none';
                }
            });
        }
        
        // Initialize with newest first sorting
        sortReviews('newest');
    }

    // Add CSS animation for fade-in effect
    document.addEventListener('DOMContentLoaded', function() {
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
        document.head.appendChild(style);
    });
});