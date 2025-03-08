$(document).ready(function () {

    $("input").on("input", function () {
        $(this).next(".error-message").text(""); // Clears only the associated error message
    });

    $("#psw,#pswcfm").on("input", function () {
        let password = $("#psw").val();
        let comfirmPassword = $("#pswcfm").val();

        if (comfirmPassword !== "" && password !== comfirmPassword) {
            $("#pswcfmError").text("Passwords do not match !");
        } else {
            $("#pswcfmError").text("");
        }

    });




    $("#signupForm").submit(function (event) {


        let phoneNumber = $("#tel").val().trim();
        let phonePattern = /^01\d{8,9}$/; // Malaysian phone number format
        let email = $("#emails").val().trim();

        let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/; // Standard email format
        let isValid = true;

        // Clear all previous error messages
        $(".error-message").text("");

        // Basic field validation
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
            $("#pswcfmError").text("Comfimation password is required!");
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



});

