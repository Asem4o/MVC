<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Change picture</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../CSS/users/picture.css">
</head>
<?php if ($model->getError() !== null): ?>
<div class="error-box">
    <h1><?= $model->getError(); ?></h1>
<body>
<div class="note">
    <h1>Change Profile Picture</h1>

    <form method="post" action="changePicture" enctype="multipart/form-data" class="mb-4">
        <div class="form-group">
            <label for="profile_picture">Profile picture:</label>
            <input type="file" id="profile_picture" name="profile_picture" class="form-control-file" />
        </div>

        <button type="submit" name="edit" class="btn btn-info">Change</button>
        <a href="profile" class="btn btn-outline-danger">back to profile</a>
    </form>

    <div id="error" class="mt-3">
        <?php if (!empty($error)) : ?>
            <p><?= $error->getMessage(); ?></p>
        <?php endif; ?>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
<?php endif; ?>