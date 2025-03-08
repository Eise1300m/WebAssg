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

        if ($("#CustName").val() === "") {
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
    let loginForm = document.getElementById("login-form");

    if (loginForm) {
        loginForm.addEventListener("submit", function (event) {
            let username = document.getElementById("CustID").value.trim();
            let password = document.getElementById("Custpwd").value.trim();
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
        });
    }

    /** =================== SEARCH FUNCTIONALITY =================== **/
    function performSearch() {
        let query = $("#searchInput").val();
        if (query) {
            alert("Searching for: " + query);
        } else {
            alert("Please enter a search query.");
        }
    }

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


    /*** REDIRECT AFTER LOGIN ***/
    let loginMessage = $("#loginMessage").text().trim();
    if (loginMessage) {
        setTimeout(function () {
            window.location.href = sessionStorage.getItem("redirect_url") || "CustomerLogin.php";
        }, 3000);
    }
    
});
