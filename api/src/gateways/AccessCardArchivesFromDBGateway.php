<?php
namespace deckbuilder_archive_php_version_only\api\gateways;
use deckbuilder_archive_php_version_only\api\models\CardModel;
use PDO;
class AccessCardArchivesFromDBGateway
{
    private $pdo;
    public function __construct(
        $host,
        $dbname,
        $user,
        $password
    )
    {
        $this->pdo = new PDO('mysql:host='.$host.';dbname='.$dbname,$user,$password);
    }

    public function getAllCards(){
        $sql = "SELECT card_name, card_id, card_type, super_type, sub_type, mana_value, cmc FROM cards ORDER BY card_name";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $fullListOfCards = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->mapAllCards($fullListOfCards);
    }
    public function getCardsById($cardId){
        $sql = "SELECT card_name, card_id, card_type, super_type, sub_type, mana_value, cmc FROM cards WHERE card_id LIKE :cardId ORDER BY card_name";
        $statement = $this->pdo->prepare($sql);
        $cardId = '%'.$cardId.'%';
        $statement->bindParam(':cardId', $cardId);
        $statement->execute();
        $listOfCrdsById = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->mapAllCards($listOfCrdsById);
    }
    public function getCardsByName($cardName){
        $sql = "SELECT card_name, card_id, card_type, super_type, sub_type, mana_value, cmc FROM cards WHERE card_name LIKE :cardName ORDER BY card_name";
        $statement = $this->pdo->prepare($sql);
        $cardName = '%'.$cardName.'%';
        $statement->bindParam(':cardName',$cardName);
        $statement->execute();
        $listOfCardsByName = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->mapAllCards($listOfCardsByName);
    }
    public function getCardsByType($cardType){
        $sql = "SELECT card_name, card_id, card_type, super_type, sub_type, mana_value, cmc FROM cards WHERE card_type LIKE :cardType ORDER BY card_name";
        $statement = $this->pdo->prepare($sql);
        $cardType = '%'.$cardType.'%';
        $statement->bindParam(':cardType',$cardType);
        $statement->execute();
        $listOfAllCardsByType = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->mapAllCards($listOfAllCardsByType);
    }
    public function getCardsBySuper($superType){
        $sql = "SELECT card_name, card_id, card_type, super_type, sub_type, mana_value, cmc FROM cards WHERE super_type LIKE :superType ORDER BY card_name";
        $statement = $this->pdo->prepare($sql);
        $superType = '%'.$superType.'%';
        $statement->bindParam(':superType',$superType);
        $statement->execute();
        $listOfAllCardsBySuper = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->mapAllCards($listOfAllCardsBySuper);
    }
    public function getCardsBySub($subType){
        $sql = "SELECT card_name, card_id, card_type, super_type, sub_type, mana_value, cmc FROM cards WHERE sub_type LIKE :subType ORDER BY card_name";
        $statement = $this->pdo->prepare($sql);
        $subType = '%'.$subType.'%';
        $statement->bindParam(':subType',$subType);
        $statement->execute();
        $listOfAllCardsBySub = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->mapAllCards($listOfAllCardsBySub);
    }
    public function getCardsByValue($value){
        $sql = "SELECT card_name, card_id, card_type, super_type, sub_type, mana_value, cmc FROM cards WHERE mana_value LIKE :manaValue ORDER BY card_name";
        $statement = $this->pdo->prepare($sql);
        $value = '%'.$value.'%';
        $statement->bindParam(':manaValue',$value);
        $statement->execute();
        $listOfAllCardsByValue = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->mapAllCards($listOfAllCardsByValue);
    }
    public function getCardsByCost($cost){
        $sql = "SELECT card_name, card_id, card_type, super_type, sub_type, mana_value, cmc FROM cards WHERE cmc LIKE :cost ORDER BY card_name";
        $statement = $this->pdo->prepare($sql);
        $cost = '%'.$cost.'%';
        $statement->bindParam(':cost',$cost);
        $statement->execute();
        $listOfAllCardsByCost = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->mapAllCards($listOfAllCardsByCost);
    }
    private function mapAllCards(array $listOfCards){
        $return = [];
        foreach($listOfCards as $displayedCard){
            $cardModel = new CardModel();
            $cardModel->cardName = $displayedCard['card_name'];
            $cardModel->cardId = $displayedCard['card_id'];
            $cardModel->cardType = $displayedCard['card_type'];
            $cardModel->superType = $displayedCard['super_type'];
            $cardModel->subType = $displayedCard['sub_type'];
            $cardModel->manaValue = $displayedCard['mana_value'];
            $cardModel->cost = $displayedCard['cmc'];
            $return[] = $cardModel;
        }
        return $return;
        
    } 
}