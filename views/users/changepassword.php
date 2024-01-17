<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Change password</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../CSS/users/password.css">
</head>

<body>
<div class="note">
    <h1>Change Password</h1>

    <form method="post" action="editPassword" class="mb-4">
        <div class="form-group">
            <label for="old">Old Password:</label>
            <input type="password" id="old" name="old" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="new">New Password:</label>
            <input type="password" id="new" name="new" class="form-control" required>
        </div>
        <div>
            <button type="submit" name="edit" class="btn btn-warning">Change Password</button>
            <a href="profile" class="btn btn-outline-danger">back to profile</a>
        </div>

    </form>
</div>


<!-- Bootstrap JS and Popper.js (required for Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
