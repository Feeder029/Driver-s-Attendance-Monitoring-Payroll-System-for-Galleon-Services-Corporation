let isEditing = false; // Boolean to toggle edit state

// Function to toggle edit mode for Government Information section
function editGovernmentInfo() {
    const editableFields = document.querySelectorAll('.editable_status_GOV');
    const ChooseImage = document.querySelectorAll('.editimage_clearance');

    editableFields.forEach(function(field) {
        field.disabled = false; // Make TextBox able to input
    });

    ChooseImage.forEach(function(Text) {
        Text.style.display = 'block';
    });

    document.getElementById("save").style.display = "block";
    document.getElementById("back").style.display = "block";
    document.getElementById("edit").style.display = "none";
}

// Call to hide input fields initially when the page loads
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('#clearance-info input[type="file"]').forEach(input => {
        input.style.display = 'none';  // Initially hide the file inputs
    });
});
