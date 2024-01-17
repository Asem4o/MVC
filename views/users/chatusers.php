<?php /** @var $model DTO\ViewModels\ChatProfileViewModel */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/users/chat.css">
    <script src="../../JS/users/chat.js"></script>

</head>
<body>

<div class="new-message text-danger">
    <?php if ($model->getIsRead() === 0): ?>
        <h4>new messages from users</h4>
        <?php foreach ($model->getNewMessageUsers() as $user): ?>
            <p><?= $user; ?></p>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<div class="container">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                </div>
                <div class="col-8">
                    <div class="chat-messages" id="chat-messages">
                        <?php foreach ($model->getReceivedMessages() as $message): ?>
                            <div class="message">
                                <strong><?= $message['username'] ?></strong>: <?= $message['content'] ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <form method="post" action="chatUsers">
                        <input type="hidden" name="username" value="<?= $model->getUsername() ?>">
                        <input type="hidden" name="guid" value="<?= $model->getGuid() ?>">
                        <input type="text" class="form-control" name="content" id="content" placeholder="Type your message">
                        <button type="submit" class="btn btn-primary ml-2">Send</button>
                        <a href="profile" class="btn btn-outline-danger">back to profile</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="../../JS/users/chat.js"></script>

<input type="hidden" id="selected-username">
<input type="hidden" id="selected-guid">

</body>
</html>
