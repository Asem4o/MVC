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
    <?php
    $newMessagesCountByUser = [];

    foreach ($model->getNewMessageUsers() as $user) {
        // Assuming $user is the identifier for each user
        $newMessagesCountByUser[$user] = isset($newMessagesCountByUser[$user]) ? $newMessagesCountByUser[$user] + 1 : 1;
    }

    if (!empty($newMessagesCountByUser)):
        ?>
        <h4>You have new messages:</h4>
        <?php foreach ($newMessagesCountByUser as $user => $count): ?>
        <p><?= $user; ?>: <?= $count; ?> new message(s)</p>
    <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <?php foreach ($model->getAllUsers() as $user): ?>
                        <a href="#" class="list-group-item list-group-item-action" onclick="selectUser(this, '<?=$user['username']?>', '<?=$user['guid']?>')">
                            <?=$user['username']?>
                        </a>
                    <?php endforeach; ?>

                </div>
                <div class="col-8">
                    <div class="chat-messages" id="chat-messages">
                        <div class="input-group"><br>
                            <form method="post" action="newChat" id="messageForm">
                                <input type="hidden" name="username" id="username">
                                <input type="hidden" name="guid" id="guid">
                                <button type="submit" class="btn btn-primary ml-2">Start Chat</button>
                            </form>
                    <a href="profile" class="btn btn-outline-danger">back to profile</a>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="selected-username">
<input type="hidden" id="selected-guid">


</body>
</html>
