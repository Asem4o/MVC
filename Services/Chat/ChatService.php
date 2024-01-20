<?php

namespace Services\Chat;

use Exception\User\ChatException;
use Repositories\Users\UserRepositoryInterface;
use Repositories\Chat\ChatRepositoryInterface;

class ChatService implements ChatServiceInterface
{
    private $chatRepository;
    private $userRepository;

    public function __construct(ChatRepositoryInterface $chatRepository, UserRepositoryInterface $userRepository)
    {
        $this->chatRepository = $chatRepository;
        $this->userRepository = $userRepository;
    }

    public function createMessage(int $senderId, int $reciverGuid, string $content)
    {
        var_dump($senderId);
        var_dump($reciverGuid);
        var_dump($content);
        if ($reciverGuid === null) {
            throw new ChatException("Please select a valid user");
        }

        $this->chatRepository->createMessage($senderId, $reciverGuid, $content);

    }


    public function getMessagesBetweenUsers(int $reciverId, int $senderId)
    {
        $messageArray = [];

        $messagesFromUser1 = $this->chatRepository->getMessagesBetweenUsers($reciverId, $senderId);
        $messagesFromUser2 = $this->chatRepository->getMessagesBetweenUsers($senderId, $reciverId);

        // Merge and deduplicate messages
        $allMessages = array_merge($messagesFromUser1, $messagesFromUser2);
        $uniqueMessages = array_values(array_unique(array_map('serialize', $allMessages)));
        $uniqueMessages = array_map('unserialize', $uniqueMessages);
        $isRead = $this->IsRead($reciverId, $senderId);

        foreach ($uniqueMessages as $message) {
            $id = $message->getId();
            $content = $message->getContent();
            $sender = $message->getSenderId();
            $receiver = $message->getReceiverId();

            $senderUsername = $this->userRepository->getById($sender)->getUsername();

            $receiverUsername = $this->userRepository->getById($receiver)->getUsername();
            $messageArray[] = [
                'id' => $id,
                'content' => $content,
                'sender' => [
                    'id' => $sender,
                    'username' => $senderUsername,
                ],
                'receiver' => [
                    'id' => $receiver,
                    'username' => $receiverUsername,
                ],
                'isRead' => $isRead,
            ];
        }


        return $messageArray;
    }


    public function IsRead(int $reciver ,int $sender)
    {
        $message = $this->chatRepository->getLastMessageTimestamp($reciver);
        if ($message) {
            $updateStatus = $this->chatRepository->update($reciver, $sender);
            return $updateStatus;
        }

        return false;
    }

    public function DisplayUsers($reciver)
    {
        if (!$reciver) {
            return null;
        }

        $tueOrFalse = $this->chatRepository->status($reciver);

        if (!$tueOrFalse) {
            return null;
        }

        $isRead = $tueOrFalse->getIsRead();
        return $isRead;
    }

    public function getReciver($id)
    {
        $recivedId = $this->chatRepository->userId($id);

        if (!$recivedId) {
            return null;
        }
        foreach ($recivedId as $users) {
            $reciver = $users->getReceiverId();
            return $reciver;
        }
    }

    public function getSendr(int $reciverId)
    {
        $user = $this->chatRepository->senderId($reciverId);

        $users = [];
        foreach ($user as $currUser) {
            $id = $currUser->getSenderId();
            $currUser = $this->userRepository->getById($id);
            $username = $currUser->getUsername();

            $users [] = $username;
        }

        return $users;
    }

    public function setIsRead(int $sender)
    {
        $message = $this->chatRepository->getLastMessageTimestamp($sender);
        if ($message) {
            $receiverId = $message->getReceiverId();
            $updateStatus = $this->chatRepository->update($receiverId);
            return $updateStatus;
        }
    }

    public function getSender(int $reciverId)
    {
        $user = $this->chatRepository->senderId($reciverId);

        $users = [];
        foreach ($user as $currUser) {
            $id = $currUser->getSenderId();
            $currUser = $this->userRepository->getById($id);
            $username = $currUser->getUsername();

            $users [] = $username;
        }

        return $users;
    }

    public function createConversation(int $sender, int $reciver)
    {

        $this->chatRepository->createConversation($sender,$reciver);
    }

    public function statusConversation($sender, $reciver)
    {
        $this->chatRepository->conversation($sender , $reciver);
    }
}