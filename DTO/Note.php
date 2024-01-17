<?php
namespace DTO;

require_once 'vendor/autoload.php';

class Note
{
    private $id;


    private  $note = [];

    private $created;

    private $guid;

    private $createGuid;

    /**
     * @return mixed
     */
    public function getCreateGuid()
    {
        return \Ramsey\Uuid\Uuid::uuid4()->toString() ?? $this->guid;
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

    public function getNote()
    {
        return $this->note;
    }

    public function setNote(array $note): void
    {
        $this->note = $note;
    }



}
