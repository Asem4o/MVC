<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
</head>
<body>
<h1>Profile</h1>
<?php if (isset($errors) && is_array($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <div id="error" style="color:red">
            <h1><?= $error; ?></h1>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<h2 style="color:green">
    <?php if ($model->getProfilePictureUrl() === null): ?>
        <h2>Нямаш профилна снимка</h2>
    <?php else: ?>
        <img width="100px" src="../<?= $model->getProfilePictureUrl(); ?>" alt="myPicture"/><br>
        Welcome, <?= $model->getUsername() ?>
    <?php endif; ?>
</h2>
<h1>Notes</h1>

<?php
$notes = $model->getNote();

if (!empty($notes)) {
    foreach ($notes as $note) {
        ?>
        <strong>Note:</strong> <?= $note['content'] ?><br>
        <strong>Created:</strong> <?= $note['created'] ?><br>

        <form method="post" action="editNote" style="display: inline;">
            <input type="hidden" name="noteId" value="<?= $note['id'] ?>">
            <input type="hidden" name="content" value="<?= $note['content'] ?>">
            <button type="submit">Edit Note</button>
        </form>

        <form method="post" action="deleteNote" style="display: inline;">
            <input type="hidden" name="note_id" value="<?= $note['id'] ?>">
            <input type="hidden" name="deleteId" value="<?= $model->getId() ?>">
            <button type="submit">Delete</button>
        </form><br>

        <br>
        <?php
    }
} else {
    echo "No notes available."; // You can customize this message based on your requirements.
}
?><br><br>

<h1>Narqd Compensation</h1>

<?php
$data = $model->getNoteId();

if (isset($data['narqds']) && !empty($data['narqds'])) {
    foreach ($data['narqds'] as $compensation) {
        ?>
        <strong>Narqd Compensation:</strong> <?= isset($compensation['compensation']) ? $compensation['compensation'] : 'N/A' ?><br>
        <strong>Created:</strong> <?= isset($compensation['created']) ? $compensation['created'] : 'N/A' ?><br>

        <form method="post" action="deleteNarqd" style="display: inline;">
            <input type="hidden" name="narqdId" value="<?= $compensation['id'] ?>">
            <input type="hidden" name="deleteId" value="<?= $model->getId() ?>">
            <button type="submit">Delete</button>
        </form>
        <form method="post" action="editNarqd" style="display: inline;">
            <input type="hidden" name="narqdId" value="<?= $compensation['id'] ?>">
            <input type="hidden" name="content" value="<?= $compensation['compensation'] ?>">
            <button type="submit">Edit Note</button>
        </form><br>
        <?php
    }


    if (isset($data['monthlySum'])) {
        foreach ($data['monthlySum'] as $month => $sum) {
            ?>
            <strong>Monthly Sum for <?= $month ?>:</strong> <?= $sum ?><br>
            <?php
        }
    }

} else {
    echo "No compensation available.";
}
?><br><br>


<a href="editProfilePicture">change profile picture</a><br>
<a href="changePassword">change password</a><br>
<a href="note">add note</a><br>
<a href="hours">add compensation Hours</a><br>
<a href="logout">logout</a><br>



</body>
</html>
