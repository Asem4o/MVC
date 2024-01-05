<?php
namespace Services\Chat;
interface ChatServiceInterface
{
    public function createMessage(string $senderId , string $reciverGuid , string $content );

    public function getMessagesBetweenUsers(int $sender1 , string $sender2);

    public function IsRead(int $reciverGuid);

    public function DisplayUsers( int $sender);

    public function getReciver($id);

    public function getSendr(int $reciverId);

    public function setIsRead(int $sender);
}