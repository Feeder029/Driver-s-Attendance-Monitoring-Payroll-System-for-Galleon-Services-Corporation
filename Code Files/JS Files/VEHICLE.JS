let isEditMode = false;

function toggleEditMode() {
    isEditMode = !isEditMode;

    // Toggle the visibility of file inputs and text inputs in the vehicle section based on edit mode
    document.querySelectorAll('#vehicle input, #vehicle select, #vehicle textarea').forEach(input => {
        if (input.type === 'file') {
            input.style.display = isEditMode ? 'block' : 'none'; // Toggle file inputs
        } else {
            input.disabled = !isEditMode; // Enable or disable other inputs
        }
    });

    // Toggle the save button visibility and change edit button text in the vehicle section
    document.getElementById("save-btn").style.display = isEditMode ? 'inline-block' : 'none';
    document.querySelector('#vehicle .button-container button:first-child').textContent = isEditMode ? 'Cancel' : 'Edit';
}



function editVehicles() {
    alert("EWRfd");
    const editableFields = document.querySelectorAll('.editable_status_Vehicle');
    const ChooseImage = document.querySelectorAll('.editimage');

    editableFields.forEach(function(field) {
        field.disabled = false; // Make TextBox able to input
    });

    ChooseImage.forEach(function(Text) {
        Text.style.display = 'block';
    });

};


function saveVehicleInfo() {
    // Select only new vehicle-info sections for validation
    const newSections = document.querySelectorAll("#vehicle-info-container .vehicle-info[data-new='true']");
    let allFieldsFilled = true;

    newSections.forEach(section => {
        const requiredFields = section.querySelectorAll("input[required], input[type='file']");
        
        requiredFields.forEach(field => {
            if (!field.value) {
                allFieldsFilled = false;
                field.classList.add("error"); // Add error styling
            } else {
                field.classList.remove("error");
            }
        });
    });

    if (!allFieldsFilled) {
        alert("Please fill in all required fields before saving.");
        return;
    }

    // Save logic (e.g., send data to the server)
    alert("Vehicle information saved!");

    // Mark the new sections as saved by removing the data-new attribute
    newSections.forEach(section => section.removeAttribute("data-new"));
    toggleEditMode(); // Exit edit mode after saving
}



function addNewVehicle() {
    if (isEditMode) {
        alert("Please save the current vehicle information before adding a new one.");
        return;
    }

    const vehicleInfoSection = document.querySelector("#vehicle-info");
    const newVehicleInfoSection = vehicleInfoSection.cloneNode(true);

    newVehicleInfoSection.querySelectorAll("input[type='text'], input[type='file']").forEach((input, index) => {
        if (input.type === 'text') {
            input.value = "";
            input.name = `newPlate[]`; // For new Plate input
        } else if (input.type === 'file') {
            input.value = null;
            input.name = index % 2 === 0 ? `newOR[]` : `newCR[]`; // For new OR and CR inputs
            input.style.display = 'block';
            const img = input.previousElementSibling;
            if (img) img.src = "";
        }
    });

    newVehicleInfoSection.setAttribute("data-new", "true");
    document.getElementById("vehicle-info-container").appendChild(newVehicleInfoSection);
    toggleEditMode();
}

function deleteVehicleInfo(icon) {
    // Find the closest vehicle-info section
    const section = icon.closest('.vehicle-info');
    if (section) {
        // Show confirmation dialog
        const confirmed = confirm("Are you sure you want to delete this vehicle information?");
        if (confirmed) {
            // Retrieve the vehicleID from the hidden input field
            const vehicleID = section.querySelector('input[name="VehicleID[]"]').value;

            // AJAX request to delete vehicle
            fetch('../PHP FILES/employee_vehicles.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `deleteVehicleID=${vehicleID}` // Data sent to PHP
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Show success/failure message from PHP
                // Remove the vehicle-info section if deletion was successful
                section.remove();
            })
            .catch(error => console.error('Error:', error));
        }
    }
}

