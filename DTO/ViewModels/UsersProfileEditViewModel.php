<?php

namespace DTO\ViewModels;

class UsersProfileEditViewModel
{

    private $username;


    private $profilePictureUrl;


    /**
     * @param $username
     * @param $profilePictureUrl
     */
    public function __construct($username, $profilePictureUrl)
    {
        $this->username = $username;
        $this->profilePictureUrl = $profilePictureUrl;
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
    public function getProfilePictureUrl()
    {
        return $this->profilePictureUrl;
    }



}