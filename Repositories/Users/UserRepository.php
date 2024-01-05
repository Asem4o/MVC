<?php

namespace Repositories\Users;

use Database\DatabaseInterface;
use DTO\AllUsers;
use DTO\RequestsModel\UserRegistrationBidingModel;
use DTO\UserDTO;
use DTO\UserEditDTO;
use DTO\UserEditPinDTO;

class UserRepository implements UserRepositoryInterface
{

  private  $db;

    /**
     * @var DatabaseInterface
     */
    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    public function register(UserRegistrationBidingModel $model)
    {

        $this->db->query("INSERT INTO users (guid, username, password, pin) values (?,?,?,?)")
          ->execute([$model->getGuid(),$model->getUsername(),$model->getPassword(),$model->getPin()]);
    }

    public function getByUsername(string $username): ?UserDTO
    {

        return $this->db->query("SELECT * FROM users WHERE username = ?")
            ->execute([$username])
            ->fetch(UserDTO::class);

    }


    public function getById(int $id): ?UserDTO
    {
       return $this->db->query("SELECT * FROM users WHERE id = ?")->execute([$id])->fetch(UserDTO::class);

    }

    public function edit(int $id, UserEditDTO $userEditDTO, bool $changePassword)
    {
        $query = "UPDATE users SET username = ?";
        $params = [$userEditDTO->getUsername()];
        if ($changePassword) {
            $query .= ", password = ?";
            $params[] = $userEditDTO->getNewPassword();
        }
        $query .= " WHERE id = ?";
        $params[] = $id;

        $this->db->query($query)->execute($params);
    }

    public function setPictureUrl(int $id, string $filePath)
    {
        $this->db->query("UPDATE users SET url = ? WHERE id = ?")
            ->execute([$filePath, $id]);
    }


    public function editPin(int $id,UserEditPinDTO $userEditPinDTO, bool $changePassword)
    {
        $query = "UPDATE users SET username = ?";
        $params = [$userEditPinDTO->getUsername()];
        if ($changePassword) {
            $query .= ", password = ?";
            $params[] = $userEditPinDTO->getNewPassword();
        }
        $query .= " WHERE id = ?";
        $params[] = $id;

        $this->db->query($query)->execute($params);
    }

    public function getByGuid(string $userId)
    {

        return $this->db->query("SELECT * FROM users WHERE guid = ?")->execute([$userId])->fetch(UserDTO::class);

    }

    public function allUsers()
    {
       $allUsers = $this->db->query("SELECT username, guid FROM users")->execute()->fetchAll(UserDTO::class);
        $users = [];
        foreach ($allUsers as $userDTO) {
            $username = $userDTO->getUsername();
            $guid = $userDTO->getGuid();
            $users[] = [
                'username' => $username,
                'guid' => $guid,
            ];
        }

        return $users;
    }




}