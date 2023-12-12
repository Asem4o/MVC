<?php

namespace DTO\ViewModels;

class UsersProfileViewModel
{

    private $id;

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
    private $username;

    private $profilePictureUrl;

    private $note = [];

    private $noteId;

    private $noteCreated;

    private $token;

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
    public function getError(): ?string
    {
        return $this->error;
    }


    /**
     * @return mixed
     */
    public function getNarqdId()
    {
        return $this->narqdId;
    }


    public function __construct($id,$username, $profilePictureUrl=null,
                                $note =null,$noteId=null,$error=null,$token)
    {
        $this->id=$id;
        $this->username = $username;
        $this->profilePictureUrl = $profilePictureUrl;
        $this->note=$note;
        $this->noteId=$noteId;
        $this->error=$error;
        $this->token =$token;
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
