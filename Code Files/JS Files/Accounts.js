function DisableEnableInput(){
    var inputs = document.querySelectorAll('#Active,#Inactive,#Pending,#role,#hub, #unit-type, #view-role-role');
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

document.querySelectorAll('#view-btn').forEach(button => {
    button.addEventListener('click', function () {
        const aiId = this.getAttribute('data-id');
        window.location.href = `view.php?AI_ID=${aiId}`;
    });
});
