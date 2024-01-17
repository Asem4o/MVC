<?php

namespace Repositories\Chat;

use Database\DatabaseInterface;
use DTO\Chat;

class ChatRepository implements ChatRepositoryInterface
{
    private  $db;

    /**
     * @var DatabaseInterface
     */
    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }


    public function createMessage(int $senderId, int $receiverId, string $content)
    {
        $status = 0;

        $currentTimestamp = date('Y-m-d H:i:s');
        $chat = $this->db->query("INSERT INTO chat (senderId, receiverId, content, timestamp,IsRead) VALUES (?, ?, ?, ?,?)")
            ->execute([$senderId, $receiverId, $content, $currentTimestamp,$status]);
    }

    public function getAllMessages(int $sender)
    {
        $query = "SELECT * FROM chat INNER JOIN users ON chat.senderId = users.id WHERE users.id = ?";

        $all = $this->db->query($query)->execute([$sender])->fetchAll(\DTO\Chat::class);
        return $all;
    }

    public function getMessagesBetweenUsers(int $user1Id, int $user2Id)
    {
        $query = "SELECT * FROM chat WHERE (senderId = ? AND receiverId = ?) OR (senderId = ? AND receiverId = ?)";
        $params = [$user1Id, $user2Id, $user2Id, $user1Id];

        $messages = $this->db->query($query)->execute($params)->fetchAll(\DTO\Chat::class);

        return $messages;
    }

    public function getLastMessageTimestamp(int $id)
    {
        $query = "SELECT * FROM chat WHERE (senderId = ?) order by timestamp DESC LIMIT 1";
        $messages = $this->db->query($query)->execute([$id])->fetch(\DTO\Chat::class);
        return $messages;
    }

    public function update( int $sender ,  int $reciver)
    {

        $query = "UPDATE chat SET IsRead = 1  WHERE (senderId= ? AND receiverId=?)";
        $result = $this->db->query($query)->execute([$sender , $reciver]);

        return $result;

    }

    public function status($sender)
    {
        $query = "SELECT IsRead FROM chat WHERE receiverId = ?";
        $status = $this->db->query($query)->execute([$sender])->fetch(Chat::class);
        return $status;
    }

    public function userId($id)
    {

        $query = "SELECT receiverId FROM chat WHERE senderId = ?";
        $status = $this->db->query($query)->execute([$id])->fetchAll(Chat::class);
        return $status;
    }

    public function senderId($id)
    {
        $query = "SELECT senderId FROM chat WHERE receiverId = ?;";
        $status = $this->db->query($query)->execute([$id])->fetchAll(Chat::class);
        return $status;
    }

    public function normalStatus(int $sender , int $reciver)
    {

        $query = "UPDATE chat SET IsRead = 0 WHERE senderId = ? AND receiverId = ?";
        $result = $this->db->query($query)->execute([$sender,$reciver]);

        return $result;
    }

    public function createConversation(int $sender, int $reciver)
    {
        $query = "INSERT INTO 
			         conversation(senderId, reciverId , statusa)
			         VALUES (?,?,?)";
        $result = $this->db->query($query)->execute([$sender,$reciver , 0]);
        return $result;
    }

    public function conversation($sender, $reciver)
    {
        $query = "SELECT * FROM conversations
               WHERE (senderId=? AND reciverId=?)
               OR    (reciverId=? AND senderId=?)";
        $result = $this->db->query($query)->execute([$sender,$reciver]);
        return $result;
    }
}