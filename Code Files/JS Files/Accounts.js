function DisableEnableInput(){
    var inputs = document.querySelectorAll('#firstname, #middlename, #lastname, #suffix, #contact, #email, #user, #pass, #view-role-role');
    var isDisabled = inputs[0].disabled;

    inputs.forEach(function(input) {
        input.disabled = !isDisabled;
    });

    var editButton = document.querySelector('button[onclick="DisableEnableInput()"]');
    if (isDisabled) {
        editButton.textContent = 'SAVE';
    } else {
        editButton.textContent = 'EDIT';
    }
}