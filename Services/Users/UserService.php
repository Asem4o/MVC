<?php

namespace Services\Users;



use DTO\RequestsModel\UserRegistrationBidingModel;
use DTO\UserDTO;
use DTO\UserEditPinDTO;
use Exception\User\ChangePassWithPinException;
use Exception\User\ChatException;
use Exception\User\EditProfileException;
use Exception\User\LoginException;
use Exception\User\RegistrationException;
use Exception\User\UploadException;
use Repositories\Users\UserRepositoryInterface;
use Services\Encryption\EncryptionServiceInterface;
use DTO\UserEditDTO;
class UserService implements UserServiceInterface
{
    const MIN_USER_LENGTH = 5;
    const MAX_ALLOWED_SIZE = 30000000;
    const ALLOWED_IMAGE_PREFIX = 'image/';

    private $userRepository;

    private $encryptionService;

    public function __construct(UserRepositoryInterface $userRepository, EncryptionServiceInterface $encryptionService)
    {
        $this->userRepository = $userRepository;
        $this->encryptionService = $encryptionService;
    }


    public function register(UserRegistrationBidingModel $userDTO)
    {


        if ($userDTO->getPassword() != $userDTO->getConfirmPassword()) {
            throw new RegistrationException("Password mismatch");
        }

        if (strlen($userDTO->getUsername()) < self::MIN_USER_LENGTH) {
            throw new RegistrationException("User length too short");
        }
        $existingUser = $this->userRepository->getByUsername($userDTO->getUsername());

        if ($existingUser && $existingUser->getUsername() == $userDTO->getUsername()) {
            throw new RegistrationException("User already exists");
        }


        $passwordHash = password_hash($userDTO->getPassword(), PASSWORD_ARGON2I);
        $userDTO->setPassword($passwordHash);

        $this->userRepository->register($userDTO);
    }

    /**
     * @throws LoginException
     * @throws EditProfileException
     */
    public function edit(int $id, UserEditDTO $userDTO): void
    {
        $user = $this->userRepository->getById($id);
        $changePassword = false;
        if ($userDTO->getOldPassword() && $userDTO->getNewPassword()) {
            if (!$this->verifyCredentials($user->getUsername(), $userDTO->getOldPassword())) {
                throw new EditProfileException('Password mismatch');
            }
            $changePassword = true;
        }

        if ($changePassword) {
            $userDTO->setNewPassword(
                $this->encryptionService->hash($userDTO->getNewPassword())
            );
        }

        $this->userRepository->edit($id, $userDTO, $changePassword);
    }


    public function verifyCredentials(string $username, string $password): bool
    {
        $user = $this->userRepository->getByUsername($username);
        if ($user === null) {
            throw new LoginException("not found user");
        }
        if (!$this->encryptionService->verify($password, $user->getPassword())) {
            throw new LoginException("pass miss match");

        }
        return $this->encryptionService->verify($password, $user->getPassword());
    }

    public function findByUsername(string $username): UserDTO
    {
        if ($username == null){
            throw new ChatException('select user');
        }
        return $this->userRepository->getByUsername($username);
    }

    public function findOne(int $id): UserDTO
    {

        return $this->userRepository->getById($id);
    }

    public function setProfilePicture(int $id, string $tempName, string $type, int $size)
    {
        if (strpos($type, self::ALLOWED_IMAGE_PREFIX) !== 0) {
            throw new UploadException("Invalid image type");
        }

        if ($size >= self::MAX_ALLOWED_SIZE) {
            throw new UploadException("Image too big");
        }


        $filePath = 'public/images/' . uniqid('profile_') . '.' . explode("/", $type)[1];

        if (!move_uploaded_file(
            $tempName,
            $filePath
        )) {
            throw new UploadException("Error uploading file");
        }

        $this->userRepository->setPictureUrl($id, $filePath);
    }


    public function editPin(string $username, UserEditPinDTO $userEditPinDTO): void
    {
        $userPin = $this->userRepository->getByUsername($username);

        $changePassword = true;
        if ($userPin===null){
            $changePassword =false;
            throw new ChangePassWithPinException("not found user");

        }
        $userPinFromBase = $userPin->getPin();
        $currentPin = $userEditPinDTO->getPin();
        if ($userPinFromBase !=$currentPin){
            $changePassword =false;
            throw new ChangePassWithPinException("wrong pin");
        }
        $id = $userPin->getId();
        if ($changePassword) {
            $userEditPinDTO->setNewPassword(
                $this->encryptionService->hash($userEditPinDTO->getNewPassword())
            );
        }

        $this->userRepository->editPin($id, $userEditPinDTO, $changePassword);

    }

    public function allUsers(): array
    {

     $allusers = $this->userRepository->allUsers();
     return $allusers;
    }


}
