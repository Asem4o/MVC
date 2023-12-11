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
        return $this->view->render();
    }

    public function loginProcess(UserServiceInterface $userService, UserRegistrationBidingModel $model)
    {

        try {
            if ($userService->verifyCredentials($model->getUsername(), $model->getPassword())) {

                $_SESSION['id'] = $userService->findByUsername($model->getUsername())->getId();
                header("Location: profile");
                exit;
            }
        } catch (\Exception\User\LoginException $e) {
          $e= $e->getMessage();
          $usersLogin = new UsersProfileViewModel(null,null,null,null,null,$e);
          $this->view->render($usersLogin);
        }

    }

    public function register()
    {
        $this->view->render();
    }

    public function registerProcess(UserRegistrationBidingModel $bidingModel, UserServiceInterface $userService)
    {

        try {
            $userService->register($bidingModel);
            header("Location: login");
        }catch (\Exception\User\RegistrationException $e)
        {
            $e= $e->getMessage();
            $userRegister = new UsersProfileViewModel(null,null,null,null,null,$e);
            $this->view->render($userRegister);
        }


    }

    public function profile(UserServiceInterface $userService,NoteServiceInterface $noteService,NarqdServiceInterface $narqdService)
    {
        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }


        $user = $userService->findOne($_SESSION['id']);
        $id =$user->getId();
        $note = $noteService->showNotes($user->getId());
        $narqd =$narqdService->showNarqd($user->getId());
        $userProfile = new UsersProfileViewModel($id,$user->getUsername(), $user->getUrl(),$note,$narqd);
        $this->view->render($userProfile);
    }


    public function editProfilePicture()
    {

        $this->view->render();
    }

    public function changePicture(UserServiceInterface $userService)
    {

        $user = $userService->findOne($_SESSION['id']);
        $id = $user->getId();
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
                $userRegister = new UsersProfileViewModel(null,null,null,null,null,$e);
                $this->view->render($userRegister);
            }

        }
    }

    public function changePassword()
    {
        $this->view->render();
    }

    public function editPassword(UserServiceInterface $userService)
    {

        $user = $userService->findOne($_SESSION['id']);
        $id = $user->getId();
        $username = $user->getUsername();
        $oldPassword = htmlspecialchars($_POST['old']);
        $newPassword = htmlspecialchars($_POST['new']);

        try {
            $userService->edit($id, new UserEditDTO($id, $username, $oldPassword, $newPassword));
            header("Location: profile");
            exit;
        } catch (\Exception\User\LoginException $e) {
            $e= $e->getMessage();
            $userRegister = new UsersProfileViewModel(null,null,null,null,null,$e);
            $this->view->render($userRegister);
        }

    }
    public function note(){
        $this->view->render();
    }
    public function createNote(UserServiceInterface $userService , NoteServiceInterface $service){

        try {
            $user = $userService->findOne($_SESSION['id']);
            $id = $user->getId();
            $note = htmlspecialchars($_POST['note']);
            $service->create($id,$note);
            header("Location: profile");
        } catch (\Exception\User\NoteCreateException $e){
            echo $e = $e->getMessage();
        }
    }
    public  function deleteNote(NoteServiceInterface $service){

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

        $noteId =htmlspecialchars($_POST['noteId']);
        $noteId =(int)$noteId;
        $firstNoteContent =htmlspecialchars($_POST['content']);
         $user = $userService->findOne($_SESSION['id']);
         $id =$user->getId();
        $userProfile = new UsersProfileViewModel($id,$user->getUsername(), null,$firstNoteContent, $noteId);
        $this->view->render($userProfile);
    }


    public function editUserNote(NoteServiceInterface $service, UserServiceInterface $userService)
    {
        try {
            $user = $userService->findOne($_SESSION['id']);
            $userId = htmlspecialchars((int)$_POST['userId']);
            $noteId = htmlspecialchars((int)$_POST['noteId']);
            $content = htmlspecialchars($_POST['note']);
            $service->editNoteById($userId, $noteId, $content);
            header("Location: profile");
            exit();
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
            $userService->editPin($username,new UserEditPinDTO($username, $pin, $newPassword));
          header("Location: login");
            exit;
        } catch (\Exception\User\ChangePassWithPinException $e) {
            $e= $e->getMessage();
            $userRegister = new UsersProfileViewModel(null,null,null,null,null,$e);
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
            $user = $userService->findOne($_SESSION['id']);
            $id = $user->getId();
            $date =htmlspecialchars($_POST['date']);
            $dateTime = new DateTime($date);
            $formattedDate = $dateTime->format('Y-m-d');
            $hours =htmlspecialchars($_POST['hours']);

            $service->create($id,$hours,$formattedDate);
            header("Location: profile");
        } catch (\Exception\User\NarqdCreateException $e){
            echo $e =$e->getMessage();
        }
    }

    public function deletenarqd(NarqdServiceInterface $narqdService){

        try {
            $narqdId =htmlspecialchars($_POST['narqdId']);
            $userId =htmlspecialchars($_POST['deleteId']);
            $narqdService->deleteNarqdById($narqdId,$userId);
            header("Location: profile");
        }catch (\Exception\User\NarqdDeleteException $e){
            echo $e =$e->getMessage();
            header("Refresh: 2; URL=profile");
            exit;
        }

    }
    public function editNarqd(UserServiceInterface $userService){

        $narqdId =htmlspecialchars($_POST['narqdId']);
        $noteId =(int)$narqdId;
        $firstNoteContent =htmlspecialchars($_POST['content']);
        $user = $userService->findOne($_SESSION['id']);
        $id =$user->getId();
        $userProfile = new UsersProfileViewModel($id,$user->getUsername(), null,$firstNoteContent, $noteId);
        $this->view->render($userProfile);
    }
    public function editUserNarqd(NarqdServiceInterface $narqdService, UserServiceInterface $userService){
        try {
            $user = $userService->findOne($_SESSION['id']);
            $id =$user->getId();
            $narqdUserId = htmlspecialchars((int)$_POST['narqdId']);
            $content =htmlspecialchars($_POST['note']);
            $narqdService->editNarqdById($id, $narqdUserId, $content);
            header("Location: profile");
            exit();
        } catch (\Exception\User\NarqdEditException $e) {

            echo $e = $e->getMessage();
            header("Refresh: 1; URL=profile");
            exit;
        }
    }

}