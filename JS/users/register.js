document.addEventListener("DOMContentLoaded", function() {
    var usernameInput = document.getElementById("username");
    var usernameResponseSpan = document.getElementById("usernameResponse");

    if (usernameInput && usernameResponseSpan) {
        usernameInput.addEventListener("keyup", function (event) {
            if (event.target.value.length < 5) {
                usernameResponseSpan.textContent = "Too short username";
                usernameResponseSpan.style.color = "red";
            } else {
                usernameResponseSpan.textContent = "Username is OK";
                usernameResponseSpan.style.color = "green";
            }
        });
    } else {
        console.error("Could not find username input or response span in the DOM.");
    }
});
