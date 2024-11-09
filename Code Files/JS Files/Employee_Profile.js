function editProfile(){
    const editableFields = document.querySelectorAll('.editable_status_P-A');
    editableFields.forEach(function(field) {
        field.disabled = false; // Make TextBox able to input
    });
    document.getElementById("save").style.display = "block";
    document.getElementById("back").style.display = "block";
    document.getElementById("edit").style.display = "none";
};

function BackProfile(){
    const editableFields = document.querySelectorAll('.editable_status_P-A');
    editableFields.forEach(function(field) {
        field.disabled = true; // Make TextBox able to input
    });
    document.getElementById("save").style.display = "none";
    document.getElementById("back").style.display = "none";
    document.getElementById("edit").style.display = "block";
};

function editContacts() {
    const editableFields = document.querySelectorAll('.editable_status_Contacts');
    editableFields.forEach(function(field) {
        field.disabled = false; // Make TextBox able to input
    });

    document.getElementById("save").style.display = "block";
    document.getElementById("back").style.display = "block";
    document.getElementById("edit").style.display = "none";
};

function BackContacts() {
    const editableFields = document.querySelectorAll('.editable_status_Contacts');
    editableFields.forEach(function(field) {
        field.disabled = true; // Make TextBox able to input
    });
    
    document.getElementById("save").style.display = "none";
    document.getElementById("back").style.display = "none";
    document.getElementById("edit").style.display = "block";
};

// function editVehicles() {
//     alert("EWRfd");
//     const editableFields = document.querySelectorAll('.editable_status_Vehicle');
//     const ChooseImage = document.querySelectorAll('.editimage');

//     editableFields.forEach(function(field) {
//         field.disabled = false; // Make TextBox able to input
//     });

//     ChooseImage.forEach(function(Text) {
//         Text.style.display = 'block';
//     });

// };

document.getElementById('edit_GOV').addEventListener('click', function() {
    alert("edit_GOV");
    const editableFields = document.querySelectorAll('.editable_status_GOV');
    const ChooseImage = document.querySelectorAll('.editimage_clearance');

    editableFields.forEach(function(field) {
        field.disabled = false; // Make TextBox able to input
    });

    ChooseImage.forEach(function(Text) {
        Text.style.display = 'block';
    });

});


document.getElementById('add_vehicle').addEventListener('click', function() {
    const newVehicleForm = document.getElementById('newVehicleForm');
    newVehicleForm.style.display = newVehicleForm.style.display === 'none' ? 'block' : 'none';
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

