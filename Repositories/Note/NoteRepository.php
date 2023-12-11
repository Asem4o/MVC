<?php

namespace Repositories\Note;

use Database\DatabaseInterface;
use DTO\Note;
use DTO\UserDTO;

class NoteRepository implements NoteRepositoryInterface
{
    private  $db;

    /**
     * @var DatabaseInterface
     */
    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }


    public function create(int $userId, string $noteContent)
    {
        $currentTimestamp = date('Y-m-d H:i:s');
        $user =$this->db->query("INSERT INTO note (userId, note, created) VALUES (?, ?, ?)")
            ->execute([$userId, $noteContent,$currentTimestamp]);

    }



    public function getAllNotes(int $userId): ?array
    {

        $query = "SELECT note.id, note.note,note.created FROM note INNER JOIN users ON note.userId = users.id WHERE users.id = ?";

        $all = $this->db->query($query)->execute([$userId])->fetchAll(\DTO\Note::class);

        return $all;
    }

    public function deleteNote(int $id){
        $query = "DELETE FROM note WHERE id = ?";
        $result = $this->db->query($query)->execute([$id])->fetch(Note::class);
        return $result;
    }


    public function editNote(int $id, string $text)
    {
        $query = "UPDATE note SET note = ? WHERE id = ?";
        $result = $this->db->query($query)->execute([$text, $id]);

    }

}