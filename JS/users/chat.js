document.addEventListener("DOMContentLoaded", function () {

    function selectUser(element, username, guid) {
        document.getElementById('username').value = username;
        document.getElementById('guid').value = guid;

    }
    window.selectUser = selectUser;
});
