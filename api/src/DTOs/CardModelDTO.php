<?php
namespace deckbuilder_archive_php_version_only\api\DTOs;

class CardModelDTO
{
    public $cardName;
    public $cardId;
    public $cardType;
    public $subType;
    public $superType;
    public $manaValue;
    public $cost;
    public $url; 

    public static function map($cardModel, $url){
        $cardModelDTO = new CardModelDTO();
        $cardModelDTO->cardName = $cardModel->cardName;
        $cardModelDTO->cardId = $cardModel->cardId;
        $cardModelDTO->cardType = $cardModel->cardType;
        $cardModelDTO->superType = $cardModel->superType;
        $cardModelDTO->subType = $cardModel->subType;
        $cardModelDTO->manaValue = $cardModel->manaValue;
        $cardModelDTO->cost = $cardModel->cost;
        $cardModelDTO->url = $url."?action=filterbyid&cardid=".$cardModel->cardId;
        return $cardModelDTO;
    }
}