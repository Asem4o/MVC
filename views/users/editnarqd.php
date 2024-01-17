<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit narqd</title>

    <link rel="stylesheet" href="../../CSS/users/hours.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="note">
    <h1>Edit Hours</h1>
    <form method="post" action="editUserNarqd" class="mb-4">
        <input type="hidden" name="narqdId" value="<?= $model->getNoteId() ?>">
        <input type="hidden" name="userId" value="<?= $model->getId() ?>">
        <div class="form-group">
            <label for="note">Hours:</label>
            <input type="number" id="note" name="note" class="form-control" step="any" value="<?= $model->getNote() ?>">
        </div>

        <button type="submit" class="btn btn-warning">Edit Hours</button>
        <a href="profile" class="btn btn-outline-danger">back to profile</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
