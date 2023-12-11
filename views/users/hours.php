<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit your profile</title>
</head>

<body>
<h1>Add Hours</h1>
<form method="post" action="createHours">
    <label for="date">Date:</label>
    <input type="date" id="date" name="date"><br>
    <label for="note">Hours:</label>
    <textarea id="note" name="hours"></textarea><br>

    <!-- Submit button -->
    <input type="submit" value="Add Hours">
</form>
</body>

</html>
