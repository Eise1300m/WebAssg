// document.addEventListener("DOMContentLoaded", function () {
//     let form = document.getElementById("login-form");

//     if (form) { // Ensure form exists before adding event listener
//         form.addEventListener("submit", function (event) {
//             let username = document.getElementById("CustID").value.trim();
//             let password = document.getElementById("Custpwd").value.trim();
//             let userError = document.getElementById("user-error");
//             let passError = document.getElementById("pass-error");
//             let isValid = true;

//             // Reset previous error messages
//             userError.textContent = "";
//             passError.textContent = "";

//             if (username === "") {
//                 userError.textContent = "Please enter your username.";
//                 userError.style.display = "block";
//                 isValid = false;
//             }

//             if (password === "") {
//                 passError.textContent = "Password cannot be empty.";
//                 passError.style.display = "block";
//                 isValid = false;
//             }

//             if (!isValid) {
//                 event.preventDefault(); // Stop form submission if validation fails
//             }
//         });
//     } else {
//         console.error("Form with ID 'login-form' not found! Make sure the script is loaded correctly.");
//     }
// });
