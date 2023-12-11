<?php
namespace Services\Note;
use DTO\Note;
use DTO\NoteEdit;
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

            $id = $noteObject->getId();


            $noteContentObject = $noteObject->getNote();

            $noteDate = $noteObject->getCreated();
            $notes[] = ['id' => $id, 'content' => $noteContentObject,'created'=>$noteDate];
        }
        return $notes;
    }

    public function deleteNoteById(int $noteId, int $userID)
    {
        $currentUser = $this->userRepository->getById($_SESSION['id']);
        $currUserId = $currentUser->getId();

        if ($currUserId !== $userID) {
            throw new NoteDeleteException("Don't have access to this note!");
        }

        $deletedNoteId = $this->noteRepository->deleteNote($noteId);
        return $deletedNoteId;
    }



    public function editNoteById(int $userId,$noteId,string $text)
    {
        $user =$this->userRepository->getById($_SESSION['id']);
        $currentId = $user->getId();
        if ($currentId != $userId){
            throw new NoteEditException("dont have access to this note!");
        }

        $editNote = $this->noteRepository->editNote($noteId,$text);
        return $editNote;
    }



}