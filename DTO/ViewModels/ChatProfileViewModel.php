<?php

namespace DTO\ViewModels;

class ChatProfileViewModel
{
    private $username;
    private $allUsers;

    private $guid;
    private $receivedMessages = [];

    private $isRead;

   private $newMessageUsers = [];

    /**
     * @return mixed
     */
    public function getNewMessageUsers()
    {
        return $this->newMessageUsers  ?? [];
    }
    public function getIsRead()
    {
        return $this->isRead;
    }
    private $erorr;

    /**
     * @return mixed
     */
    public function getErorr()
    {
        return $this->erorr;
    }
    public function getReceivedMessages()
    {
        return $this->receivedMessages ?? [];
    }



    public function __construct($username, $receivedMessages = null, $allUsers = null , $erorr,$isRead=null ,$newMessageUsers = null,$guid=null )
    {
        $this->username = $username;
        $this->allUsers = $allUsers;
        $this->receivedMessages=$receivedMessages;
        $this->erorr=$erorr;
        $this->isRead=$isRead;
        $this->newMessageUsers=$newMessageUsers;
        $this->guid=$guid;
    }

    /**
     * @return mixed|null
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */

    /**
     * @return mixed
     */
    public function getAllUsers()
    {
        return $this->allUsers;
    }
}
