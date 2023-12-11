<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit your profile</title>
</head>

<body>
<h1>Change picture</h1>

<form method="post" action="changePicture" enctype="multipart/form-data">
    Profile picture: <input type="file" name="profile_picture"/><br/>
    <input type="submit" name="edit" value="chage"/>
</form>


<div id="error" style="color:red">
    <?php if (!empty($error)) : ?>
        <h1><?= $error->getMessage(); ?></h1>
    <?php endif; ?>
</div>

</body>
</html>
