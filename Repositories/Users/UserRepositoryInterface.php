<?php

namespace Repositories\Users;

use DTO\UserEditDTO;
use DTO\RequestsModel\UserRegistrationBidingModel;
use DTO\UserDTO;
use DTO\UserEditPinDTO;

interface UserRepositoryInterface
{
    public function register(UserRegistrationBidingModel $model);

    public function getByUsername(string $username): ?UserDTO;

    public function getById(int $id): ?UserDTO;

    public function edit(int $id, UserEditDTO $userEditDTO, bool $changePassword);
    public function editPin(int $id,UserEditPinDTO $userEditDTO, bool $changePassword);

    public function setPictureUrl(int $id, string $filePath);

    public function getByGuid(string $userId);

    public function allUsers();


}