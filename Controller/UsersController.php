<?php

namespace Controller;

use DateTime;
use DTO\Note;
use DTO\NoteEdit;
use DTO\RequestsModel\UserRegistrationBidingModel;
use DTO\UserDTO;
use DTO\UserEditPinDTO;
use DTO\ViewModels\ChatProfileViewModel;
use DTO\ViewModels\LiveChatProfileCiewModel;
use DTO\ViewModels\UsersLoginViewModel;
use DTO\ViewModels\UsersProfileEditViewModel;
use DTO\ViewModels\UsersProfileViewModel;
use Exception\User\EditProfileException;
use Exception\User\LoginException;
use Repositories\Chat\ChatRepositoryInterface;
use Repositories\Users\UserRepositoryInterface;
use Services\Narqd\NarqdServiceInterface;
use Services\Note\NoteServiceInterface;
use Services\Otpuska\OtpuskaServiceInterface;
use Services\Users\UserServiceInterface;
use Services\Chat\ChatServiceInterface;
use ViewEngine\ViewInterface;
use DTO\UserEditDTO;

class UsersController
{

    private $view;

    /**
     * @param $view
     */
    public function __construct(ViewInterface $view)
    {
        $this->view = $view;
    }

    public function login()
    {

        $csrfToken = generateCsrfToken();

        $userRegister = new UsersProfileViewModel(null, null, null, null, null, null, $csrfToken);

        $this->view->render($userRegister);
    }


    public function loginProcess(UserServiceInterface $userService, UserRegistrationBidingModel $model)
    {
        $csrfToken = generateCsrfToken();
        try {
            if ($userService->verifyCredentials($model->getUsername(), $model->getPassword())) {

                $_SESSION['id'] = $userService->findByUsername($model->getUsername())->getId();
                header("Location: profile");
                exit;
            }
        } catch (\Exception\User\LoginException $e) {
            $e = $e->getMessage();
            $usersLogin = new UsersProfileViewModel(null, null, null, null, null, $e, $csrfToken);
            $this->view->render($usersLogin);
        }

    }

    public function register(UserRegistrationBidingModel $bidingModel)
    {


        $csrfToken = generateCsrfToken();
        $guid = $bidingModel->getGuid();
        $userRegister = new UsersProfileViewModel(null, null, null, null, null, $csrfToken, $guid, null);
        $this->view->render($userRegister);

    }

    public function registerProcess(UserRegistrationBidingModel $bidingModel, UserServiceInterface $userService)
    {


        $csrfToken = generateCsrfToken();
        try {

            $userService->register($bidingModel);
            header("Location: login");
        } catch (\Exception\User\RegistrationException $e) {
            $errorMessage = $e->getMessage();
            $userRegister = new UsersProfileViewModel(null, null, null, null, null, $errorMessage, $csrfToken, null, null);
            $this->view->render($userRegister);

        }
    }


    public function profile(UserServiceInterface  $userService, NoteServiceInterface $noteService,
                            NarqdServiceInterface $narqdService, OtpuskaServiceInterface $otpuskaService, ChatServiceInterface $chatService)
    {
        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }

        $allUsers = new UserDTO();

        $csrfToken = generateCsrfToken();

        $user = $userService->findOne($_SESSION['id']);
        $id = $user->getGuid();
        $note = $noteService->showNotes($user->getId());
        $narqd = $narqdService->showNarqd($user->getId());
        $otpuska = $otpuskaService->showOtpuska($user->getId());
        $sender = $chatService->DisplayUsers($user->getId());
        $allUsers->setIsRead($sender);
        $stateUser = $allUsers->getIsRead();
        $userProfile = new UsersProfileViewModel($id, $user->getUsername(), $user->getUrl(), $note, $narqd, null, $csrfToken, $otpuska, null, $stateUser);

        $this->view->render($userProfile);
    }


    public function editProfilePicture()
    {
        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }
        $this->view->render();
    }

    public function changePicture(UserServiceInterface $userService)
    {

        $user = $userService->findOne($_SESSION['id']);
        $id = $user->getId();
        $csrfToken = generateCsrfToken();
        if (isset($_FILES['profile_picture'])) {
            try {
                $userService->setProfilePicture(
                    $id,
                    $_FILES['profile_picture']['tmp_name'],
                    $_FILES['profile_picture']['type'],
                    $_FILES['profile_picture']['size']
                );
                header("Location: profile");
            } catch (\Exception\User\UploadException $e) {
                $e = $e->getMessage();
                $userRegister = new UsersProfileViewModel(null, null, null, null, null, $e, $csrfToken);
                $this->view->render($userRegister);
            }

        }
    }

    public function changePassword()
    {
        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }
        $this->view->render();
    }

    public function editPassword(UserServiceInterface $userService)
    {


        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }
        $user = $userService->findOne($_SESSION['id']);
        $id = $user->getId();
        $username = $user->getUsername();
        $oldPassword = htmlspecialchars($_POST['old']);
        $newPassword = htmlspecialchars($_POST['new']);
        $csrfToken = generateCsrfToken();
        try {
            $userService->edit($id, new UserEditDTO($id, $username, $oldPassword, $newPassword));
            header("Location: profile");
            exit;
        } catch (\Exception\User\LoginException $e) {
            $e = $e->getMessage();
            $userRegister = new UsersProfileViewModel(null, null, null, null, null, $e, $csrfToken);
            $this->view->render($userRegister);
        }

    }

    public function note(NoteServiceInterface $noteService)
    {
        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }

        $this->view->render();
    }

    public function createNote(UserServiceInterface $userService, NoteServiceInterface $service)
    {

        try {
            if (isset($_POST['note'])) {
                $user = $userService->findOne($_SESSION['id']);
                $id = $user->getId();
                $note = htmlspecialchars($_POST['note']);
                $service->create($id, $note);
                header("Location: profile");
            } else {
                // Redirect logic here
                header('Location: login');
                exit();
            }
        } catch (\Exception\User\NoteCreateException $e) {
            echo $e = $e->getMessage();
        }
    }

    public function deleteNote(NoteServiceInterface $service)
    {

        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }
        try {
            if (isset($_POST['note_id']) && $_POST['deleteId']) {
                $noteID = htmlspecialchars($_POST["note_id"]);
                $userId = htmlspecialchars($_POST['deleteId']);
                $service->deleteNoteById($noteID, $userId);
                header("Location: profile");
            }
            header("Location: profile");
        } catch (\Exception\User\NoteDeleteException $e) {
            echo $e = $e->getMessage();
            header("Refresh: 2; URL=profile");
            exit;
        }
    }

    public function editNote(UserServiceInterface $userService)
    {
        if (isset($_POST['noteId']) && $_POST['content']) {
            $noteId = htmlspecialchars($_POST['noteId']);
            $firstNoteContent = htmlspecialchars($_POST['content']);
            $user = $userService->findOne($_SESSION['id']);
            $id = $user->getGuid();
            $csrfToken = generateCsrfToken();
            $userProfile = new UsersProfileViewModel($id, $user->getUsername(), null, $firstNoteContent, $noteId, null, $csrfToken);
            $this->view->render($userProfile);
        } else {

            header('Location: login');
            exit();
        }

    }

    public function editUserNote(NoteServiceInterface $service, UserServiceInterface $userService)
    {
        try {
            if (isset($_POST['userId']) && $_POST['noteId']) {
                $userId = htmlspecialchars($_POST['userId']);
                $noteId = htmlspecialchars($_POST['noteId']);
                $content = htmlspecialchars($_POST['note']);
                $service->editNoteById($userId, $noteId, $content);
                header("Location: profile");
                exit();
            } else {
                header('Location: login');
                exit();
            }

        } catch (\Exception\User\NoteEditException $e) {

            echo $e = $e->getMessage();
            header("Refresh: 1; URL=profile");
            exit;
        }
    }

    public function reset()
    {

        $this->view->render();
    }

    public function resetPin(UserServiceInterface $userService)
    {

        try {
            if (isset($_POST['username'], $_POST['pin'], $_POST['password'])) {
                $username = htmlspecialchars($_POST['username']);
                $pin = htmlspecialchars($_POST['pin']);
                $newPassword = htmlspecialchars($_POST['password']);
                $csrfToken = generateCsrfToken();
                $userService->editPin($username, new UserEditPinDTO($username, $pin, $newPassword));
                header("Location: login");
                exit;
            }
        } catch (\Exception\User\ChangePassWithPinException $e) {
            $e = $e->getMessage();
            $userRegister = new UsersProfileViewModel(null, null, null, null, null, $e, $csrfToken);
            $this->view->render($userRegister);
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: login");
    }

    public function hours()
    {
        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }

        $this->view->render();
    }

    public function createhours(UserServiceInterface $userService, NarqdServiceInterface $service)
    {

        try {
            if (isset($_POST['date']) && $_POST['hours']) {
                $user = $userService->findOne($_SESSION['id']);
                $id = $user->getGuid();
                $date = htmlspecialchars($_POST['date']);
                $dateTime = new DateTime($date);
                $formattedDate = $dateTime->format('Y-m-d');
                $hours = htmlspecialchars($_POST['hours']);

                $service->create($id, $hours, $formattedDate);
                header("Location: profile");
            } else {
                header("Location: login");
                exit();
            }

        } catch (\Exception\User\NarqdCreateException $e) {
            echo $e = $e->getMessage();
            header("Refresh: 2; URL=profile");
            exit;
        }
    }

    public function deletenarqd(NarqdServiceInterface $narqdService)
    {

        try {
            if (isset($_POST['narqdId']) && $_POST['deleteId']) {
                $narqdId = htmlspecialchars($_POST['narqdId']);
                $userId = htmlspecialchars($_POST['deleteId']);
                $narqdService->deleteNarqdById($narqdId, $userId);

                header("Location: profile");
            } else {
                header('Location: login');
                exit();
            }

        } catch (\Exception\User\NarqdDeleteException $e) {
            echo $e = $e->getMessage();
            header("Refresh: 2; URL=profile");
            exit;
        }

    }

    public function editNarqd(UserServiceInterface $userService)
    {
        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }
        if (isset($_POST['narqdId']) && $_POST['content']) {
            $narqdId = htmlspecialchars($_POST['narqdId']);
            $firstNoteContent = htmlspecialchars($_POST['content']);
            $user = $userService->findOne($_SESSION['id']);
            $csrfToken = generateCsrfToken();
            $id = $user->getGuid();
            $userProfile = new UsersProfileViewModel($id, $user->getUsername(), null,
                $firstNoteContent, $narqdId, null, $csrfToken);
            $this->view->render($userProfile);
        } else {
            header('Location: login');
            exit();
        }

    }

    public function editUserNarqd(NarqdServiceInterface $narqdService, UserServiceInterface $userService)
    {
        try {
            if (!isset($_SESSION['id'])) {
                header("Location: login");
                exit;
            }
            if (isset($_POST['narqdId'])) {
                $user = $userService->findOne($_SESSION['id']);
                $id = $user->getId();
                $narqdUserId = htmlspecialchars($_POST['narqdId']);

                $content = htmlspecialchars($_POST['note']);
                $narqdService->editNarqdById($id, $narqdUserId, $content);
                header("Location: profile");
                exit();
            } else {
                header('Location: login');
                exit();
            }

        } catch (\Exception\User\NarqdEditException $e) {

            echo $e = $e->getMessage();
            header("Refresh: 1; URL=profile");
            exit;
        }
    }

    public function otpuska()
    {
        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }
        $this->view->render();
    }

    public function editOtpusk(UserServiceInterface $userService, OtpuskaServiceInterface $otpuskaService)
    {
        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['changesArray'])) {
                $changesArray = json_decode($_POST['changesArray'], true);

                foreach ($changesArray as $change) {
                    $otpuskaId = $change['compensationId'];
                    $text = $change['updatedDays'];
                    $days = (int)$text;
                    $users = $userService->findOne($_SESSION['id']);
                    $usersId = $users->getId();
                    if ($days == 0) {
                        $otpuskaService->deleteOtpuska($otpuskaId, $usersId);
                        header("Location: profile");
                        exit();
                    }

                    $otpuskaService->editOtpuskaById($usersId, $otpuskaId, $text);
                }
                header("Location: profile");
                exit();
            }
        }
    }


    public function createOtpuska(UserServiceInterface $userService, OtpuskaServiceInterface $otpuskaService)
    {
        $csrfToken = generateCsrfToken();
        try {
            if (!isset($_SESSION['id'])) {
                header("Location: login");
                exit;
            }
            if (isset($_POST['days']) && $_POST['date']) {
                $user = $userService->findOne($_SESSION['id']);
                $id = $user->getId();
                $date = htmlspecialchars($_POST['date']);
                $days = htmlspecialchars($_POST['days']);
                $otpuskaService->create($id, $days, $date);
                header("Location: profile");
                exit();
            }
        } catch (\Exception\User\OtpuskaCreateException $e) {
            $e = $e->getMessage();
            $userRegister = new UsersProfileViewModel(null, null, null, null, null, $e, $csrfToken);
            $this->view->render($userRegister);
        }

    }

    public function chat(UserServiceInterface $userService, ChatServiceInterface $chatService)
    {

        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }
        $allUsers = $userService->allUsers();
        $currentUser = $_SESSION['id'];
        $isRead = $chatService->DisplayUsers($currentUser);
        $newMessageUsers = $chatService->getSender($currentUser);
        $currUsername = $userService->findOne($currentUser);
        $name = $currUsername->getUsername();
        $showAllUsers = new ChatProfileViewModel($name, null, $allUsers, null, $isRead, $newMessageUsers);
        $this->view->render($showAllUsers);
    }


    public function send(ChatServiceInterface $chatService, UserServiceInterface $userService)
    {
        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }
        try {

            if (isset($_POST['username'], $_POST['guid'], $_SESSION['id'])) {
                $username = htmlspecialchars($_POST['username']);
                $receivedGuid = htmlspecialchars($_POST['guid']);
                $sender = $_SESSION['id'];
                $receivedMessages = $chatService->getMessagesBetweenUsers($sender, $receivedGuid);
                $sendMessage = new ChatProfileViewModel($username, $receivedMessages, null, null, null, null, $receivedGuid);
              //  $this->view->render($sendMessage);
            }

        } catch (\Exception\User\ChatException $e) {

            echo $e = $e->getMessage();
            header("Refresh: 1; URL=chat");
            exit;
        }

    }

    public function chatUsers(ChatServiceInterface $chatService, UserServiceInterface $userService)
    {
        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }
        try {
            if (isset($_POST['username'], $_POST['guid'], $_POST['content'], $_SESSION['id'])) {
                $username = htmlspecialchars($_POST['username']);
                $receivedGuid = htmlspecialchars($_POST['guid']);
                $content = htmlspecialchars($_POST['content']);
                $sender = $_SESSION['id'];

                $newMessageUsers = $chatService->getSender($sender);

                $chatService->createMessage($sender, $receivedGuid, $content);

                $receivedMessages = $chatService->getMessagesBetweenUsers($sender, $receivedGuid);
                $allUsers = $userService->allUsers();
                $sendMessage = new ChatProfileViewModel($username, $receivedMessages, $allUsers, null, $newMessageUsers, null, $receivedGuid);
                $this->view->render($sendMessage);

            }
        } catch (\Exception\User\ChatException $e) {
            $allUsers = $userService->allUsers();
            $e = $e->getMessage();
            $sendMessage = new ChatProfileViewModel(null, null, $allUsers, $e,);
            $this->view->render($sendMessage);
        }
    }
    public function newChat(UserServiceInterface $userService,ChatServiceInterface $chatService,UserRepositoryInterface $userRepository)
    {
        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }
        try {

            $selectedUsername = $_POST['username'];
            $cmd = $userService->findByUsername($selectedUsername);
            $reciverId = $cmd->getId();
            $recivedGuid = $cmd->getGuid();
            $pic = $cmd->getUrl();
            $sender =$_SESSION['id'];

            $recivedMessage = $chatService->getMessagesBetweenUsers($reciverId,$sender);
            $liveChat = new LiveChatProfileCiewModel($selectedUsername,$recivedGuid ,$pic,null,$recivedMessage);

            $this->view->render($liveChat);
        } catch (\Exception\User\ChatException $e){
            echo $e = $e->getMessage();
            header("Refresh: 1; URL=chat");
            exit;

        }

    }
    public function insertChat(ChatServiceInterface $chatService,UserRepositoryInterface $userRepository)
    {
        $currEntId = $_SESSION['id'];
        $messages = htmlspecialchars($_POST['message']) ;
        $toSend = htmlspecialchars($_POST['to_id']);
        $findByGuid = $userRepository->getByGuid($toSend);
        $toSendUser = $findByGuid->getId();
       $chatService->createMessage($currEntId,$toSendUser,$messages);


    }

}