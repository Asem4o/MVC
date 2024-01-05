<?php
namespace Services\Note;
use DTO\Note;
use DTO\NoteEdit;
use Exception\User\NoteCreateException;
use Exception\User\NoteDeleteException;
use Exception\User\NoteEditException;
use Repositories\Note\NoteRepositoryInterface;
use Repositories\Users\UserRepositoryInterface;

class NoteService implements NoteServiceInterface
{
    private $noteRepository;
    private $userRepository;

    /**
     * @param NoteRepositoryInterface $noteRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(NoteRepositoryInterface $noteRepository, UserRepositoryInterface $userRepository)
    {
        $this->noteRepository = $noteRepository;
        $this->userRepository = $userRepository;
    }

    public function create(int $userId, string $note)
    {

        $user = $this->userRepository->getById($userId);

        $userId = $user->getId();
        if (strlen($note) > 255){
            throw new NoteCreateException("too long text");
        }
        $note = $this->noteRepository->create($userId,$note);
        return $note;

    }
    public function showNotes(int $userId): ?array
    {
        $notesData = $this->noteRepository->getAllNotes($userId);
        if (!$notesData) {
            return null;
        }

        $notes = [];


        foreach ($notesData as $noteObject) {

            $id = $noteObject->getGuid();
            $noteContentObject = $noteObject->getNote();

            $noteDate = $noteObject->getCreated();
            $notes[] = ['id' => $id, 'content' => $noteContentObject,'created'=>$noteDate];
        }
        return $notes;
    }

    public function deleteNoteById(string $noteId, string $userID)
    {
        $currentUser = $this->noteRepository->getByNoteGuid($noteId);
        $id = $currentUser->getId();
        $currUserId = $currentUser->getId();

        if ($currUserId !== $id) {
            throw new NoteDeleteException("Don't have access to this note!");
        }

        $deletedNoteId = $this->noteRepository->deleteNote($id);
        return $deletedNoteId;
    }



    public function editNoteById(string $userId,$noteId,string $text)
    {
        $currentUser = $this->noteRepository->getByNoteGuid($noteId);
        $id = $currentUser->getId();


        if (strlen($text) > 255){
            throw new NoteEditException("too long text");
        }
         $editNote = $this->noteRepository->editNote($id,$text);
        return $editNote;
    }



}