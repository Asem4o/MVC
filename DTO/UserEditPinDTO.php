<?php
namespace DTO;

class UserEditPinDTO
{

    private $username;

    private $pin;

    private $newPassword;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * @param mixed $pin
     */
    public function setPin($pin): void
    {
        $this->pin = $pin;
    }

    /**
     * @return mixed
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @param mixed $newPassword
     */
    public function setNewPassword($newPassword): void
    {
        $this->newPassword = $newPassword;
    }

    /**
     * @param $username
     * @param $pin
     * @param $newPassword
     */
    public function __construct($username, $pin, $newPassword)
    {
        $this->username = $username;
        $this->pin = $pin;
        $this->newPassword = $newPassword;
    }


}