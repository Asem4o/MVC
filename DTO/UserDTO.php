<?php
namespace DTO;

class UserDTO
{
    private $id;

    private $username;

    private $password;

    private $confirmPassword;

    private $url;
    private  $note;

    private $compensation;

    private $otpuska;

    /**
     * @return mixed
     */
    public function getOtpuska()
    {
        return $this->otpuska;
    }

    /**
     * @param mixed $otpuska
     */
    public function setOtpuska($otpuska): void
    {
        $this->otpuska = $otpuska;
    }

    /**
     * @return mixed
     */
    public function getCompensation()
    {
        return $this->compensation;
    }

    /**
     * @param mixed $compensation
     */
    public function setCompensation($compensation): void
    {
        $this->compensation = $compensation;
    }

    private $pin;

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
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note): void
    {
        $this->note = $note;
    }

    /**
     * @param array $notes
     */

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }


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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * @param mixed $confirmPassword
     */
    public function setConfirmPassword($confirmPassword): void
    {
        $this->confirmPassword = $confirmPassword;
    }


}
