<?php
namespace deckbuilder_archive_php_version_only\api\services;
use deckbuilder_archive_php_version_only\api\gateways\DeckBuilderGateway;

class DeckBuilderService
{
    private $deckBuilderGateway;
    public function __construct(){
        $this->deckBuilderGateway = new DeckBuilderGateway(
            DBHost,
            DBName,
            DBUsername,
            DBPasword
        );
    }
    public function addCardToMainboard($cardId, $sideBoard, $maybeBoard) {
        $quantity = 1;
        $this->addCardToSession($_SESSION['mainboard'], $cardId, $quantity);
    }
    
    public function addCardToSideboard($cardId, $sideBoard, $maybeBoard) {
        $quantity = 1;
        $this->addCardToSession($_SESSION['side'], $cardId, $quantity);
    }
    
    public function addCardToMaybeboard($cardId, $sideBoard, $maybeBoard) {
        $quantity = 1;
        $this->addCardToSession($_SESSION['maybe'], $cardId, $quantity);
    }
    private function addCardToSession(&$sessionArray, $cardId, $quantity) {
        if (array_key_exists($cardId, $sessionArray)) {
            $sessionArray[$cardId]['quantity'] += $quantity;
        } else {
            $sessionArray[$cardId]['quantity'] = $quantity;
        }
    } 
    public function removeCardFromMainboard($cardId, $quantity) {
        $_SESSION['mainboard'][$cardId]['quantity'] -= $quantity;
        if($_SESSION['mainboard'][$cardId]['quantity'] <= 0){
            unset($_SESSION['mainboard'][$cardId]);
        }
    }
    public function removeCardFromSideboard($cardId, $quantity) {
        $_SESSION['side'][$cardId]['quantity'] -= $quantity;
        if($_SESSION['side'][$cardId]['quantity'] <= 0){
            unset($_SESSION['side'][$cardId]);
        }
    }
    public function removeCardFromMaybeboard($cardId, $quantity) {
        $_SESSION['maybe'][$cardId]['quantity'] -= $quantity;
        if($_SESSION['maybe'][$cardId]['quantity'] <= 0){
            unset($_SESSION['maybe'][$cardId]);
        }    
    }
    public function createDecklist($userId, $deckName, $format){
        $newDecklist = $this->deckBuilderGateway->createDecklist($userId, $deckName, $format);
        return $newDecklist;
    }
    public function deleteDecklistEntry($deckId){
        if($deckId){
            $this->deckBuilderGateway->removeDeckContentsFromDB($deckId);
            $this->deckBuilderGateway->deleteDecklistEntry($deckId);
            return true;
        }else{
            return false;
        }
    }
    public function removeDeckContents($deckId){
        $this->deckBuilderGateway->removeDeckContentsFromDB($deckId);
        return true;
    }
    public function uploadMainDeckContents($cardId,$deckId,$quantity){
        $this->deckBuilderGateway->pushMainDeckContentIntoDB($cardId,$deckId,$quantity);
        return true;        
    }
    public function uploadSideDeckContents($cardId,$deckId,$quantity){
        $this->deckBuilderGateway->pushSideDeckContentIntoDB($cardId,$deckId,$quantity);
        return true;        
    }
    public function uploadMaybeDeckContents($cardId,$deckId,$quantity){
        $this->deckBuilderGateway->pushMaybeDeckContentIntoDB($cardId,$deckId,$quantity);
        return true;        
    }
}