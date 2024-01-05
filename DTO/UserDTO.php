<?php
namespace DTO;

require_once 'vendor/autoload.php';



class UserDTO
{
    private $id;

    private $username;

    private $password;

    private $confirmPassword;


    private $url;
    private  $note;

    private $isRead;

    /**
     * @param mixed $isRead
     */
    public function setIsRead($isRead): void
    {
        $this->isRead = $isRead;
    }

    /**
     * @return mixed
     */
    public function getIsRead()
    {
        return $this->isRead;
    }
    private $compensation;

    private $otpuska;

    private $guid;

    private $newMessages;

    /**
     * @return mixed
     */
    public function getNewMessages()
    {
        return $this->newMessages;
    }


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
        if (!$this->id) {
            $this->id = Uuid::uuid4()->toString();
        }

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
