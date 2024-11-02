document.getElementById('edit').addEventListener('click', function() {
    const editableFields = document.querySelectorAll('.editable_status_P-A');

    editableFields.forEach(function(field) {
        field.disabled = false; // Make TextBox able to input
    });
});

document.getElementById('Edit_Vehicle').addEventListener('click', function() {
    const editableFields = document.querySelectorAll('.editable_status_Vehicle');
    const ChooseImage = document.querySelectorAll('.editimage');

    editableFields.forEach(function(field) {
        field.disabled = false; // Make TextBox able to input
    });

    ChooseImage.forEach(function(Text) {
        Text.style.display = 'block'; // or 'inline', 'flex', etc., depending on your layout needs
    });

});


document.getElementById("image").addEventListener("change", function() {
    this.form.submit();
});

document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('#Option button');
    const sections = document.querySelectorAll('.content-section');

    // Show the Personal & Account section by default
    const defaultSection = document.getElementById('Personal&Account_Section');
    defaultSection.classList.add('active');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const targetSectionId = button.id.replace('_Btn', '_Section');
            const targetSection = document.getElementById(targetSectionId);

            // Hide all sections
            sections.forEach(section => {
                section.classList.remove('active');
            });

            // Show the target section
            targetSection.classList.add('active');
        });
    });
});
