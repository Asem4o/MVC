<?php
namespace Services\Otpuska;
use DateTime;
use Exception\User\OtpuskaCreateException;
use Repositories\Otpuska\OtpuskaRepositoryInterface;
use Repositories\Users\UserRepositoryInterface;

class OtpuskaService implements OtpuskaServiceInterface
{
    private $otpuskaRepository;
    private $userRepository;
    public function __construct(OtpuskaRepositoryInterface $otpuskaService, UserRepositoryInterface $userRepository )
    {
        $this->otpuskaRepository = $otpuskaService;
        $this->userRepository = $userRepository;
    }
    public function create(int $id, string $otpuska, string $date)
    {

        $user = $this->userRepository->getById($id);
        $userId = $user->getId();
        $narqdData = $this->otpuskaRepository->getAllOtpuska($id);

        $dateTime = new DateTime();
        $formattedDate = $dateTime->format('Y');
        foreach ($narqdData as $userYearsCreated) {
            $narqdDate = $userYearsCreated->getCreated();

            if ($narqdDate == $date) {
                throw new OtpuskaCreateException("You already have days for this year change it");
            }
        }
        if ($date > $formattedDate){
            throw new OtpuskaCreateException("you cant add rental days for this year");
        }
        if (!is_numeric($otpuska)) {
            throw new OtpuskaCreateException("Invalid number");
        }

        if ($otpuska > 150) {
            throw new OtpuskaCreateException("Impossible rental days");
        }

        $otpuska = $this->otpuskaRepository->create($userId, $otpuska, $date);

        return $otpuska;
    }


    public function showOtpuska(int $id): ?array
    {
        $narqdData = $this->otpuskaRepository->getAllOtpuska($id);

        if (!$narqdData) {
            return null;
        }

        $narqds = [];
        $monthlySum = [];

        foreach ($narqdData as $narqdObject) {
            $id = $narqdObject->getId();
            $narqdCompensation = $narqdObject->getOtpuska();
            $floatHours = (float) $narqdCompensation;
            $narqdDate = $narqdObject->getCreated();
            $dateTime = new DateTime($narqdDate);
            $formattedDate = $dateTime->format('Y');

            if (!is_numeric($floatHours)) {
                echo "not a number!";
            }

            if (!isset($monthlySum[$formattedDate])) {
                $monthlySum[$formattedDate] = $floatHours;
            } else {
                $monthlySum[$formattedDate] += $floatHours;
            }

            $narqds[] = ['id' => $id, 'days' => $narqdCompensation, 'created' => $narqdDate];
        }

        // Custom sorting function for sorting by 'created' key
        usort($narqds, function ($a, $b) {
            return strtotime($a['created']) - strtotime($b['created']);
        });

        ksort($monthlySum);

        return ['otpuska' => $narqds, 'monthlySum' => $monthlySum];
    }

    public function deleteOtpuska(int $noteId, int $userId)
    {
        $deletedNarqd = $this->otpuskaRepository->deleteOtpuska($noteId);
        return $deletedNarqd;
    }

    public function editOtpuskaById(int $userId, int $id, string $text)
    {
        $user =$this->userRepository->getById($_SESSION['id']);
        $currentId = $user->getId();
        $currentNumber =(float)$text;
        $editNarqd = $this->otpuskaRepository->editOtpuska($id,$text);
        return $editNarqd;
    }


}