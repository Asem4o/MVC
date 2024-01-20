<?php /** @var $model DTO\ViewModels\LiveChatProfileCiewModel */

use DTO\ViewModels\LiveChatProfileCiewModel; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="../../CSS/users/liveChat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
<div class="w-400 shadow p-4 rounded">
    <div class="d-flex align-items-center">
        <img width="100px" src= "uploads/../../<?= $model->getPic() ?>" class="w-15 rounded-circle">
        <h3 class="display-4 fs-sm m-2" style="color: red">
           <?= $model->getUsername() ?> <br>
            <div class="d-flex align-items-center" title="online">
            </div>
        </h3>
    </div>

    <div class="shadow p-4 rounded d-flex flex-column mt-2 chat-box" id="chatBox">
        <div class="alert alert-info text-center">
            <i class="fa fa-comments d-block fs-big"></i>
            <?php foreach ($model->getReceivedMessages() as  $message): ?>
                <div class="message">
                    <strong><?=  $message['sender']['username'] ?>:</strong> <?= $message['content'] ?>
                </div>
            <?php endforeach; ?>

        </div>
    </div>

    <div class="input-group mb-3">
        <textarea cols="3" id="message" class="form-control"></textarea>
        <button class="btn btn-primary" id="sendBtn">
            <i class="fa fa-paper-plane"></i>
        </button>

    </div>
    <a href="profile">profile</a>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    var scrollDown = function() {
        let chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight;
    };

    scrollDown();

    $(document).ready(function() {
        $("#sendBtn").on('click', function() {
            var message = $("#message").val();
            if (message === "") return;

            $.post("insertChat", {
                message: message,
                to_id:"<?= $model->getId() ?>"
            }, function(data, status) {
                $("#message").val("");
                $("#chatBox").append(data);
                scrollDown();
                setTimeout(function() {
                    location.reload();
                }, 1);
            });
        });
    });
</script>

</body>
</html>
