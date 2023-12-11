<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit your profile</title>
</head>

<body>
<h1>Change password </h1>

<?php if (isset($errors) && is_array($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <div id="error" style="color:red">
            <h1><?= $error; ?></h1>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<form method="post" action="editPassword">
    Old Password: <input type="password" name="old"><br />
    New Password: <input type="password" name="new"><br />
    <input type="submit" name="edit" value="ChangePassword!" />
</form>
</body>

</html
