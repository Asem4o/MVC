<?php

namespace Repositories\Otpuska;



use Database\DatabaseInterface;
use DTO\Otpuska;
use PDO;

class OtpuskaRepository implements OtpuskaRepositoryInterface
{
    private  $db;


    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    public function create(int $id, string $hours, string $date)
    {

        $user =$this->db->query("INSERT INTO otpuska (userId, otpuska, created) VALUES (?, ?, ?)")
            ->execute([$id, $hours, $date]);
    }

    public function getAllOtpuska(int $id): ?array
    {
         $query = "SELECT otpuska.id, otpuska.otpuska,otpuska.created FROM otpuska INNER JOIN users ON otpuska.userId = users.id WHERE users.id = ?";

        $all = $this->db->query($query)->execute([$id])->fetchAll(Otpuska::class);

        return $all;
    }

    public function deleteOtpuska(int $id)
    {
        $query = "DELETE FROM otpuska WHERE id = ?";
        $result = $this->db->query($query)->execute([$id])->fetch(Otpuska::class);
        return $result;
    }

    public function editOtpuska(int $id, string $text)
    {
        $query = "UPDATE otpuska SET otpuska = ? WHERE id = ?";
        $result = $this->db->query($query)->execute([$text, $id]);
    }


}