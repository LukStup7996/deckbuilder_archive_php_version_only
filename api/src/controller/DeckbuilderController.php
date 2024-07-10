<?php
namespace deckbuilder_archive_php_version_only\api\controller;
use deckbuilder_archive_php_version_only\api\views\JsonView;

class DeckbuilderController
{
    private $jsonView;

    public function __construct(){
        $this->jsonView = new JsonView();
    }

    public function route(){
        $action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
        switch(strtolower($action)){
            case 'createdeck':
            case 'addcard':
            case 'removecard':
            case 'updatedeck':
            case 'selectdeck':
            case 'deletedeck':
            case 'displaydeckcontent':
                $this->deckBuilderEndcap();
                break;
            default:
            $errorM = "Unknown Action";
            $this->jsonView->display($errorM);                                
        }
    }

    private function deckBuilderEndcap(){
        $succesM = "you have successfully accessed deckbuilding services";
        $this->jsonView->display($succesM);
    }
}