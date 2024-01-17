<?php
namespace DTO;


require_once 'vendor/autoload.php';

class Narqd
{
    private $id;

    private $createguid;

    /**
     * @return mixed
     */
    public function getCreatedGuid()
    {
        return \Ramsey\Uuid\Uuid::uuid4()->toString() ?? $this->guid;
    }
    private $guid;

    /**
     * @return mixed
     */
    public function getGuid()
    {
        return $this->guid;
    }
    private  $compensation = [];

    public function getCompensation()
    {
        return $this->compensation;
    }

    public function setCompensation(array $compensation): void
    {
        $this->compensation = $compensation;
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
