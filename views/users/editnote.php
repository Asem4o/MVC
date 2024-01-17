<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit note</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../../CSS/users/note.css">
</head>

<body>
<div class="note">
    <h1>Edit Note</h1>
    <form method="post" action="editUserNote" class="mb-4">
        <input type="hidden" name="noteId" value="<?= $model->getNoteId() ?>">
        <input type="hidden" name="userId" value="<?= $model->getId() ?>">

        <div class="form-group">
            <label for="note">Edit Note:</label>
            <textarea id="note" name="note" class="form-control" rows="4"><?= $model->getNote() ?></textarea>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-warning">Edit Note</button>
        <a href="profile" class="btn btn-outline-danger">back to profile</a>
    </form>
</div>

<!-- Bootstrap JS and Popper.js (required for Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
