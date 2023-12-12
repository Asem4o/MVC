<?php /** @var $model DTO\ViewModels\UsersProfileViewModel */ ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../CSS/users/profile.css">
    <script src="../../JS/users/otpuska.js"></script>
</head>
<body>
<div class="profile">
    <input type="hidden" name="csrfToken" value="<?= $model->getToken() ?>">
    <div class="edit">

        <div class="pic">
                <img width="50px" src="../<?= $model->getProfilePictureUrl(); ?>" alt=""/><br>
                    Welcome, <?= $model->getUsername() ?>
        </div>

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

    <h1>Otpuska</h1>
    <div class="otpuska">
        <?php
        $data = $model->getOtpuska();

        if (isset($data['otpuska']) && !empty($data['otpuska'])) {
            foreach ($data['otpuska'] as $compensation) {
                ?>
                <div class="compensation-item">
                    <strong>Otpuska:</strong>
                    <span id="days-<?= $compensation['id'] ?>" class="days"><?= isset($compensation['days']) ? $compensation['days'] : 'N/A' ?></span>
                    <button class="btn-increment" onclick="changeDays('<?= $compensation['id'] ?>', '+', '<?= $compensation['created'] ?>')">+</button>
                    <button class="btn-decrement" onclick="changeDays('<?= $compensation['id'] ?>', '-', '<?= $compensation['created'] ?>')">-</button>
                    <br>
                    <strong>Created:</strong> <?= isset($compensation['created']) ? $compensation['created'] : 'N/A' ?>
                </div>

                <?php
            }
            ?>
            <button class="btn-save" onclick="saveChanges()">Save</button>
            <?php

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
    <div class="bottons">
        <a href="note" class="btn btn-primary">add note</a>
        <a href="hours" class="btn btn-primary">add compensation Hours</a>
        <a href="otpuska" class="btn btn-primary">add Otpuska</a>
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
