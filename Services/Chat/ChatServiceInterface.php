<?php
namespace Services\Chat;
interface ChatServiceInterface
{
    public function createMessage(int $senderId , int $reciverGuid , string $content );

    public function getMessagesBetweenUsers(int $reciver1 , int $sender2);

    public function IsRead(int $reciverGuid , int $sender);

    public function DisplayUsers( int $sender);

    public function getReciver($id);

    public function getSender(int $reciverId);

    public function setIsRead(int $sender);

    public function createConversation(int $sender , int $reciver);

    public function statusConversation($sender, $reciver);

}