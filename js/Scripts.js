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
        const profilePicForm = document.getElementById('profile-pic-form');
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
});