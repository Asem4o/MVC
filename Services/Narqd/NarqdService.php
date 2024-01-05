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
    public function create(string $id, string $narqd , string $date)
    {
        $user = $this->userRepository->getByGuid($id);

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
            $id = $narqdObject->getGuid();
            $narqdCompensation = $narqdObject->getCompensation();
            $floatHours = (float) $narqdCompensation;
            $narqdDate = $narqdObject->getCreated();
            $dateTime = new DateTime($narqdDate);
            $formattedDate = $dateTime->format('Y-m');

            if (!is_numeric($floatHours)){
                echo "gg";
            }
            if (!isset($monthlySum[$formattedDate])) {
                $monthlySum[$formattedDate] = $floatHours;
            } else {

                $monthlySum[$formattedDate] += $floatHours;
            }

            $narqds[] = ['id' => $id, 'compensation' => $narqdCompensation, 'created' => $narqdDate];
        }

        ksort($monthlySum);

        return ['narqds' => $narqds, 'monthlySum' => $monthlySum];
    }


    public function deleteNarqdById(string $noteId, string $userId)
    {

        $currentUser = $this->narqdRepository->getByNarqdGuid($noteId);
        $id = $currentUser->getId();

        $currUserId = $currentUser->getId();

        if ($currUserId !== $id) {
            throw new NarqdDeleteException("Don't have access to this narqd!");
        }


        $deletedNarqd = $this->narqdRepository->deleteNarqd($id);
        return $deletedNarqd;
    }

    public function editNarqdById(string $userId, string $guid, string $text)
    {
        $currentUser = $this->narqdRepository->getByNarqdGuid($guid);

        $id = $currentUser->getId();
        $currentNumber =(float)$text;

        if (!is_numeric($text)) {
            throw new NarqdEditException("invalid number");
        }
        if ($currentNumber> 255){
            throw new NarqdEditException("imposilble compensation");
        }
        $editNarqd = $this->narqdRepository->editNarqd($id,$text);
        return $editNarqd;
    }
}