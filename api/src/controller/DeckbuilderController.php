<?php
namespace deckbuilder_archive_php_version_only\api\controller;
use deckbuilder_archive_php_version_only\api\services\DeckArchiveService;
use deckbuilder_archive_php_version_only\api\services\CardArchiveService;
use deckbuilder_archive_php_version_only\api\views\JsonView;
use deckbuilder_archive_php_version_only\api\services\DeckBuilderService;
use deckbuilder_archive_php_version_only\api\DTOs\OwnedDeckDTO;
class DeckbuilderController
{
    private $jsonView;
    private $deckBuilderService;
    private $deckArchiveService;
    private $cardArchiveService;

    public function __construct(){
        $this->jsonView = new JsonView();
        $this->deckBuilderService = new DeckBuilderService();
        $this->deckArchiveService = new DeckArchiveService();
        $this->cardArchiveService = new CardArchiveService();
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
                $addCardById = filter_input(INPUT_GET, "cardid", FILTER_SANITIZE_STRING);
                $defineSideBoard = filter_input(INPUT_GET, "sideboard", FILTER_SANITIZE_STRING);
                $defindeMaybeBoard = filter_input(INPUT_GET, "maybeboard", FILTER_SANITIZE_STRING);
                $this->handleAddFunction($addCardById, $defineSideBoard, $defindeMaybeBoard);
                break;
            case 'removecard':
                $addCardById = filter_input(INPUT_GET, "cardid", FILTER_SANITIZE_STRING);
                $defineSideBoard = filter_input(INPUT_GET, "sideboard", FILTER_SANITIZE_STRING);
                $defindeMaybeBoard = filter_input(INPUT_GET, "maybeboard", FILTER_SANITIZE_STRING);
                $this->handleRemoveFunction($addCardById, $defineSideBoard, $defindeMaybeBoard);
                break;
            case 'updatedeck':
                $this->updateDeckContents();
                break;
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
                $this->displayDeckContents();
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
        $this->clearExistingSessions();
        $_SESSION['deck'] = $deckId;
        $this->fillSessionContent($deckId);
        $successM = "You have successfully selected your deck: ".$_SESSION['deck'];
        $this->jsonView->display($successM);
    }
    private function fillSessionContent($deckId){
        $this->setMainBoardContent($deckId);
        $this->setSideBoardContent($deckId);
        $this->setMaybeBoardContent($deckId);
    }
    private function setMainBoardContent($deckId){
        $mainDeckContents = $this->deckArchiveService->displayMainDeckContent($deckId);
        $_SESSION['mainboard'] = array();
        foreach($mainDeckContents as $card){
            $cardId = $card->cardId;
            $quantity = $card->quantity;       
            if (!isset($_SESSION['mainboard'][$cardId])) {
                $_SESSION['mainboard'][$cardId] = array();
            }
            $_SESSION['mainboard'][$cardId] = array(
                'card_id' => $cardId,
                'quantity' => $quantity
            );
        }
    }
    private function setSideBoardContent($deckId){
        $sideBoardContents = $this->deckArchiveService->displaySideBoardContent($deckId);
        $_SESSION['side'] = array();
        foreach($sideBoardContents as $card){
            $cardId = $card->cardId;
            $quantity = $card->quantity;
            if (!isset($_SESSION['side'][$cardId])) {
                $_SESSION['side'][$cardId] = array();
            }
            $_SESSION['side'][$cardId] = array(
                'card_id' => $cardId,
                'quantity' => $quantity
            );
        }
    }
    private function setMaybeBoardContent($deckId){
        $maybeBoardContents = $this->deckArchiveService->displayMaybeBoardContent($deckId);
        $_SESSION['maybe'] = array();
        foreach($maybeBoardContents as $card){
            $cardId = $card->cardId;
            $quantity = $card->quantity;
            if (!isset($_SESSION['maybe'][$cardId])) {
                $_SESSION['maybe'][$cardId] = array();
            }
            $_SESSION['maybe'][$cardId] = array(
                'card_id' => $cardId,
                'quantity' => $quantity
            );
        }
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

    public function handleAddFunction($cardId, $sideBoard, $maybeBoard) {
        if (!in_array($sideBoard, ["Yes", "No"]) || !in_array($maybeBoard, ["Yes", "No"])) {
            $errorM = "Invalid sideboard or maybeboard value";
            $this->jsonView->display($errorM);
            return;
        } 
        if (!isset($_SESSION['mainboard']) || !isset($_SESSION['side']) || !isset($_SESSION['maybe'])) {
            $errorM = "Session not initialized";
            $this->jsonView->display($errorM);
            return;
        }
        if ($sideBoard === "Yes") {
            $this->deckBuilderService->addCardToSideboard($cardId, $sideBoard, $maybeBoard);
        } elseif ($maybeBoard === "Yes") {
            $this->deckBuilderService->addCardToMaybeboard($cardId, $sideBoard, $maybeBoard);
        } else {
            $this->deckBuilderService->addCardToMainboard($cardId, $sideBoard, $maybeBoard);
        }
        $successMessage = "Card added successfully.";
        $this->jsonView->display($successMessage);
    }
    public function handleRemoveFunction($cardId, $sideBoard, $maybeBoard) {
        if (!in_array($sideBoard, ["Yes", "No"]) || !in_array($maybeBoard, ["Yes", "No"])) {
            $errorM = "Invalid sideboard or maybeboard value";
            $this->jsonView->display($errorM);
            return;
        }
        if (!isset($_SESSION['mainboard']) || !isset($_SESSION['side']) || !isset($_SESSION['maybe'])) {
            $errorM = "Session not initialized";
            $this->jsonView->display($errorM);
            return;
        }
        if ($sideBoard === "Yes") {
            $this->deckBuilderService->removeCardFromSideboard($cardId, 1);
        } elseif ($maybeBoard === "Yes") {
            $this->deckBuilderService->removeCardFromMaybeboard($cardId, 1);
        } else {
            $this->deckBuilderService->removeCardFromMainboard($cardId, 1);
        }
        $successMessage = "Card removed successfully.";
        $this->jsonView->display($successMessage);
    }
    private function displayDeckContents(){
        $mainDeck = $_SESSION['mainboard'];       
        $sideDeck = $_SESSION['side'];
        $maybeDeck = $_SESSION['maybe'];
        $mainDeckContents = [];
        $sideDeckContents = [];
        $maybeBoardContents = [];
        foreach($mainDeck as $cardId => $quantity){       
            $mainInfo= $this->getCardData($cardId);
            array_push($mainDeckContents, $mainInfo);
        };
        foreach($sideDeck as $cardId => $quantity){
            $sideInfo= $this->getCardData($cardId);
            array_push($sideDeckContents, $sideInfo);
        };
        foreach($maybeDeck as $cardId => $quantity){
            $maybeInfo= $this->getCardData($cardId);
            array_push($maybeBoardContents, $maybeInfo);
        };
        $deckData = [];
        $deckData['mainDeck'] = $mainDeckContents;
        $deckData['sideDeck'] = $sideDeckContents;
        $deckData['maybeDeck'] = $maybeBoardContents;
        $this->jsonView->display($deckData);
    }
    private function getCardData($cardId){
        $cardInfo = $this->cardArchiveService->getCardsById($cardId);
        return $cardInfo;
    }
    private function updateDeckContents() {
        $deckId = $_SESSION['deck'];
        $this->deckBuilderService->removeDeckContents($deckId);
        foreach ($_SESSION['mainboard'] as $cardId => $card)  {
            $quantity = $card['quantity'];
            $this->deckBuilderService->uploadMainDeckContents($cardId, $deckId, $quantity);
        }
        foreach ($_SESSION['side'] as $cardId => $side) {
            $quantity = $side['quantity'];    
            $this->deckBuilderService->uploadSideDeckContents($cardId, $deckId, $quantity);
        }
        foreach ($_SESSION['maybe'] as $cardId => $maybe) {
            $quantity = $maybe['quantity'];    
            $this->deckBuilderService->uploadMaybeDeckContents($cardId, $deckId, $quantity);
        }
        $succesM = "Your deck has been updatet";
        $this->jsonView->display($succesM);
        $this->clearExistingSessions();
    }
    private function clearExistingSessions(){
        if(isset($_SESSION['maybe'])){
            $_SESSION['maybe'] = array();
            unset($_SESSION['maybe']);
        }
        if(isset($_SESSION['sidedeck'])){
            $_SESSION['sidedeck'] = array();
            unset($_SESSION['sidedeck']);
        }
        if(isset($_SESSION['mainboard'])){
            $_SESSION['mainboard'] = array();
            unset($_SESSION['mainboard']);
        }
        if (isset($_SESSION['deck'])){
            $_SESSION['deck'] = "";
            unset($_SESSION['deck']);
        }
    }
}