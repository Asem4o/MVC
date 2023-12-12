<?php
// editOtpusk.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the expected POST parameters are set
    if (isset($_POST['compensationId']) && isset($_POST['updatedDays'])) {


    } else {
        // Handle missing parameters
        echo 'Missing parameters!';
    }
} else {
    // Handle non-POST requests
    echo 'Invalid request method!';
}
?>
