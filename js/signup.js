


// Signup form submission and email validation
$(document).ready(function () {
    $('#signupForm').submit(function (event) {
        event.preventDefault(); // Prevent form submission

        // assign textbox value
        var firstName = $('#firstName').val();
        var lastName = $('#lastName').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var cnfpassword = $('#cnfpassword').val();
        var passowrdError = $('#passwordError');
        var cnfpasswordError = $('#cnfpasswordError');
        var emailError = $('#emailError');
        $('.error').remove();

        // Validate email usinf regex
        if (!validateEmail(email)) {
            $('<span class="error">Invalid email address</span>').insertAfter($('#email'));
            return;
        } else {
            emailError.textContent = "";
        }

        // validate password length
        if (password.length < 8) {
            $('<span class="error">Password must be at least 8 character.</span>').insertAfter($('#password'));
            return;
        } else {
            passowrdError.textContent = ''
        }

        // validate confirm password length and match both password
        if (cnfpassword.length < 8) {
            $('<span class="error">Confirm Password must be at least 8 character.</span>').insertAfter($('#cnfpassword'));
            return;
        } else if (cnfpassword != password) {
            $('<span class="error">password and confirm password must be the same.</span>').insertAfter($('#cnfpassword'));
            return;
        } else {
            cnfpasswordError.textContent = ''
        }

        // validate successful
        alert("Signup successful! Please login to continue.");
        clearForm();
        window.location.href = "../index.html"; // Redirect to login page after signup
    });

    // Email validation function using regex
    function validateEmail(email) {
        const emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return emailRegex.test(email);
    }


    // clear all textbox
    const clearForm = () => {
        // clear text boxes
        $("#firstName").value = "";
        $("#lastName").value = "";
        $("#email").value = "";
        $("#password").value = "";
        $("#cnfpassword").value = "";

        // clear span elements
        $("#passwordError").textContent = "";
        $("#cnfpasswordError").textContent = "";
        $("#emailError").textContent = "";

        // set focus on first text box after resetting the form
        $("#firstName").focus();
    };

});


//// you can open below code if you want to validate using java script-----------------------------------------------------------------------------------------

// // Email validation function
// function validateEmail(email) {
//     const emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
//     return emailRegex.test(email);
// }

// // Signup form submission and email validation
// document.getElementById("signupForm").addEventListener("submit", function (event) {
//     event.preventDefault(); // Prevent form submission
//     var firstName = document.getElementById("firstName").value;
//     var lastName = document.getElementById("lastName").value;
//     var email = document.getElementById("email").value;
//     var password = document.getElementById("password").value;
//     var cnfpassword = document.getElementById("cnfpassword").value;
//     var passowrdError = document.getElementById("passwordError");
//     var cnfpasswordError = document.getElementById("cnfpasswordError");

//     var emailError = document.getElementById("emailError");

//     // Validate email
//     if (!validateEmail(email)) {
//         emailError.textContent = "Invalid email address";
//         return;
//     } else {
//         emailError.textContent = "";

//     }
//     if (password.length < 8) {
//         passowrdError.textContent = 'Password must be at least 8 character.'
//         return;
//     } else {
//         passowrdError.textContent = ''

//     }

//     if (cnfpassword.length < 8) {
//         cnfpasswordError.textContent = 'Confirm Password must be at least 8 character.'
//         return;
//     } else if (cnfpassword != password) {
//         cnfpasswordError.textContent = 'password and confirm password must be the same.'

//         return;
//     } else {
//         cnfpasswordError.textContent = ''

//     }

//     // If email is valid, continue with form submission
//     // Your signup form submission logic goes here
//     alert("Signup successful! Please login to continue.");
//     window.location.href = "home.html"; // Redirect to login page after signup
// });
