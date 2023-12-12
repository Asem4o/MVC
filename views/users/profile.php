<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../CSS/users/profile.css">
</head>
<body>
<div class="profile">
    <input type="hidden" name="csrfToken" value="<?= $model->getToken() ?>">
    <div class="edit">
        <div class="edit-link">
            <a href="editProfilePicture" class="btn-primary">Change Profile Picture</a>
        </div>
        <div class="edit-link">
            <a href="changePassword" class="btn-primary">Change Password</a>
        </div>
        <div class="edit-link">
            <a href="logout" class="btn-primary">Logout</a>
        </div>
    </div>


    <h2 style="color:green">


        <?php if ( $model->getProfilePictureUrl() === null): ?>
            <h2>Нямаш профилна снимка</h2>
        <?php else: ?>
            <img width="55px" src="../<?= $model->getProfilePictureUrl(); ?>" alt=""/><br>
            Welcome, <?= $model->getUsername() ?>
        <?php endif; ?>
    </h2>
    <div class="bottons">
        <a href="note" class="btn btn-primary">add note</a><br><br>
        <a href="hours" class="btn btn-primary">add compensation Hours</a><br>
    </div>

    <h1>Notes</h1>
    <div class="notes">
        <?php
        $notes = $model->getNote();

        if (!empty($notes)) {
            foreach ($notes as $note) {
                ?>
                <strong>Note:</strong> <?= $note['content'] ?><br>
                <strong>Created:</strong> <?= $note['created'] ?><br>


                <form method="post" action="deleteNote" style="display: inline;">
                    <input type="hidden" name="note_id" value="<?= $note['id'] ?>">
                    <input type="hidden" name="deleteId" value="<?= $model->getId() ?>">
                    <button type="submit" class="btn-danger">Delete</button>
                </form>
                <form method="post" action="editNote" style="display: inline;">
                    <input type="hidden" name="noteId" value="<?= $note['id'] ?>">
                    <input type="hidden" name="content" value="<?= $note['content'] ?>">
                    <button type="submit"class="btn-success">Edit Note</button>
                </form>

                <br>
                <?php
            }
        } else {
            echo "No notes available."; // You can customize this message based on your requirements.
        }
        ?><br><br>

    </div>


    <h1>Narqd Compensation</h1>

    <div class="narqd">
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
                    <button type="submit" class="btn-danger">Delete</button>
                </form>
                <form method="post" action="editNarqd" style="display: inline;">
                    <input type="hidden" name="narqdId" value="<?= $compensation['id'] ?>">
                    <input type="hidden" name="content" value="<?= $compensation['compensation'] ?>">
                    <button type="submit"class="btn-success" >Edit Hours</button>
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

    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</div>
</body>
</html>
