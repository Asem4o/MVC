<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit your profile</title>
</head>

<body>
<form method="post" action="editUserNote">
    <input type="hidden" name="noteId" value="<?= $model->getNoteId() ?>">
    <input type="hidden" name="userId" value="<?= $model->getId() ?>">
    <textarea name="note"><?= $model->getNote() ?></textarea><br>
    <input type="submit" value="Edit Note">
</form>
