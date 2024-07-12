<?php
namespace deckbuilder_archive_php_version_only\api\controller;
use deckbuilder_archive_php_version_only\api\DTOs\StateDTO;
use deckbuilder_archive_php_version_only\api\gateways\ReadUserFromDBGateway;
use deckbuilder_archive_php_version_only\api\views\JsonView;

class UserAccountController
{
    private $jsonView;
    private $accountGateway;

    public function __construct(){
        $this->jsonView = new JsonView();
        $this->accountGateway = new ReadUserFromDBGateway(DBHost,DBName,DBUsername,DBPasword);
    }

    public function route(){
        $action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
        switch(strtolower($action)){
            case 'createarchiver':
                $emailInput = filter_input(INPUT_GET, "mailadress", FILTER_SANITIZE_EMAIL);
                $userNamInput = filter_input(INPUT_GET,"username",FILTER_SANITIZE_STRING);
                $passwordInput = filter_input(INPUT_GET,"password",FILTER_SANITIZE_STRING);
                $confirmPasswordInput = filter_input(INPUT_GET,"confirm",FILTER_SANITIZE_STRING);
                if($passwordInput !== $confirmPasswordInput){
                    $errorM = "Please make sure to verify your password";
                    $this->jsonView->display($errorM);
                }else{
                    $this->createNewArchiver($emailInput, $userNamInput, $passwordInput);
                }
                break;
            case 'loginarchiver':
                $emailInput = filter_input(INPUT_GET,"mailadress",FILTER_SANITIZE_EMAIL);
                $passwordInput = filter_input(INPUT_GET,"password",FILTER_SANITIZE_STRING);
                if($emailInput && $passwordInput){
                    $state = $this->validateUserLogin($emailInput, $passwordInput);
                    $this->returnState($state);
                }
                break;
            case 'logoutarchiver':
                $state = $this->disconnectUser();
                $this->returnState($state);
                break;
            case 'getarchiver':
                $userMail = $this->checkForAccessLegality();
                if($userMail !== null){
                    $this->jsonView->display($userMail);
                }
                break;
            case 'updatearchivermail':
                $newEmailInput = filter_input(INPUT_GET, "newmailadress", FILTER_SANITIZE_EMAIL);
                $legalityCheck = $this->checkForAccessLegality();
                if($legalityCheck !== null){
                    $this->updateMailAdress($legalityCheck, $newEmailInput);
                }
                break;
            case 'updatearchivername':
                $newNameInput = filter_input(INPUT_GET, "newusername", FILTER_SANITIZE_STRING);
                $legalityCheck = $this->checkForAccessLegality();
                if($legalityCheck !== null){
                    $this->updateUserName($legalityCheck, $newNameInput);
                }
                break;
            case 'updatearchiverpassword':
                $newPasswordInput = filter_input(INPUT_GET, "newpassword", FILTER_SANITIZE_STRING);
                $legalityCheck = $this->checkForAccessLegality();
                if($legalityCheck !== null){
                    $this->updateMailAdress($legalityCheck, $newPasswordInput);
                }
                break;
            case 'deletearchiver':
                $confirmPasswordInput = filter_input(INPUT_GET, "password", FILTER_SANITIZE_STRING);
                $legalityCheck = $this->checkForAccessLegality();
                $checkForDeletion = $this->checkForDeletion($legalityCheck, $confirmPasswordInput);
                if($legalityCheck !== null && $checkForDeletion == true){
                    $this->terminateArchiveuser($legalityCheck);
                }
                break;
            default:
            $errorM = "Unknown Action";
            $this->jsonView->display($errorM);                                
        }
    }
    private function checkForDeletion($mailAdress, $confirmPassword){
        $userData = $this->accountGateway->getUserByMailAdress($mailAdress);
        if(password_verify($confirmPassword, $userData->user_password)){
            return true;
        }else{
            return false;
        }
    }
    private function checkForAccessLegality(){
        if(isset($_SESSION['user'])){
            $user = unserialize($_SESSION['user']);
            $userId = $user['user_id'];
            $userData = $this->accountGateway->getUserByID($userId);
            $legalMailAdress = $userData->mail_adress;
            return $legalMailAdress;
        }else{
            $errorM = "You need to be logged in to change your credentials";
            $this->jsonView->display($errorM);
        }
    }
    private function checkForExistingDBEntries($mailAdress){
        $dbData = $this->accountGateway->getUserByMailAdress($mailAdress);
        return $dbData; 
    }    
    private function createNewArchiver($mailAdress, $userName, $password){
        $checkingForDuplicates = $this->checkForExistingDBEntries($mailAdress);
        if($checkingForDuplicates !== null){
            $errorM = "This archiver allready exists, please choose a different mail adress.";
            $this->jsonView->display($errorM);
        }else{
            $this->accountGateway->createArchiveUser($mailAdress, $userName, $password);
            $this->jsonView->display("New User: ".$mailAdress." ".$userName." has been created succesfully.");
        }
    }
    private function validateUserLogin($mailAdres, $password){
        if(!isset($_SESSION['user'])){
            $userlogin = $this->accountGateway->getUserByMailAdress($mailAdres);
            if(password_verify($password, $userlogin->user_password)){
                $userToken = array(
                    'user_id' => $userlogin->user_id,
                    'user_name' => $userlogin->archive_name,
                );
                $_SESSION['user'] = serialize($userToken);
                return "OK";
            }else{
                return "ERROR";
            }
        }
    }
    private function disconnectUser(){
        if(isset($_SESSION['user'])){
            $_SESSION['user'] = [];
            session_destroy()->$_SESSION['user'];
            return "OK";
        }else{
            return "ERROR";
        }
    }
    public function updateUserPassword($emailInput,$newPassword) {
        $success = $this->accountGateway->upadteUserPasswordByMailAdress($emailInput, $newPassword);
    
        if ($success) {
            $this->jsonView->display("Password for Archiver with email ". $emailInput ." updated successfully");
        } else {
            $this->jsonView->display("Failed to update password for user with email ".$emailInput);
        }
    }
    public function updateUserName($emailInput,$newUserName) {
        $success = $this->accountGateway->updateArchiverNameByMailAdress($emailInput, $newUserName);
    
        if ($success) {
            $this->jsonView->display("Archive Name for Archiver with email ". $emailInput ." updated successfully");
        } else {
            $this->jsonView->display("Failed to update user name for user with email ".$emailInput);
        }
    }
    public function updateMailAdress($emailInput,$newMailAdress) {
        $success = $this->accountGateway->updateMailAdressByMailAdress($emailInput, $newMailAdress);
    
        if ($success) {
            $this->jsonView->display("Mail Adress for Archiver with email ". $emailInput ." updated successfully");
        } else {
            $this->jsonView->display("Failed to update mail adress for user with email ".$emailInput);
        }
    }
    private function terminateArchiveuser($mailAdress){
        $succes = $this->accountGateway->deleteArchiveUser($mailAdress);
        if($succes){ 
            $this->jsonView->display("Data successfully deleted");
        }else{
            $this->jsonView->display("No Data found for termination");
        }
    }
    private function returnState($state){
        $stateDTO = new StateDTO();
        $stateDTO->state = $state;
        $this->jsonView->display($stateDTO);
    }
}