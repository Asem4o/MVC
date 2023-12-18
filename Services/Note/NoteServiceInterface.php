<?php
namespace Services\Note;
use DTO\Note;
use DTO\NoteEdit;

interface NoteServiceInterface
{

    public function create(int $id ,string $note);
    public function showNotes(int $id): ?array;

    public function deleteNoteById(string $noteId, string $userId);
    public function editNoteById(string $userId ,int $id,string $text);



}