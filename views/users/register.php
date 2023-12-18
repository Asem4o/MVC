<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="../../CSS/users/style.css">
    <script src="../../JS/users/register.js"></script>
</head>
<body>
<div class="register-container">
    <h1>Register</h1>
    <form method="post" action="registerProcess">
        <!-- Username field -->
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
        <span id="usernameResponse"></span><br />
        <br/>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <br/>

        <label for="confirmPassword">Confirm password:</label>
        <input type="password" name="confirmPassword" id="confirmPassword">
        <br/>

        <label for="pin">Pin:</label>
        <input type="password" name="pin" id="pin">
        <br/>

        <input type="hidden" name="csrfToken" value="<?= $model->getToken() ?>">
        <input type="hidden" name="guid" value="<?= $model->getGuid() ?>">

        <input type="submit" name="register" value="Register!">
    </form>

    <div id="registerResponse"></div>
</div>
</body>

</html>
