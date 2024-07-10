<?php
namespace deckbuilder_archive_php_version_only\api\views;
use deckbuilder_archive_php_version_only\api\views\ViewInterface;

class JsonView implements ViewInterface
{
    public function display($data){
        header("Content-Type: application/json");
        echo json_encode($data);
    }
}