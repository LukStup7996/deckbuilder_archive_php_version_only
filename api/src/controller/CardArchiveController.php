<?php
namespace deckbuilder_archive_php_version_only\api\controller;
use deckbuilder_archive_php_version_only\api\views\JsonView;

class CardArchiveController
{
    private $jsonView;

    public function __construct(){
        $this->jsonView = new JsonView();
    }

    public function route(){
        $action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
        switch(strtolower($action)){
            case 'filterallcards':
            case 'filterbyid':
            case 'filterbyname':
            case 'filterbytype':
            case 'filterbysuper':
            case 'filterbysub':
            case 'filterbyvalue':
            case 'filterbycost':
                $this->cardArchiveEndcap();
                break;
            default:
            $errorM = "Unknown Action";
            $this->jsonView->display($errorM);                                
        }
    }

    private function cardArchiveEndcap(){
        $succesM = "you have successfully searched for cards";
        $this->jsonView->display($succesM);
    }
}