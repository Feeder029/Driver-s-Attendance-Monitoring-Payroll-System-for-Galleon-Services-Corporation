let isEditMode = false;

function toggleEditMode() {
    isEditMode = !isEditMode;

    // Toggle the visibility of file inputs based on edit mode
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.style.display = isEditMode ? 'block' : 'none';
    });

    // Toggle the save button visibility and change edit button text
    document.getElementById("save-btn").style.display = isEditMode ? 'inline-block' : 'none';
    document.querySelector('.button-container button:first-child').textContent = isEditMode ? 'Cancel' : 'Edit';
}

function saveVehicleInfo() {
    // Here you would typically handle the saving logic (e.g., send data to the server)
    alert("Vehicle information saved!");
    toggleEditMode(); // Exit edit mode after saving
}

function addNewVehicle() {
    // Logic for adding a new vehicle goes here
    alert("New vehicle added!");
}
