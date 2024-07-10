<?php
namespace deckbuilder_archive_php_version_only\api\controller;
use deckbuilder_archive_php_version_only\api\views\JsonView;

class UserAccountController
{
    private $jsonView;

    public function __construct(){
        $this->jsonView = new JsonView();
    }

    public function route(){
        $action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
        switch(strtolower($action)){
            case 'createarchiver':
            case 'loginarchiver':
            case 'logoutarchiver':
            case 'getarchiver':
            case 'updatearchiver':
            case 'deletearchiver':
                $this->userAccountEndcap();
                break;
            default:
            $errorM = "Unknown Action";
            $this->jsonView->display($errorM);                                
        }
    }

    private function userAccountEndcap(){
        $succesM = "you have successfully accessed account functions";
        $this->jsonView->display($succesM);
    }
}