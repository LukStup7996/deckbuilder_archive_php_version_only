<?php
namespace deckbuilder_archive_php_version_only\api\services;
use deckbuilder_archive_php_version_only\api\gateways\AccessCardArchivesFromDBGateway;
class CardArchiveService
{
    private $cardArchiveGateway;
    public function __construct(){
        $this->cardArchiveGateway = new AccessCardArchivesFromDBGateway(
            DBHost,
            DBName,
            DBUsername,
            DBPasword
        );
    }
    public function getAllCards(){
        $listOfAllCards = $this->cardArchiveGateway->getAllCards();
        return $listOfAllCards;
    }
    public function getCardsById($cardId){
        $listOfCardsWithId = $this->cardArchiveGateway->getCardsById($cardId);
        return $listOfCardsWithId;
    }
    public function getCardsByName($cardName){
        $listOfCardsWithName = $this->cardArchiveGateway->getCardsByName($cardName);
        return $listOfCardsWithName;
    }
    public function getCardsByType($cardType){
        $listOfCardsByType = $this->cardArchiveGateway->getCardsByType($cardType);
        return $listOfCardsByType;
    }
    public function getCardsBySuper($superType){
        $listOfCardsBySuper = $this->cardArchiveGateway->getCardsByType($superType);
        return $listOfCardsBySuper;
    }
    public function getCardsBySub($subType){
        $listOfCardsBySub = $this->cardArchiveGateway->getCardsByType($subType);
        return $listOfCardsBySub;
    }
    public function getCardsByValue($value){
        $listOfCardsByValue = $this->cardArchiveGateway->getCardsByType($value);
        return $listOfCardsByValue;
    }
    public function getCardsByCost($cost){
        $listOfCardsByCost = $this->cardArchiveGateway->getCardsByType($cost);
        return $listOfCardsByCost;
    }
} 