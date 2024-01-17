<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holidays</title>

    <link rel="stylesheet" href="../../CSS/users/hours.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add this to the head section of your HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</head>

<body>
<div class="note">
    <h1>Add Rental days</h1>
    <form method="post" action="createOtpuska" class="mb-4">
        <div class="form-group">
            <label for="date">Select Year:</label>
            <!-- Use flatpickr with the yearSelector option -->
            <input type="text" id="date" name="date" class="form-control" placeholder="Select Year">
            <small class="form-text text-muted">Please select the desired year.</small>
        </div>
        <div class="form-group">
            <label for="days">Days:</label>
            <input type="number" id="days" name="days" class="form-control" step="any">
        </div>

        <button type="submit" class="btn btn-primary">Add Days</button>
        <a href="profile" class="btn btn-outline-danger">back to profile</a>
        <script>
            flatpickr("#date", {
                dateFormat: "Y",  // Set the date format to display only the year
                yearSelector: true  // Enable the year selector
            });
        </script>
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
