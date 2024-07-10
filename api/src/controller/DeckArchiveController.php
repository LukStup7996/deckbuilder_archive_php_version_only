<?php
namespace deckbuilder_archive_php_version_only\api\controller;
use deckbuilder_archive_php_version_only\api\views\JsonView;

class DeckArchiveController
{
    private $jsonView;

    public function __construct(){
        $this->jsonView = new JsonView();
    }

    public function route(){
        $action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
        switch(strtolower($action)){
            case 'searchbyuser':
            case 'searchbyname':
            case 'searchbyformat':
            case 'searchalldecks':
            case 'displayowned':
            case 'displaydeckcontents':
                $this->deckArchiveEndcap();
                break;
            default:
            $errorM = "Unknown Action";
            $this->jsonView->display($errorM);                                
        }
    }

    private function deckArchiveEndcap(){
        $succesM = "you have successfully searched for decks";
        $this->jsonView->display($succesM);
    }
}