document.addEventListener('DOMContentLoaded', () => {
    // Variable Declaration
    const loginBtn = document.querySelector("#signin");
    const registerBtn = document.querySelector("#signup");
    const nextBtn = document.querySelector("#next1");
    const nextBtn1 = document.querySelector("#next2")
    const nextBtn2 = document.querySelector("#next3")
    const nextBtn3 = document.querySelector("#next4")
    const nextBtn4 = document.querySelector("#next5")
    const backBtn = document.querySelector("#back1");
    const backBtn1 = document.querySelector("#back2")
    const backBtn2 = document.querySelector("#back3")
    const backBtn3 = document.querySelector("#back4")
    const loginForm = document.querySelector(".login-form");
    const registerForm = document.querySelector(".register-form");
    const addressForm = document.querySelector(".address-form");
    const vehicleForm = document.querySelector(".vehicle-form")
    const clearanceForm = document.querySelector(".clearance-form")
    const benefitForm = document.querySelector(".benefits-form")
    const passwordForm = document.querySelector(".password-form")
   
    

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
        addressForm.style.display = "block"; // Show the address form
        
        // Hide and disable the sign-in and sign-up buttons
        loginBtn.style.display = "none"; // Hide the login button
        registerBtn.style.display = "none"; // Hide the register button
    });

    // Event Listener for Next2 Button in Contact Form
    nextBtn1.addEventListener('click', () => {
        addressForm.style.display = "none"; // Hide the address form
        vehicleForm.style.display = "block"; // Show the vehicle form
    });

    // Event Listener for Next3 Button in Contact Form
    nextBtn2.addEventListener('click', () => {
        vehicleForm.style.display = "none"; // Hide the vehicle form
        clearanceForm.style.display = "block"; // Show the clearance form
    });

    // Event Listener for Next4 Button in Contact Form
    nextBtn3.addEventListener('click', () => {
        clearanceForm.style.display = "none"; // Hide the clearance form
        benefitForm.style.display = "block"; // Show the benefit form
    });
    // Event Listener for Next5 Button in Contact Form
    nextBtn4.addEventListener('click', () => {
        benefitForm.style.display = "none"; // Hide the benefit form
        passwordForm.style.display = "block"; // Show the password form
    });

    // Event Listener for Back1 Button
    backBtn.addEventListener('click', () => {
        registerForm.style.display = "block"; // Show the register form
        addressForm.style.display = "none"; // Hide the address form
    });

    // Event Listener for Back2 Button in Contact Form
    backBtn1.addEventListener('click', () => {
        addressForm.style.display = "block"; // Show the address form
        vehicleForm.style.display = "none"; // Hide the vehicle form
    });

    // Event Listener for Back3 Button in Contact Form
    backBtn2.addEventListener('click', () => {
        vehicleForm.style.display = "block"; // Show the vehicle form
        clearanceForm.style.display = "none"; // Hide the clearance form
    });

    
    // Event Listener for Back4 Button in Contact Form
    backBtn3.addEventListener('click', () => {
        clearanceForm.style.display = "block"; // Show the clearance form
        benefitForm.style.display = "none"; // Hide the benefit form
    });

    

});



document.getElementById('submit-button').addEventListener('click', function(event) {
    // Prevent default form submission
    event.preventDefault();

    // Select all required fields from the registration form
    const requiredFields = document.querySelectorAll(
        '.register-form input[required], .register-form select[required], .address-form input[required], .address-form select[required], .vehicle-form input[required], .vehicle-form select[required], .benefits-form input[required], .password-form input[required]'
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
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        passwordInput.type = "password";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
}


const locationData = {
      ProvinceA: {
        CityA1: ["Barangay A1-1", "Barangay A1-2"],
        CityA2: ["Barangay A2-1", "Barangay A2-2"]
      },
      ProvinceB: {
        CityB1: ["Barangay B1-1", "Barangay B1-2"],
        CityB2: ["Barangay B2-1", "Barangay B2-2"]
      },
      ProvinceC: {
        CityC1: ["Barangay C1-1", "Barangay C1-2"],
        CityC2: ["Barangay C2-1", "Barangay C2-2"]
      }
    };

    // Elements
    const provinceSelect = document.getElementById("province");
    const citySelect = document.getElementById("city");
    const barangaySelect = document.getElementById("barangay");

    // Event listener for Province dropdown
    provinceSelect.addEventListener("change", function () {
      const selectedProvince = provinceSelect.value;
      citySelect.innerHTML = "<option value=''>Select City/Municipality</option>"; // Reset city options
      barangaySelect.innerHTML = "<option value=''>Select Barangay</option>"; // Reset barangay options

      if (selectedProvince && locationData[selectedProvince]) {
        // Populate cities based on selected province
        Object.keys(locationData[selectedProvince]).forEach(city => {
          const option = document.createElement("option");
          option.value = city;
          option.textContent = city;
          citySelect.appendChild(option);
        });
      }
    });

    // Event listener for City dropdown
    citySelect.addEventListener("change", function () {
      const selectedProvince = provinceSelect.value;
      const selectedCity = citySelect.value;
      barangaySelect.innerHTML = "<option value=''>Select Barangay</option>"; // Reset barangay options

      if (selectedCity && locationData[selectedProvince][selectedCity]) {
        // Populate barangays based on selected city
        locationData[selectedProvince][selectedCity].forEach(barangay => {
          const option = document.createElement("option");
          option.value = barangay;
          option.textContent = barangay;
          barangaySelect.appendChild(option);
        });
      }
    });