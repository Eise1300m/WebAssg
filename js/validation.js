
<<<<<<< HEAD
$(document).ready(function(){
    $("#add").on("input", function(){  
        let address = $(this).val().trim();
        let addressPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z0-9\s,.-]{5,}$/; 

        if (!addressPattern.test(address)) {
            $("#addError").text("Enter a valid address (must include letters and numbers).");
        } else {
            $("#addError").text(""); 
        }
    });

    $("#pswcfm").on("input", function(){  
        let password = $("#psw").val();
        let confirmPassword = $(this).val();

        if (password !== confirmPassword) {
            $("#pswcfmError").text("Passwords do not match!");
        } else {
            $("#pswcfmError").text("");
        }
    });

    $("#signupForm").submit(function(event){
        let password = $("#psw").val();
        let confirmPassword = $("#pswcfm").val();
        let address = $("#add").val().trim();
        let addressPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z0-9\s,.-]{5,}$/; 
=======
$(document).ready(function () {


    $("#signupForm").submit(function (event) {


        let phoneNumber = $("#tel").val().trim();
        let phonePattern = /^01\d{8,9}$/; // Malaysian phone number format
        let email = $("#emails").val().trim();
        
        let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/; // Standard email format
>>>>>>> 6a36f37 (3/5 2.27)
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

<<<<<<< HEAD
        if ($("#emails").val() === "") {
            $("#emailError").text("Email is required!");
            isValid = false;
        }

        if ($("#tel").val() === "") {
            $("#telError").text("Phone number is required!");
            isValid = false;
        }

        // Address validation
        if (!addressPattern.test(address)) {
            $("#addError").text("Enter a valid address (must include letters and numbers).");
            isValid = false;
        }

        // Password match validation
        if (password !== confirmPassword) {
=======
        if ($("#psw").val() !== $("#pswcfm").val()) {
>>>>>>> 6a36f37 (3/5 2.27)
            $("#pswcfmError").text("Passwords do not match!");
            isValid = false;
        }

<<<<<<< HEAD
        if (!isValid) {
            event.preventDefault(); 
=======
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
>>>>>>> 6a36f37 (3/5 2.27)
            console.log("Form validation failed");
        } else {
            console.log("Form validation passed");
        }
    });
})

