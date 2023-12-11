<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit your profile</title>
</head>

<body>
<h1>Reset</h1>

<?php if (isset($errors) && is_array($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <div id="error" style="color:red">
            <h1><?= $error; ?></h1>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<form method="post" action="resetPin">
    UserName <input type="text" name="username"><br/>
    PIN <input type="text" name="pin"><br/>
    New Password: <input type="password" name="password"><br/>
    <input type="submit" name="login" value="Reset!"/>
</form><br>
</body>
</html>