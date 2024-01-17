<?php

namespace Services\Users;



//use Data\Users\UserEditDTO;

use DTO\RequestsModel\UserRegistrationBidingModel;
use DTO\UserDTO;
use DTO\UserEditDTO;
use DTO\UserEditPinDTO;
use Exception\User\EditProfileException;
use Exception\User\RegistrationException;
use Exception\User\UploadException;

interface UserServiceInterface
{

    public function register(UserRegistrationBidingModel $userDTO);
    public function edit(int $id, UserEditDTO $userDTO): void;
    public function editPin(string $username,UserEditPinDTO $userDTO): void;

    public function verifyCredentials(string $username, string $password): bool;

    public function findByUsername(string $username): UserDTO;

    public function findOne(int $id): UserDTO;

    public function setProfilePicture(int $id, string $tempName, string $type, int $size);

    public function allUsers(): array;

}