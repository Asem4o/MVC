<?php

namespace Repositories\Note;

use DTO\Note;
use DTO\UserDTO;

interface NoteRepositoryInterface
{

    public function create(int $id , string $note);

    public function getAllNotes (int $id): ?array;
    public function deleteNote (int $id);
    public function editNote (int $id,string $text);
    public function getByNoteGuid(string $userId);


}