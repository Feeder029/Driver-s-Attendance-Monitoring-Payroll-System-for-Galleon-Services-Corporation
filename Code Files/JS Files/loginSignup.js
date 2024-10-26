document.getElementById("loginform").addEventListener("submit", function(event) {
    event.preventDefault();

    const validUsername = "user";
    const validPassword = "pass";

    const username = document.getElementById("usernameTB").value;
    const password = document.getElementById("passwordTB").value;

    if (username === validUsername && password === validPassword){
        window.alert("LOGIN SUCCESSFUL!")
    } else {
        window.alert("INVALID USERNAME OR PASSWORD!")
    }
});