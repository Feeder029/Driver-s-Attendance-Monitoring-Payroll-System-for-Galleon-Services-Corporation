document.addEventListener('DOMContentLoaded', () => {
    // Variable Declaration
    const loginBtn = document.querySelector("#signin");
    const registerBtn = document.querySelector("#signup");
    const loginForm = document.querySelector(".login-form");
    const registerForm = document.querySelector(".register-form");
    const accountForm = document.querySelector(".account-form");
    const nextBtn = document.querySelector("#next");
 
   
    // Event Listener for Login Button
    loginBtn.addEventListener('click', () => {
        loginBtn.style.backgroundColor = "#ffc929";
        registerBtn.style.backgroundColor = "rgba(255, 255, 255, 0.3)";

        loginForm.style.left = "50%";
        registerForm.style.left = "-50%";

        loginForm.style.opacity = 1;
        registerForm.style.opacity = 0;

        document.querySelector(".col-1").style.borderRadius = "0 30% 20% 0";
    });

    // Event Listener for Register Button
    registerBtn.addEventListener('click', () => {
        loginBtn.style.backgroundColor = "rgba(255, 255, 255, 0.3)";
        registerBtn.style.backgroundColor = "#ffc929";

        loginForm.style.left = "150%";
        registerForm.style.left = "50%";

        loginForm.style.opacity = 0;
        registerForm.style.opacity = 1;

        document.querySelector(".col-1").style.borderRadius = "0 20% 30% 0";
    });

    // Event Listener for Next1 Button in Register Form
    nextBtn.addEventListener('click', () => {
        registerForm.style.display = "none"; // Hide the register form
        accountForm.style.display = "block"; // Show the address form
        
        // Hide and disable the sign-in and sign-up buttons
        loginBtn.style.display = "none"; // Hide the login button
        registerBtn.style.display = "none"; // Hide the register button
    });


});


document.getElementById('submit-button').addEventListener('click', function(event) {
    // Prevent default form submission
    event.preventDefault();

    // Select all required fields excluding those within the login form
    const requiredFields = document.querySelectorAll(
        '.register-form input[required], .register-form select[required], .account-form input[required], .account-form select[required]'
    );

    // Select the Terms and Conditions checkbox
    const termsCheckbox = document.getElementById('terms-conditions');

    // Select the password and confirm password fields
    const passwordField = document.getElementById('desired-password');
    const confirmPasswordField = document.getElementById('confirm-password');

    // Initialize a flag to track if all fields are filled
    let allFilled = true;

    // Check each required field
    requiredFields.forEach(field => {
        if (!field.value) {
            allFilled = false; // Set the flag to false if any field is empty
            field.classList.add('error'); // Optional: Add a class for styling
        } else {
            field.classList.remove('error'); // Remove error class if filled
        }
    });

    // Check if Terms and Conditions checkbox is checked
    if (!termsCheckbox.checked) {
        allFilled = false;
        alert("You must agree to the Terms and Conditions.");
    }

    // Check if Password and Confirm Password match
    if (passwordField.value !== confirmPasswordField.value) {
        allFilled = false;
        alert("Passwords do not match.");
        passwordField.classList.add('error');
        confirmPasswordField.classList.add('error');
    } else {
        passwordField.classList.remove('error');
        confirmPasswordField.classList.remove('error');
    }

    // Show warning if not all fields are filled or valid
    if (!allFilled) {
        alert("Please fill all required fields.");
    } else {
        // If all fields are filled, passwords match, and checkbox is checked, you can submit the form here
        console.log("Form submitted!"); // Placeholder for actual form submission logic

        document.getElementById("registerform").submit();

    }
});




document.getElementById('terms-link').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default link behavior
    document.getElementById('terms-info').style.display = 'block'; // Show the terms information box
});

document.getElementById('close-terms').addEventListener('click', function() {
    document.getElementById('terms-info').style.display = 'none'; // Hide the terms information box
});

function togglePassword(inputId, iconElement) {
    const passwordInput = document.getElementById(inputId);
    const icon = iconElement.querySelector("i");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}