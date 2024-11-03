//edit mode for Government Information section
let isEditing = false;

function editGovernmentInfo() {
    isEditing = !isEditing;  // Toggle editing mode

    // Select all file input fields in the clearance section
    const fileInputs = document.querySelectorAll('#clearance-info input[type="file"]');

    fileInputs.forEach(input => {
        input.style.display = isEditing ? 'block' : 'none';  // Show if editing, hide otherwise
    });

    // Set text fields to editable/non-editable
    document.querySelectorAll('#government-info input[type="text"]').forEach(input => {
        input.readOnly = !isEditing;
    });
}

// Call to hide input fields initially
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('#clearance-info input[type="file"]').forEach(input => input.style.display = 'none');
});
