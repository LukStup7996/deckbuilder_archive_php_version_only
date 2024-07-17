<?php
namespace deckbuilder_archive_php_version_only\api\controller;
use deckbuilder_archive_php_version_only\api\DTOs\DeckModelDTO;
use deckbuilder_archive_php_version_only\api\services\DeckArchiveService;
use deckbuilder_archive_php_version_only\api\views\JsonView;

class DeckArchiveController
{
    private $jsonView;
    private $deckArchiveService;
    private $url = API_URL;

    public function __construct(){
        $this->jsonView = new JsonView();
        $this->deckArchiveService = new DeckArchiveService();
    }

    public function route(){
        $action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
        switch(strtolower($action)){
            case 'searchbyuser':
                $getUserId = filter_input(INPUT_GET,"userid",FILTER_SANITIZE_NUMBER_INT);
                $this->getDecksByUserId($getUserId);
                break;
            case 'searchbyname':
                $getDeckName = filter_input(INPUT_GET,"deckname",FILTER_SANITIZE_STRING);
                $this->getDecksByName($getDeckName);
                break;
            case 'searchbyformat':
                $getFormat = filter_input(INPUT_GET,"format",FILTER_SANITIZE_NUMBER_INT);
                $this->getDecksByFormat($getFormat);
                break;
            case 'searchalldecks':
                $this->displayAllDecklists();
                break;
            case 'displayowned':
                $ownUserId = unserialize($_SESSION['user']);
                $this->getDecksByUserId($ownUserId->user_id);
                break;
            case 'displaydeckcontents':
                $getDeckId = filter_input(INPUT_GET,"deckid",FILTER_SANITIZE_NUMBER_INT);
                $this->displayDecklistContent($getDeckId);
                break;
            default:
            $errorM = "Unknown Action";
            $this->jsonView->display($errorM);                                
        }
    }

    private function displayAllDecklists(){
        $listOfAllDecks = $this->deckArchiveService->displayAllDecklists();
        $dtoList = []; 
        foreach ($listOfAllDecks as $deck) {
            $dtoList[] = DeckModelDTO::map($deck, $this->url);
        }
        $this->jsonView->display($dtoList);
    }
    public function getDecksByName($deckName){
        $listofDecksByName = $this->deckArchiveService->getDecksByName($deckName);
        foreach ($listofDecksByName as $deck) {
            $dtoList[] = DeckModelDTO::map($deck, $this->url);
        }
        $this->jsonView->display($dtoList);
    }
    public function getDecksByUserId($userId){
        $listofDecksByUser = $this->deckArchiveService->getDecksByUserId($userId);
        foreach ($listofDecksByUser as $deck) {
            $dtoList[] = DeckModelDTO::map($deck, $this->url);
        }
        $this->jsonView->display($dtoList);
    }
    public function getDecksByFormat($format){
        $listofDecksByFormat = $this->deckArchiveService->getDecksByFormat($format);
        foreach ($listofDecksByFormat as $deck) {
            $dtoList[] = DeckModelDTO::map($deck, $this->url);
        }
        $this->jsonView->display($dtoList);
    }
    public function displayDecklistContent($deckId){
        $deckContents = $this->deckArchiveService->displayDecklistContent($deckId);
        $this->jsonView->display($deckContents);
    }
}