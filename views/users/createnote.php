<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create note</title>

</head>


<?php if ($model->getError() !== null): ?>
<div class="error-box">
    <h1><?= $model->getError(); ?></h1>
    <body>
    <div class="login-container">

        <h1>add NOTE</h1>
        <form method="post" action="createNote">
            <textarea type="text" name= "note" ></textarea><br>
            <input type="submit" value="add Note">
        </form>
    </div>

    </body>

    <?php endif; ?>
