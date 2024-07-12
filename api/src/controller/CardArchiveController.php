<?php
namespace deckbuilder_archive_php_version_only\api\controller;
use deckbuilder_archive_php_version_only\api\DTOs\CardModelDTO;
use deckbuilder_archive_php_version_only\api\services\CardArchiveService;
use deckbuilder_archive_php_version_only\api\views\JsonView;

class CardArchiveController
{
    private $jsonView;
    private $cardArchiveService;
    private $url = API_URL;

    public function __construct(){
        $this->jsonView = new JsonView();
        $this->cardArchiveService = new CardArchiveService();
    }

    public function route(){
        $action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
        switch(strtolower($action)){
            case 'filterallcards':
                $this->displayAllCardsInDB();
                break;
            case 'filterbyid':
                $getCardId = filter_input(INPUT_GET, "cardid", FILTER_SANITIZE_STRING);
                $this->displayCardsById($getCardId);
                break; 
            case 'filterbyname':
                $getCardName = filter_input(INPUT_GET,"cardname",FILTER_SANITIZE_STRING);
                $this->displayCardsByName($getCardName);
                break;
            case 'filterbytype':
                $getCardType = filter_input(INPUT_GET, "cardtype", FILTER_SANITIZE_STRING);
                $this->displayCardsByType($getCardType);
                break;
            case 'filterbysuper':
                $getCardBySuper = filter_input(INPUT_GET, "supertype", FILTER_SANITIZE_STRING);
                $this->displayCardsBySuper($getCardBySuper);
                break;
            case 'filterbysub':
                $getCardBySub = filter_input(INPUT_GET, "subtype", FILTER_SANITIZE_STRING);
                $this->displayCardsBySub($getCardBySub);
                break;
            case 'filterbyvalue':
                $getCardByValue = filter_input(INPUT_GET, "value", FILTER_SANITIZE_STRING);
                $this->displayCardsByValue($getCardByValue);
                break;
            case 'filterbycost':
                $getCardByCost = filter_input(INPUT_GET, "cost", FILTER_SANITIZE_STRING);
                $this->displayCardsByCost($getCardByCost);
                break;
            default:
            $errorM = "Unknown Action";
            $this->jsonView->display($errorM);                                
        }
    }

    private function displayAllCardsInDB(){
        $listtOfAllCardDBEntries = $this->cardArchiveService->getAllCards();
        $dtoList = [];
        foreach($listtOfAllCardDBEntries as $card){
            $dtoList[] = CardModelDTO::map($card, $this->url);
        }
        $this->jsonView->display($dtoList);
    }
    private function displayCardsById($cardId){
        $listOfAllCardsWithId = $this->cardArchiveService->getCardsById($cardId);
        $dtoList = [];
        foreach($listOfAllCardsWithId as $card){
            $dtoList[] = CardModelDTO::map($card,$this->url);
        }
        $this->jsonView->display($dtoList);
    }
    private function displayCardsByName($cardName){
        $listofAllCardsWithName = $this->cardArchiveService->getCardsByName($cardName);
        $dtoList = [];
        foreach($listofAllCardsWithName as $card){
            $dtoList[] = CardModelDTO::map($card, $this->url);
        }
        $this->jsonView->display($dtoList);
    }
    private function displayCardsByType($cardType){
        $listOfAllCardsByType = $this->cardArchiveService->getCardsByType($cardType);
        $dtoList = [];
        foreach($listOfAllCardsByType as $card){
            $dtoList[] = CardModelDTO::map($card,$this->url);
        }
        $this->jsonView->display($dtoList);
    }
    private function displayCardsBySuper($superType){
        $listOfAllCardsBySuper = $this->cardArchiveService->getCardsByType($superType);
        $dtoList = [];
        foreach($listOfAllCardsBySuper as $card){
            $dtoList[] = CardModelDTO::map($card, $this->url);
        }
        $this->jsonView->display($dtoList);
    }
    private function displayCardsBySub($subType){
        $listOfAllCardsBySub = $this->cardArchiveService->getCardsByType($subType);
        $dtoList = [];
        foreach($listOfAllCardsBySub as $card){
            $dtoList[] = CardModelDTO::map($card, $this->url);
        }
        $this->jsonView->display($dtoList);
    }
    private function displayCardsByValue($manaValue){
        $listOfAllCardsByValue = $this->cardArchiveService->getCardsByType($manaValue);
        $dtoList = [];
        foreach($listOfAllCardsByValue as $card){
            $dtoList[] = CardModelDTO::map($card, $this->url);
        }
        $this->jsonView->display($dtoList);
    }
    private function displayCardsByCost($cost){
        $listOfAllCardsByCost = $this->cardArchiveService->getCardsByType($cost);
        $dtoList = [];
        foreach($listOfAllCardsByCost as $card){
            $dtoList[] = CardModelDTO::map($card, $this->url);
        }
        $this->jsonView->display($dtoList);
    }
}