document.addEventListener("DOMContentLoaded", function() {
    var usernameInput = document.getElementById("username");
    var responseSpan = document.getElementById("usernameHelp");

    if (usernameInput && responseSpan) {
        usernameInput.addEventListener("keyup", function (event) {
            if (event.target.value.length < 5) {
                responseSpan.textContent = "Too short username";
                responseSpan.style.color = "red"; // Set color to red
            } else {
                responseSpan.textContent = "username is OK";
                responseSpan.style.color = "green"; // Set color to green or any other color you prefer
            }
        });
    } else {
        console.error("Could not find username input or response span in the DOM.");
    }
});
