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


document.querySelectorAll('#view-btn').forEach(button => {
    button.addEventListener('click', function() {
        var accId = this.getAttribute('data-id');
        
        // Send an AJAX request to fetch data based on the acc_id
        fetch(`get_account_info.php?id=${accId}`)
            .then(response => response.json())
            .then(data => {
                // Populate the fields in the 'View More' container
                document.getElementById('firstname').value = data.first_name;
                document.getElementById('middlename').value = data.middle_name;
                document.getElementById('lastname').value = data.last_name;
                document.getElementById('suffix').value = data.suffix;
                document.getElementById('contact').value = data.contact;
                document.getElementById('email').value = data.email;
                document.getElementById('user').value = data.username;
                document.getElementById('pass').value = data.password;
                document.getElementById('date-created').textContent = data.date_created;
                document.getElementById('view-more-container').style.display = 'block';  // Show the "View More" container
            })
            .catch(error => console.error('Error fetching data:', error));
    });
});
