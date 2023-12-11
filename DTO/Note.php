<?php
namespace DTO;



class Note
{
    private $id;


    private  $note = [];

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

    public function getNote()
    {
        return $this->note;
    }

    public function setNote(array $note): void
    {
        $this->note = $note;
    }



}
