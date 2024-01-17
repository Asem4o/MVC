<?php

namespace DTO\ViewModels;

class UsersProfileViewModel
{

    private $id;

    /**
     * @return mixed
     */

    private $guid;

    /**
     * @return mixed
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * @param mixed $guid
     */
    public function setGuid($guid): void
    {
        $this->guid = $guid;
    }
    private $username;

    private $profilePictureUrl;

    private $note = [];

    private $noteId;

    private $otpuska;

    private $token;


    private $isRead;

    /**
     * @return mixed
     */
    public function getIsRead()
    {
        return $this->isRead;
    }
    public function getOtpuska()
    {
        return $this->otpuska;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }
    private $error;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
    public function getError(): ?string
    {
        return $this->error;
    }


    public function getNarqdId()
    {
        return $this->narqdId;
    }


    public function __construct($id,$username, $profilePictureUrl=null,
                                $note =null,$noteId=null,$error=null,$token,$otpuska=null,$guid= null,$isRead = null)
    {
        $this->id=$id;

        $this->username = $username;
        $this->profilePictureUrl = $profilePictureUrl;
        $this->note=$note;
        $this->noteId=$noteId;
        $this->error=$error;
        $this->token =$token;
        $this->otpuska=$otpuska;
        $this->guid=$guid;
        $this->isRead=$isRead;
    }

    /**
     * @return mixed|null
     */
    public function getNoteId()
    {
        return $this->noteId;
    }

    /**
     * @param mixed|null $noteId
     */

    /**
     * @return mixed|null
     */
    public function getNote()
    {
        return $this->note ?? [];
    }


    public function getProfilePictureUrl()
    {
        return $this->profilePictureUrl;
    }


    public function getUsername()
    {
        return $this->username;
    }

}