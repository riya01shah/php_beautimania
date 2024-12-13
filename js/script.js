function validateForm(event) {
    event.preventDefault();
  const firstName = document.getElementById("firstName").value;
  let lastName = document.getElementById("lastName").value;
  let email = document.getElementById("email").value;
  let phone = document.getElementById("phone").value;
  const contactForm = document.getElementById("contactForm");
  const resultContainer = document.getElementById("result");
  const submissionElement = document.getElementById("submission");

  let firstNameError = document.getElementById("firstNameError");
  let lastNameError = document.getElementById("lastNameError");
  let emailError = document.getElementById("emailError");
  let phoneError = document.getElementById("phoneError");

  let isValid = true;

  // First Name validation
  if (firstName === "") {
    firstNameError.textContent = "Please enter your first name";
    isValid = false;
  } else {
    firstNameError.textContent = "";
  }

  // Last Name validation
  if (lastName === "") {
    lastNameError.textContent = "Please enter your last name";
    isValid = false;
  } else {
    lastNameError.textContent = "";
  }

  // Email validation
  let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) {
    emailError.textContent = "Please enter a valid email address";
    isValid = false;
  } else {
    emailError.textContent = "";
  }

  // Phone validation
  let phonePattern = /^\d{10}$/;
  if (!phonePattern.test(phone)) {
    phoneError.textContent = "Please enter a valid 10-digit phone number";
    isValid = false;
  } else {
    phoneError.textContent = "";
  }

  // If form is valid, redirect to next page
  if (isValid) {
// Hide form and display "Thank you" message
contactForm.style.display = "none";
resultContainer.style.display = "block";
submissionElement.textContent = `Thank you for your submission!`; // Change the message as desired
}

  return isValid;
}
