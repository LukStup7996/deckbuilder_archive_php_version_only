<?php
namespace deckbuilder_archive_php_version_only\api\controller;
use deckbuilder_archive_php_version_only\api\services\DeckArchiveService;
use deckbuilder_archive_php_version_only\api\views\JsonView;
use deckbuilder_archive_php_version_only\api\services\DeckBuilderService;
use deckbuilder_archive_php_version_only\api\DTOs\OwnedDeckDTO;
class DeckbuilderController
{
    private $jsonView;
    private $deckBuilderService;
    private $deckArchiveService;

    public function __construct(){
        $this->jsonView = new JsonView();
        $this->deckBuilderService = new DeckBuilderService();
        $this->deckArchiveService = new DeckArchiveService();
    }

    public function route(){
        $action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
        switch(strtolower($action)){
            case 'createdeck':
                $deckNameInput = filter_input(INPUT_GET, "deckname", FILTER_SANITIZE_STRING);
                $formatInput = filter_input(INPUT_GET, "format", FILTER_SANITIZE_STRING);
                $this->createNewDecklist($deckNameInput, $formatInput);
                break;
            case 'addcard':
            case 'removecard':
            case 'updatedeck':
            case 'selectdeck':
                $getDeckId = filter_input(INPUT_GET, "deckid", FILTER_SANITIZE_NUMBER_INT);
                $this->verifyDeckLegalityForArchiver($getDeckId);
                break;
            case 'deletedeck':
                $getDeckId = filter_input(INPUT_GET,"deckid",FILTER_SANITIZE_STRING);
                $confirmTermination = filter_input(INPUT_GET, "confirm", FILTER_SANITIZE_STRING);
                $this->deleteDecklist($getDeckId, $confirmTermination);
                break;
            case 'displaydeckcontent':
                $this->deckBuilderEndcap();
                break;
            default:
            $errorM = "Unknown Action";
            $this->jsonView->display($errorM);                                
        }
    }
    private function checkForLegality(){
        if(isset($_SESSION['user'])){
            return true;
        }else{
            return false;
        }
    }
    private function createNewDecklist($deckName, $format){
        $legalityCheck = $this->checkForLegality();
        if($legalityCheck == true){
            $userId = $_SESSION['user']['user_id'];
            $newDeckList = $this->deckBuilderService->createDecklist($userId, $deckName, $format);
            $this->setSessionId($newDeckList);
        }else{
            $errorM = "You need to be logged in in order to use our services.";
            $this->jsonView->display($errorM);
        }
    }
    private function verifyDeckLegalityForArchiver($deckIdInput){
        if($this->checkForLegality() !== true){
            $errorM = "You need to be logged in, in order to use our services.";
            $this->jsonView->display($errorM);
            return;
        }
        $userToken = $_SESSION['user']['user_id'];
        $listOfOwnedDecks = $this->deckArchiveService->checkForUserCreatedDBContent($userToken);
        $dtoList = [];
        foreach ($listOfOwnedDecks as $owned) {
            $dtoList [] = OwnedDeckDTO::map($owned);
        }
        $belongsToUser = false;
        foreach($dtoList as $ownedDecklist){
            if($ownedDecklist->deckId == $deckIdInput) {
                $belongsToUser = true;
                break;
            }
        }
        if($belongsToUser){
            $this->setSessionId($deckIdInput);
        }else{
            $errorM = "No deck by your chosen ID could be affiliated to your user.";
            $this->jsonView->display($errorM);
        }
    }
    private function setSessionId($deckId){
        $_SESSION['deck'] = $deckId;
        $successM = "You have successfully selected your deck: ".$_SESSION['deck'];
        $this->jsonView->display($successM);
    }
    private function deleteDecklist($deckId, $confirmTermination){
        if($confirmTermination == "Yes" && $_SESSION['deck'] == $deckId){
            $this->deckBuilderService->deleteDecklistEntry($deckId);
            $successM = "Successfully deleted decklist.";
            $this->jsonView->display($successM);
        }else{
            $errorM = "There has been an issue with deleteing your decklist";
            $this->jsonView->display($errorM);
        }
    }

    private function deckBuilderEndcap(){
        $succesM = "you have successfully accessed deckbuilding services";
        $this->jsonView->display($succesM);
    }
}