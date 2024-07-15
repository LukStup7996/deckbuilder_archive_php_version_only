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
    public function createDecklist($userId, $deckName, $format){
        $newDecklist = $this->deckBuilderGateway->createDecklist($userId, $deckName, $format);
        return $newDecklist;
    }
    public function deleteDecklistEntry($deckId){
        if($deckId){
            $this->deckBuilderGateway->deleteDecklistEntry($deckId);
            return true;
        }else{
            return false;
        }
    }
}