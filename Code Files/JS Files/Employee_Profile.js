document.getElementById('edit').addEventListener('click', function() {
    const editableFields = document.querySelectorAll('.editable_status');

    editableFields.forEach(function(field) {
        field.disabled = false; // Make TextBox able to input
    });
});

document.getElementById("image").addEventListener("change", function() {
    this.form.submit();
});