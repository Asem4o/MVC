<?php
function generateCsrfToken() {
if (empty($_SESSION['csrfToken'])) {
$_SESSION['csrfToken'] = bin2hex(random_bytes(32)); // Generate a random token
}
return $_SESSION['csrfToken'];
}
