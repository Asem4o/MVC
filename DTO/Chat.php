<?php
namespace DTO;


require_once 'vendor/autoload.php';

class Chat
{
    private $id;



    private $content;


   private $receiverId;


   private $IsRead;

    /**
     * @return mixed
     */
    public function getIsRead()
    {
        return $this->IsRead;
    }
    public function getReceiverId()
    {
        return $this->receiverId;
    }

    /**
     * @return mixed
     */

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return mixed
     */

    private $senderId;

    public $timestamp;

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
    /**
     * @return mixed
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * @return mixed
     */


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


}
