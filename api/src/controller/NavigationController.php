<?php
namespace deckbuilder_archive_php_version_only\api\controller;
use deckbuilder_archive_php_version_only\api\views\JsonView;

class NavigationController
{
    private $cardController;
    private $deckController;
    private $accountController;
    private $builderController;
    private $jsonView;

    public function __construct(){
        $this->cardController = new CardArchiveController();
        $this->deckController = new DeckArchiveController();
        $this->accountController = new UserAccountController();
        $this->builderController = new DeckbuilderController();
        $this->jsonView = new JsonView();
    }

    public function route(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Set-Cookie");
        header("Access-Control-Allow-Credentials: true");

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
                $this->searchForCard();
                break;
            case 'searchbyuser':
            case 'searchbyname':
            case 'searchbyformat':
            case 'searchalldecks':
            case 'displayowned':
            case 'displaydeckcontents':
                $this->searchForDeck();
                break;    
            case 'createarchiver':
            case 'loginarchiver':
            case 'logoutarchiver':
            case 'getarchiver':
            case 'updatearchivername':
            case 'updatearchiverpassword':
            case 'deletearchiver':
                $this->handleAccount();
                break;
            case 'createdeck':
            case 'addcard':
            case 'removecard':
            case 'updatedeck':
            case 'selectdeck':
            case 'deletedeck':
            case 'displaydeckcontent':
                $this->buildDeck();
                break;    
            default:
            $errorM = "Unknown Action";
            $this->jsonView->display($errorM);                                
        }
    }

    private function searchForCard(){
        $this->cardController->route();
    }
    private function searchForDeck(){
        $this->deckController->route();
    }
    private function handleAccount(){
        $this->accountController->route();
    }
    private function buildDeck(){
        $this->builderController->route();
    }
}