<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../../CSS/users/style.css">

</head>

<body>

<div class="login-container">
    <h1>Login</h1>

    <form method="post" action="loginProcess">
        <div id="response"></div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
            <span id="usernameHelp"></span><br />

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br />
             <input type="hidden" name="csrfToken" value="<?= $model->getToken() ?>">
            <input type="submit" name="login" value="Login!">
    </form>

    <a href="register">If you don't have an account, Register</a><br><br>
    <a href="reset">Reset password</a>.
</div>
</body>

</html>
