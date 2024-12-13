// Email validation function using regex
function validateEmail(email) {
    const emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return emailRegex.test(email);
}
const clearForm = () => {
    // clear text boxes
    document.getElementById("email").value = "";
    document.getElementById("password").value = "";

    // clear span elements
    document.getElementById("emailError").textContent = "";
    document.getElementById("passwordError").textContent = "";

    // set focus on first text box after resetting the form
    document.getElementById("email").focus();
};

// Signup form submission and email validation
document.getElementById("loginForm").addEventListener("submit", function (event) {
    alert('button clicked')
    event.preventDefault(); // Prevent form submission

    // assign textbox values
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    // assign error span
    var emailError = document.getElementById("emailError");
    var passowrdError = document.getElementById("passwordError");

    // Validate email
    if (!validateEmail(email)) {
        emailError.textContent = "Invalid email address";
        return;
    } else {
        emailError.textContent = "";
    }

    // validate password length
    if (password.length < 8) {
        passowrdError.textContent = 'Password must be at least 8 character.'
        return;
    } else {
        passowrdError.textContent = ''

    }

    // validate email and password which user entered are correct or not
    // if both are correct then redirect home page
    // if (email === "bhoomi@gmail.com" && password === "test@12345") {
        alert("login successful! Please login to continue.");
        clearForm();
        window.location.href = "home.php";
    // } else {
    //     alert("Invalid username or password");
    //     clearForm();

    // }

});
