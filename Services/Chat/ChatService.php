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
    public function createMessage(string $senderId, string $reciverGuid, string $content)
    {
        $user = $this->userRepository->getByGuid($reciverGuid);

        if ($user === null) {
            throw new ChatException("Please select a valid user");
        }

        $userRecivedId = $user->getId();

        // Update status
        $updateStatus = $this->chatRepository->normalStatus($senderId);

        // Create message
        $this->chatRepository->createMessage($senderId, $userRecivedId, $content);

        // You can now use the $updateStatus variable if needed.
        // For example, you can return it from this method or perform other actions.
        return $updateStatus;
    }


    public function getMessagesBetweenUsers(int $user1Id, string $user2Id)
    {
        $messageArray = [];
        $user = $this->userRepository->getByGuid($user2Id);
        $user2Id = $user->getId();
        $this->chatRepository->normalStatus($user2Id);
        $messagesFromUser1 = $this->chatRepository->getMessagesBetweenUsers($user1Id, $user2Id);
        $messagesFromUser2 = $this->chatRepository->getMessagesBetweenUsers($user2Id, $user1Id);

        $allMessages = [];
        foreach (array_merge($messagesFromUser1, $messagesFromUser2) as $message) {
            $allMessages[$message->getId()] = $message;
        }
        foreach ($allMessages as $message) {
            $id = $message->getId();
            $content = $message->getContent();
            $sender = $message->getSenderId();
            $user = $this->userRepository->getById($sender);
            $username = $user->getUsername();
            $receiver = $message->getReceiverId();

            $messageArray[] = [
                'id' => $id,
                'content' => $content,
                'username' => $username,
                'receiver' => $receiver,
                'isRead'=>$this->IsRead($receiver),
            ];
        }

        return $messageArray;
    }



    public function IsRead(int $sender)
    {
        $message = $this->chatRepository->getLastMessageTimestamp($sender);
        if ($message) {
            $receiverId = $message->getReceiverId();
            $updateStatus = $this->chatRepository->update($receiverId);
            return $updateStatus;
        }
    }

    public function DisplayUsers( $reciver)
    {
        if (!$reciver){
            return null;
        }

         $tueOrFalse =$this->chatRepository->status($reciver);

         if (!$tueOrFalse){
             return null;
         }

         $isRead = $tueOrFalse->getIsRead();
        return $isRead;
    }

    public function getReciver($id)
    {
       $recivedId = $this->chatRepository->userId($id);

       if (!$recivedId){
           return null;
       }
        foreach ($recivedId as $users){
            $reciver = $users->getReceiverId();
            return $reciver;
        }
    }

    public function getSendr(int $reciverId)
    {
        $user = $this->chatRepository->senderId($reciverId);

       $users = [];
        foreach ($user as $currUser){
           $id = $currUser->getSenderId();
            $currUser  = $this->userRepository->getById($id);
            $username = $currUser->getUsername();

           $users [] = $username;
        }

        return $users;
    }

    public function setIsRead(int $sender)
    {
        $updateStatus = $this->chatRepository->normalStatus($sender);
        return $updateStatus;
    }
}