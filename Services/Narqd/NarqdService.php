<?php
namespace Services\Narqd;
use DateTime;
use Exception\User\NarqdCreateException;
use Exception\User\NarqdDeleteException;
use Exception\User\NarqdEditException;
use Exception\User\NoteEditException;
use Repositories\Narqd\NarqdRepositoryInterface;
use Repositories\Users\UserRepositoryInterface;

class NarqdService implements NarqdServiceInterface
{
    private $narqdRepository;
    private $userRepository;
    public function __construct(NarqdRepositoryInterface $narqdRepository, UserRepositoryInterface $userRepository)
    {
        $this->narqdRepository = $narqdRepository;
        $this->userRepository = $userRepository;
    }
    public function create(int $id, string $narqd , string $date)
    {
        $user = $this->userRepository->getById($id);
        $userId = $user->getId();
        if (!is_numeric($narqd)) {
           throw new NarqdCreateException("invalid number");
        }
        if ($narqd > 150){
            throw new NarqdCreateException("imposible compensation");
        }
        $narqd = $this->narqdRepository->create($userId,$narqd,$date);
        return $narqd;
    }
    
    public function showNarqd(int $id): ?array
    {
        $narqdData = $this->narqdRepository->getAllNarqds($id);

        if (!$narqdData) {
            return null;
        }

        $narqds = [];
        $monthlySum = [];

        foreach ($narqdData as $narqdObject) {
            $id = $narqdObject->getId();
            $narqdCompensation = $narqdObject->getCompensation();
            $floatHours = (float) $narqdCompensation;
            $narqdDate = $narqdObject->getCreated();
            $dateTime = new DateTime($narqdDate);
            $formattedDate = $dateTime->format('Y-m');

            if (!is_numeric($floatHours)){
                echo "gg";
            }
            if (!isset($monthlySum[$formattedDate])) {
                // If the month key doesn't exist, initialize it with the compensation hours
                $monthlySum[$formattedDate] = $floatHours;
            } else {
                // If the month key already exists, add the compensation hours to the existing value
                $monthlySum[$formattedDate] += $floatHours;
            }

            $narqds[] = ['id' => $id, 'compensation' => $narqdCompensation, 'created' => $narqdDate];
        }

        ksort($monthlySum);

        return ['narqds' => $narqds, 'monthlySum' => $monthlySum];
    }


    public function deleteNarqdById(int $noteId, int $userId)
    {
        $currentUser = $this->userRepository->getById($_SESSION['id']);
        $currUserId = $currentUser->getId();

        if ($currUserId !== $userId) {
            throw new NarqdDeleteException("Don't have access to this narqd!");
        }

        $deletedNarqd = $this->narqdRepository->deleteNarqd($noteId);
        return $deletedNarqd;
    }

    public function editNarqdById(int $userId, int $id, string $text)
    {
        $user =$this->userRepository->getById($_SESSION['id']);
        $currentId = $user->getId();
        $currentNumber =(float)$text;
        if ($currentId != $userId){
            throw new NoteEditException("dont have access to this note!");
        }
        if (!is_numeric($text)) {
            throw new NarqdEditException("invalid number");
        }
        if ($currentNumber> 255){
            throw new NarqdEditException("too long text");
        }
        $editNarqd = $this->narqdRepository->editNarqd($id,$text);
        return $editNarqd;
    }
}