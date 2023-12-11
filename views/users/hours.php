<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit your profile</title>

    <link rel="stylesheet" href="../../CSS/users/hours.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
<div class="note">
    <h1>Add Hours</h1>
    <form method="post" action="createHours" class="mb-4">
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" class="form-control">
        </div>
        <div class="form-group">
            <label for="hours">Hours:</label>
            <!-- Use type="number" and step="any" for floating-point numbers -->
            <input type="number" id="hours" name="hours" class="form-control" step="any">
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Add Hours</button>
    </form>
</div>
<div class="font">

</div>


<!-- Bootstrap JS and Popper.js (required for Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
