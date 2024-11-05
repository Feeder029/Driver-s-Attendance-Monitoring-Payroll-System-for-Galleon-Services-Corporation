document.getElementById('edit_GOV').addEventListener('click', function() {
    const editableFields = document.querySelectorAll('.editable_status_GOV');
    const ChooseImage = document.querySelectorAll('.editimage_clearance');

    editableFields.forEach(function(field) {
        field.disabled = false; // Make TextBox able to input
    });

    ChooseImage.forEach(function(Text) {
        Text.style.display = 'block';
    });

});