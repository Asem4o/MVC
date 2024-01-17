<?php

namespace Repositories\Narqd;

use Database\DatabaseInterface;
use DTO\Narqd;
use DTO\Note;
use DTO\UserDTO;
class NarqdRepository implements NarqdRepositoryInterface
{    private  $db;

    /**
     * @var DatabaseInterface
     */
    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }


    public function create(int $userId, string $hours ,string $date)
    {
        $narqd = new Narqd();
        $guidGenerate = $narqd->getCreatedGuid();
        $user =$this->db->query("INSERT INTO narqd (guid,userId, compensation, created) VALUES (?,?, ?, ?)")
            ->execute([$guidGenerate,$userId, $hours,$date]);

    }

    public function getAllNarqds(int $id): ?array
    {
        $query = "SELECT narqd.id,narqd.guid, narqd.compensation,narqd.created FROM narqd INNER JOIN users ON narqd.userId = users.id WHERE users.id = ?";

        $all = $this->db->query($query)->execute([$id])->fetchAll(\DTO\Narqd::class);

        return $all;
    }

    public function deleteNarqd(int $id)
    {
        $query = "DELETE FROM narqd WHERE id = ?";
        $result = $this->db->query($query)->execute([$id])->fetch(Narqd::class);
        return $result;
    }

    public function editNarqd(int $id, string $text)
    {
        $query = "UPDATE narqd SET compensation = ? WHERE id = ?";
        $result = $this->db->query($query)->execute([$text, $id]);
    }

    public function getByNarqdGuid(string $userId)
    {
        return $this->db->query("SELECT * FROM narqd WHERE guid = ?")->execute([$userId])->fetch(Narqd::class);
    }
}