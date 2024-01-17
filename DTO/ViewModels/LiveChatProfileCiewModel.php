<?php

namespace DTO\ViewModels;

class LiveChatProfileCiewModel
{
    private $username;

    private $id;

    private $pic;

    private $lastSeen;

    private $error;

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }
    private $receivedMessages = [] ;

    public function getReceivedMessages()
    {
        return $this->receivedMessages ?? [];
    }


    public function getPic()
    {
        return $this->pic;
    }


    public function __construct($username = null, $id = null, $pic= null ,$lastSeen =null,$receivedMessages=null ,$error =null)
    {
        $this->username = $username;
        $this->id = $id;
        $this->pic=$pic;
        $this->lastSeen=$lastSeen;
        $this->receivedMessages=$receivedMessages;
        $this->error=$error;
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
    public function getId()
    {
        return $this->id;
    }

}
