<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Note</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../CSS/users/note.css">
</head>

<body>
<div class="note">
    <h1>Add Note</h1>
    <form method="post" action="createNote" class="mb-4">
        <div class="form-group">

            <label for="note">Note:</label>

            <textarea id="note" name="note" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Add Note</button>
        <a href="profile" class="btn btn-outline-danger">back to profile</a>
    </form>
</div>

<!-- Bootstrap JS and Popper.js (required for Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
