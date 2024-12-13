$(document).ready(function () {

    // Open logout dialog when logout link is clicked
    $('#logout').click(function (event) {
        event.preventDefault();
        $('#logoutDialog').show();
    });

    // Close logout dialog when close button or outside modal is clicked
    $('.close, .modal').click(function (event) {
        if (event.target == this) {
            $('#logoutDialog').hide();
        }
    });

    // Logout action when confirm logout button is clicked
    $('#confirmLogout').click(function () {
        // Perform logout actions here, such as clearing session or cookies
        // After logout, redirect the user to the login page
        window.location.href = "../index.html";
    });

    $('#contactForm').submit(function (event) {
        event.preventDefault(); // Prevent form submission

        // String : assign textfield value 
        var name = $('#name').val();
        var email = $('#email').val();
        var message = $('#message').val();

        // String : assign error text value 
        var contactError = $('#contactError');
        var emailError = $('#emailError');
        $('.error').remove();

        // Validate email using regex
        if (!validateEmail(email)) {
            $('<span class="error">Invalid email address</span>').insertAfter($('#email'));
            return;
        } else {
            emailError.textContent = "";
        }

        //validate message length
        if (message.length < 70) {
            $('<span class="error">Message must be at least 70 character.</span>').insertAfter($('#message'));
            return;
        } else {
            contactError.textContent = ''
        }


        // success scenario
        alert("Contact us submited successful! Please click to continue.");

        // clear inserted values in form
        clearForm();

        // redirect -> home.html
        window.location.href = "home.html"; // Redirect to login page after signup
    });

    // email validate regex return true -> if valid email format match
    function validateEmail(email) {
        const emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return emailRegex.test(email);
    }

    // clear all inserted data
    const clearForm = () => {
        // clear text boxes
        $("#name").value = "";
        $("#email").value = "";
        $("#message").value = "";

        // clear span elements
        $("#emailError").textContent = "";
        $("#contactError").textContent = "";
    };

});
