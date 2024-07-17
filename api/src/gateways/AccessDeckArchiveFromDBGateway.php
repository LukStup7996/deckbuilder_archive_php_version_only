<?php
namespace deckbuilder_archive_php_version_only\api\gateways;
use deckbuilder_archive_php_version_only\api\models\DeckModel;
use deckbuilder_archive_php_version_only\api\models\DeckContentModel;

use PDO;
class AccessDeckArchiveFromDBGateway
{
    private $pdo;
    public function __construct(
        $host,
        $dbname,
        $user,
        $password
    ){
        $this->pdo = new PDO('mysql:host='.$host.';dbname='.$dbname,$user,$password);
    }
    public function displayAllDecklists(){
        $sql = "SELECT deck_id, user_id, deck_name, format FROM decklists ORDER BY deck_name";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $listOfDecksWithNameLike = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->mapAllDecklists($listOfDecksWithNameLike);
     
    }
    public function getDecksByName($deckName){
        $sql = "SELECT deck_id, user_id, deck_name, format FROM decklists WHERE deck_name LIKE :deck_name";
        $statement = $this->pdo->prepare($sql);
        $deckName = '%'.$deckName.'%';
        $statement->bindParam(':deck_name',$deckName);
        $statement->execute();
        $listOfDecksWithNameLike = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->mapAllDecklists($listOfDecksWithNameLike);
    }
    public function getDecksByUserId($userId){
        $sql = "SELECT deck_id, user_id, deck_name, format FROM decklists WHERE user_id = :userId";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':userId',$userId);
        $statement->execute();
        $listOfDecksByUser = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->mapAllDecklists($listOfDecksByUser);
    }
    public function getDecksByFormat($format){
        $sql = "SELECT deck_id, user_id, user_id, deck_name, format FROM decklists WHERE format LIKE :format";
        $statement = $this->pdo->prepare($sql);
        $format = '%'.$format.'%';
        $statement->bindParam(':format',$format);
        $statement->execute();
        $listOfDecksByFormat = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->mapAllDecklists($listOfDecksByFormat);
    }
    public function displayDecklistContent($deckId){
        $sql = "SELECT card_id, deck_id, quantity, side_board, maybe_board FROM cards_decklists WHERE deck_id = :deckId ORDER BY card_id, side_board, maybe_board";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':deckId', $deckId);
        $statement->execute();
        $listOfDeckContents = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->mapAllDeckContents($listOfDeckContents);
    }    
    public function checkForUserCreatedDBContent($userId){
        $sql = "SELECT deck_id, user_id, deck_name, format FROM decklists WHERE user_id LIKE :userId ORDER BY deck_id";
        $statement = $this->pdo->prepare($sql);
        $userId = '%'.$userId.'%';
        $statement->bindParam(':userId', $userId);
        $statement->execute();
        $listOfOwnedDecks = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->mapAllDecklists($listOfOwnedDecks);
    }
    public function displayMainDeckContent($deckId){
        $sideBoard = "No";
        $maybeBoard = "No";
        $sql = "SELECT card_id, deck_id, quantity, side_board, maybe_board FROM cards_decklists WHERE deck_id = :deckId AND side_board = :sideBoard AND maybe_board = :maybeBoard ORDER BY card_id, side_board, maybe_board";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':deckId', $deckId);
        $statement->bindParam(':sideBoard', $sideBoard);
        $statement->bindParam(':maybeBoard', $maybeBoard);
        $statement->execute();
        $listOfMainDeckContents = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->mapAllDeckContents($listOfMainDeckContents);
    }
    public function displaySideBoardContent($deckId){
        $sideBoard = "Yes";
        $sql = "SELECT card_id, deck_id, quantity, side_board, maybe_board FROM cards_decklists WHERE deck_id = :deckId AND side_board = :sideBoard ORDER BY card_id, side_board, maybe_board";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':deckId', $deckId);
        $statement->bindParam(':sideBoard', $sideBoard);
        $statement->execute();
        $listOfMainDeckContents = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->mapAllDeckContents($listOfMainDeckContents);
    }
    public function displayMaybeBoardContent($deckId){
        $maybeBoard = "Yes";
        $sql = "SELECT card_id, deck_id, quantity, side_board, maybe_board FROM cards_decklists WHERE deck_id = :deckId AND maybe_board = :maybeBoard ORDER BY card_id, side_board, maybe_board";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':deckId', $deckId);
        $statement->bindParam(':maybeBoard', $maybeBoard);
        $statement->execute();
        $listOfMainDeckContents = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->mapAllDeckContents($listOfMainDeckContents);
    }
    private function mapAllDecklists(array $listOfDecks){
        $return = [];
        foreach($listOfDecks as $decklist){
            $deckModel = new DeckModel();
            $deckModel->deckId = $decklist['deck_id'];
            $deckModel->deckName = $decklist['deck_name'];
            $deckModel->userId = $decklist['user_id'];
            $deckModel->format = $decklist['format'];
            $return[] = $deckModel;
        }
        return $return;
    }
    public function mapAllDeckContents(array $listOfContents){
        $return = [];
        foreach($listOfContents as $card){
            $sqlFetchCardInfo = "SELECT cards.card_name, cards.card_id, cards.card_type, cards.sub_type, cards.super_type, cards.mana_value, cards.cmc, cards_decklists.quantity FROM cards INNER JOIN cards_decklists ON cards.card_id = cards_decklists.card_id WHERE cards.card_id = :cardId ORDER BY cards.card_type";
            $statement = $this->pdo->prepare($sqlFetchCardInfo);
            $statement->bindParam(':cardId',$card['card_id']);
            $statement->execute();
            $cardInfo = $statement->fetchAll(PDO::FETCH_ASSOC);
            $mappedCards = $this->mapAllCards($cardInfo);
            $return = array_merge($return, $mappedCards);
        }
        return $return;
    }
    public function mapAllCards(array $fullCardList) : array{
        $return = [];
        foreach($fullCardList as $displayedCard){
            $cardModel = new DeckContentModel();
            $cardModel->cardName = $displayedCard['card_name'];
            $cardModel->cardId = $displayedCard['card_id'];
            $cardModel->cardType = $displayedCard['card_type'];
            $cardModel->subType = $displayedCard['sub_type'];
            $cardModel->superType = $displayedCard['super_type'];
            $cardModel->manaValue = $displayedCard['mana_value'];
            $cardModel->castingCost = $displayedCard['cmc'];
            $cardModel->quantity = $displayedCard['quantity'];
            $return[] = $cardModel;
        }
        return $return;
    }    
}