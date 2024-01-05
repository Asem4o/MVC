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
            <div style="color: gray">
                <h4>hi</h4>
                <?php print $model->getUsername(); ?>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="list-group chat-list" id="user-list">
                        <?php foreach ($model->getAllUsers() as $user): ?>
                            <a href="#" class="list-group-item list-group-item-action" data-guid="<?=$user['guid']?>" onclick="selectUser(this, '<?=$user['username']?>', '<?=$user['guid']?>')">
                                <?=$user['username']?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-8">
                    <div class="chat-messages" id="chat-messages">
                    </div>
                    <div class="input-group">
                        <form method="post" action="send" class="d-flex" id="messageForm" enctype="multipart/form-data">
                            <input type="hidden" name="username" id="username">
                            <input type="hidden" name="guid" id="guid">
                            <input type="text" class="form-control" name="content" id="content" placeholder="Type your message">
                            <button type="submit" class="btn btn-primary ml-2">Send</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="selected-username">
<input type="hidden" id="selected-guid">


</body>
</html>
