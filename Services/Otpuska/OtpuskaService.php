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
    public function __construct(OtpuskaRepositoryInterface $otpuskaService, UserRepositoryInterface $userRepository)
    {
        $this->otpuskaRepository = $otpuskaService;
        $this->userRepository = $userRepository;
    }
    public function create(int $id, string $otpuska, string $date)
    {
        $user = $this->userRepository->getById($id);
        $userId = $user->getId();

        if (!is_numeric($otpuska)) {
            throw new OtpuskaCreateException("invalid number");
        }
        if ($otpuska > 150){
            throw new OtpuskaCreateException("imposible otpuska");
        }
        $otpuska = $this->otpuskaRepository->create($userId,$otpuska,$date);
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

            if (!is_numeric($floatHours)){
                echo "gg";
            }
            if (!isset($monthlySum[$formattedDate])) {
                $monthlySum[$formattedDate] = $floatHours;
            } else {

                $monthlySum[$formattedDate] += $floatHours;
            }

            $narqds[] = ['id' => $id, 'days' => $narqdCompensation, 'created' => $narqdDate];
        }

        ksort($monthlySum);

        return ['otpuska' => $narqds, 'monthlySum' => $monthlySum];
    }

    public function deleteOtpuska(int $noteId, int $userId)
    {
        // TODO: Implement deleteOtpuska() method.
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