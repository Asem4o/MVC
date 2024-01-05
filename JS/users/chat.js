document.addEventListener("DOMContentLoaded", function () {
    function selectUser(element, username, guid, isRead) {
        document.querySelectorAll('.list-group-item').forEach(item => item.classList.remove('active', 'read', 'unread'));
        element.classList.add('active');
        document.getElementById('selected-username').value = username;
        document.getElementById('selected-guid').value = guid;
    }

    function sendMessage() {
        var selectedUsername = document.getElementById('selected-username').value;
        var selectedGuid = document.getElementById('selected-guid').value;
        var messageInput = document.getElementById('content').value;

        console.log("Sending message to " + selectedUsername + " with GUID " + selectedGuid + ": " + messageInput);

        // Create a form
        var form = document.createElement('form');
        form.method = 'post';
        form.action = 'send';

        // Create input fields for username, guid, and content
        var usernameInput = document.createElement('input');
        usernameInput.type = 'hidden';
        usernameInput.name = 'username';
        usernameInput.value = selectedUsername;

        var guidInput = document.createElement('input');
        guidInput.type = 'hidden';
        guidInput.name = 'guid';
        guidInput.value = selectedGuid;

        var contentInput = document.createElement('input');
        contentInput.type = 'hidden';
        contentInput.name = 'content';
        contentInput.value = messageInput;

        // Append input fields to the form
        form.appendChild(usernameInput);
        form.appendChild(guidInput);
        form.appendChild(contentInput);

        // Append the form to the document body and submit it
        document.body.appendChild(form);
        form.submit();
    }

    window.selectUser = selectUser;
    window.sendMessage = sendMessage;

    // Event listener for form submission
    document.getElementById('messageForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission
        sendMessage();
    });
});
