<?php

namespace Repositories\Chat;

interface ChatRepositoryInterface
{
    public function createMessage(int $senderId , int $recivedId ,string $content);
    public function getAllMessages(int $sender);

    public function getMessagesBetweenUsers(int $sender1 , int $sender2);
    public function getLastMessageTimestamp(int $id);

    public function update(int $id);

    public function status(int $sender);

    public function userId($id);

    public function senderId($id);

    public function normalStatus($id);
}