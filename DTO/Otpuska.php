<?php
namespace DTO;



class Otpuska
{
    private $id;


    private  $otpuska = [];

    public function getOtpuska()
    {
        return $this->otpuska;
    }

    public function setOtpuska(array $otpuska): void
    {
        $this->otpuska = $otpuska;
    }

    private $createdYear;

    /**
     * @return mixed
     */
    public function getCreatedYear()
    {
        return $this->createdYear;
    }
    private $created;

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created): void
    {
        $this->created = $created;
    }


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



}
