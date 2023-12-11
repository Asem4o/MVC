<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset your profile</title>
    <link rel="stylesheet" href="../../CSS/users/style.css">
</head>


<?php if ($model->getError() !== null): ?>
<div class="error-box">
    <h1><?= $model->getError(); ?></h1>
    <body>
    <div class="login-container">

        <header>
            <h1>Reset</h1>
        </header>

        <form method="post" action="resetPin">


            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br/>

            <label for="pin">PIN:</label>
            <input type="text" name="pin" id="pin" required><br/>

            <label for="password">New Password:</label>
            <input type="password" name="password" id="password" required><br/>

            <input type="submit" name="login" value="Reset!"/>
        </form>
    </div>

    </body>

    <?php endif; ?>
