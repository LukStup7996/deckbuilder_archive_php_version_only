<?php
namespace deckbuilder_archive_php_version_only\api\services;
use deckbuilder_archive_php_version_only\api\gateways\AccessDeckArchiveFromDBGateway;

class DeckArchiveService
{
    private $deckArchiveGateway;
    public function __construct()
    {
        $this->deckArchiveGateway = new AccessDeckArchiveFromDBGateway(DBHost, DBName, DBUsername, DBPasword);
    }
     public function checkForUserCreatedDBContent($userId){
        $listOfAvailableDecks = $this->deckArchiveGateway->checkForUserCreatedDBContent($userId);
        return $listOfAvailableDecks;
     }
     public function displayMainDeckContent($deckId){
        $mainDeckContents = $this->deckArchiveGateway->displayMainDeckContent($deckId);
        return $mainDeckContents;  
    }
    public function displaySideBoardContent($deckId){
        $sideDeckContents = $this->deckArchiveGateway->displaySideBoardContent($deckId);
        return $sideDeckContents; 
    }
    public function displayMaybeBoardContent($deckId){
        $maybeBoardContents = $this->deckArchiveGateway->displayMaybeBoardContent($deckId);
        return $maybeBoardContents; 
    } 
}