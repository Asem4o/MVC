<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit your profile</title>
</head>

<body>
<h1>add NOTE</h1>
<form method="post" action="createNote">
    <textarea type="text" name= "note" ></textarea><br>
    <input type="submit" value="add Note">
</form>