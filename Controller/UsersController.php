<?php

namespace Controller;

use DateTime;
use DTO\Note;
use DTO\NoteEdit;
use DTO\RequestsModel\UserRegistrationBidingModel;
use DTO\UserDTO;
use DTO\UserEditPinDTO;
use DTO\ViewModels\UsersLoginViewModel;
use DTO\ViewModels\UsersProfileEditViewModel;
use DTO\ViewModels\UsersProfileViewModel;
use Exception\User\EditProfileException;
use Exception\User\LoginException;
use http\Client\Curl\User;
use mysql_xdevapi\Exception;
use Services\Narqd\NarqdServiceInterface;
use Services\Note\NoteServiceInterface;
use Services\Otpuska\OtpuskaServiceInterface;
use Services\Users\UserServiceInterface;
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
          $e= $e->getMessage();
          $usersLogin = new UsersProfileViewModel(null,null,null,null,null,$e ,$csrfToken );
          $this->view->render($usersLogin);
        }

    }

    public function register()
    {


        $csrfToken = generateCsrfToken();

        $userRegister = new UsersProfileViewModel(null, null, null, null, null, null, $csrfToken);
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
            $userRegister = new UsersProfileViewModel(null, null, null, null, null, $errorMessage,$csrfToken);
            $this->view->render($userRegister);

        }
    }


    public function profile(UserServiceInterface $userService,NoteServiceInterface $noteService,
                            NarqdServiceInterface $narqdService,OtpuskaServiceInterface $otpuskaService)
    {

        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }
        $csrfToken = generateCsrfToken();

        $user = $userService->findOne($_SESSION['id']);
        $id =$user->getId();
        $note = $noteService->showNotes($user->getId());
        $narqd =$narqdService->showNarqd($user->getId());
        $otpuska = $otpuskaService->showOtpuska($user->getId());


        $userProfile = new UsersProfileViewModel($id,$user->getUsername(), $user->getUrl(),$note,$narqd,null,$csrfToken,$otpuska);
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
                $e= $e->getMessage();
                $userRegister = new UsersProfileViewModel(null,null,null,null,null,$e,$csrfToken);
                $this->view->render($userRegister);
            }

        }
    }

    public function changePassword()
    {     if (!isset($_SESSION['id'])) {
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
            $e= $e->getMessage();
            $userRegister = new UsersProfileViewModel(null,null,null,null,null,$e,$csrfToken);
            $this->view->render($userRegister);
        }

    }
    public function note(){
        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }
        $this->view->render();
    }
    public function createNote(UserServiceInterface $userService , NoteServiceInterface $service){

        try {
            if (isset($_POST['note'])){
                $user = $userService->findOne($_SESSION['id']);
                $id = $user->getId();
                $note = htmlspecialchars($_POST['note']);
                $service->create($id,$note);
                header("Location: profile");
            }else {
                // Redirect logic here
                header('Location: login');
                exit();
            }
        } catch (\Exception\User\NoteCreateException $e){
            echo $e = $e->getMessage();
        }
    }
    public  function deleteNote(NoteServiceInterface $service){

        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }
        try {
            $noteID = htmlspecialchars($_POST["note_id"]);
            $userId = htmlspecialchars($_POST['deleteId']);

            $service->deleteNoteById($noteID,$userId);
           header("Location: profile");
        }catch (\Exception\User\NoteDeleteException $e){
            echo $e =$e->getMessage();
            header("Refresh: 2; URL=profile");
            exit;
        }
    }
    public function editNote(UserServiceInterface $userService) {
        if (isset($_POST['noteId']) && $_POST['content']) {
            $noteId = htmlspecialchars($_POST['noteId']);
            $noteId = (int) $noteId;
            $firstNoteContent = htmlspecialchars($_POST['content']);
            $user = $userService->findOne($_SESSION['id']);
            $id = $user->getId();
            $csrfToken = generateCsrfToken();
            $userProfile = new UsersProfileViewModel($id, $user->getUsername(), null, $firstNoteContent, $noteId,null,$csrfToken);
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
                $user = $userService->findOne($_SESSION['id']);
                $userId = htmlspecialchars((int) $_POST['userId']);
                $noteId = htmlspecialchars((int) $_POST['noteId']);
                $content = htmlspecialchars($_POST['note']);
                $service->editNoteById($userId, $noteId, $content);
                header("Location: profile");
                exit();
            }else{
                header('Location: login');
                exit();
            }

        } catch (\Exception\User\NoteEditException $e) {

            echo $e = $e->getMessage();
            header("Refresh: 1; URL=profile");
            exit;
        }
    }
    public function reset(){

        $this->view->render();
    }

    public function resetPin(UserServiceInterface $userService){

        try {
            $username = htmlspecialchars($_POST['username']);
            $pin =htmlspecialchars($_POST['pin']);
            $newPassword =htmlspecialchars($_POST['password']);
            $csrfToken = generateCsrfToken();
            $userService->editPin($username,new UserEditPinDTO($username, $pin, $newPassword));
          header("Location: login");
            exit;
        } catch (\Exception\User\ChangePassWithPinException $e) {
            $e= $e->getMessage();
            $userRegister = new UsersProfileViewModel(null,null,null,null,null,$e,$csrfToken);
            $this->view->render($userRegister);
        }
    }
    public function logout(){
        session_destroy();
        header("Location: login");
    }
    public function hours(){

        $this->view->render();
    }

    public function createhours(UserServiceInterface $userService , NarqdServiceInterface $service){

        try {
            if (isset($_POST['date']) && $_POST['hours']){
                $user = $userService->findOne($_SESSION['id']);
                $id = $user->getId();
                $date =htmlspecialchars($_POST['date']);
                $dateTime = new DateTime($date);
                $formattedDate = $dateTime->format('Y-m-d');
                $hours =htmlspecialchars($_POST['hours']);

                $service->create($id,$hours,$formattedDate);
                header("Location: profile");
            }else{
                header("Location: login");
                exit();
            }

        } catch (\Exception\User\NarqdCreateException $e){
            echo $e =$e->getMessage();
            header("Refresh: 2; URL=profile");
            exit;
        }
    }

    public function deletenarqd(NarqdServiceInterface $narqdService){

        try {
            if (isset($_POST['narqdId']) && $_POST['deleteId']){
                $narqdId =htmlspecialchars($_POST['narqdId']);
                $userId =htmlspecialchars($_POST['deleteId']);
                $narqdService->deleteNarqdById($narqdId,$userId);
                header("Location: profile");
            }else{
                header('Location: login');
                exit();
            }

        }catch (\Exception\User\NarqdDeleteException $e){
            echo $e =$e->getMessage();
            header("Refresh: 2; URL=profile");
            exit;
        }

    }
    public function editNarqd(UserServiceInterface $userService){

        if (isset($_POST['narqdId']) && $_POST['content']) {
            $narqdId = htmlspecialchars($_POST['narqdId']);
            $noteId = (int) $narqdId;
            $firstNoteContent = htmlspecialchars($_POST['content']);
            $user = $userService->findOne($_SESSION['id']);
            $csrfToken = generateCsrfToken();
            $id = $user->getId();
            $userProfile = new UsersProfileViewModel($id, $user->getUsername(), null,
                $firstNoteContent, $noteId,null,$csrfToken);
            $this->view->render($userProfile);
        } else {
            header('Location: login');
            exit();
        }

    }
    public function editUserNarqd(NarqdServiceInterface $narqdService, UserServiceInterface $userService){
        try {
            if (isset($_POST['narqdId'])){
                $user = $userService->findOne($_SESSION['id']);
                $id =$user->getId();
                $narqdUserId = htmlspecialchars((int)$_POST['narqdId']);


                $content =htmlspecialchars($_POST['note']);

                $narqdService->editNarqdById($id, $narqdUserId, $content);
                header("Location: profile");exit();
            }else{
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
        $this->view->render();
    }
    public function editOtpusk(UserServiceInterface $userService, OtpuskaServiceInterface $otpuskaService)
    {
        var_dump("gg");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['changesArray'])) {
                $changesArray = json_decode($_POST['changesArray'], true);

                foreach ($changesArray as $change) {
                    $otpuskaId = $change['compensationId'];
                    $text = $change['updatedDays'];
                    $days =(int)$text;
                    $users = $userService->findOne($_SESSION['id']);
                    $usersId = $users->getId();
                   if ($days ==0){
                      $otpuskaService->deleteOtpuska($otpuskaId,$usersId);
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


    public function createOtpuska(UserServiceInterface $userService , OtpuskaServiceInterface $otpuskaService)
    {
        if (isset($_POST['days']) && $_POST['date']) {
            $user = $userService->findOne($_SESSION['id']);
            $id = $user->getId();
            $date = htmlspecialchars($_POST['date']);
            $days = htmlspecialchars($_POST['days']);
            $otpuskaService->create($id,$days,$date);
            //header("Location: profile");
           // exit();
        }
    }
}