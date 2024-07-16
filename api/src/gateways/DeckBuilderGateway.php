<?php
namespace deckbuilder_archive_php_version_only\api\gateways;
use deckbuilder_archive_php_version_only\api\models\DeckModel;
use PDO;
class DeckBuilderGateway
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

    public function createDecklist($userId, $deckName, $format){
        $sql = "INSERT INTO decklists (user_id, deck_name, format) VALUES (:user_id, :deck_name, :format)";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':user_id', $userId);
        $statement->bindParam(':deck_name', $deckName);
        $statement->bindParam(':format', $format);
        $statement->execute();
        $deckId = $this->pdo->lastInsertId();
        return $deckId;
    }

    public function deleteDecklistEntry($deckId){
        $sql = "DELETE FROM decklists WHERE deck_id = :deckId";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':deckId', $deckId);
        $statement->execute();
        return true;
    }
    public function removeDeckContentsFromDB($deckId){
        $sql = "DELETE FROM cards_decklists WHERE deck_id = :deck_id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':deck_id',$deckId);
        $statement->execute();
        return true;
    }
    public function pushMainDeckContentIntoDB($cardId,$deckId,$quantity){
        $sideBoard = "No";
        $maybeBoard = "No";
        $sql = "INSERT INTO cards_decklists (card_id, deck_id, quantity,side_board,maybe_board) VALUES (:card_id,:deck_id,:quantity,:side_board,:maybe_board)";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':card_id',$cardId);
        $statement->bindParam(':deck_id',$deckId);
        $statement->bindParam(':quantity',$quantity);
        $statement->bindParam(':side_board',$sideBoard);
        $statement->bindParam(':maybe_board',$maybeBoard);
        $statement->execute();
        return $statement->rowCount() > 0;  
    }
    public function pushSideDeckContentIntoDB($cardId,$deckId,$quantity){
        $sideBoard = "Yes";
        $maybeBoard = "No";
        $sql = "INSERT INTO cards_decklists (card_id, deck_id, quantity,side_board,maybe_board) VALUES (:card_id,:deck_id,:quantity,:side_board,:maybe_board)";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':card_id',$cardId);
        $statement->bindParam(':deck_id',$deckId);
        $statement->bindParam(':quantity',$quantity);
        $statement->bindParam(':side_board',$sideBoard);
        $statement->bindParam(':maybe_board',$maybeBoard);
        $statement->execute();
        return $statement->rowCount() > 0;  
    }
    public function pushMaybeDeckContentIntoDB($cardId,$deckId,$quantity){
        $sideBoard = "No";
        $maybeBoard = "Yes";
        $sql = "INSERT INTO cards_decklists (card_id, deck_id, quantity,side_board,maybe_board) VALUES (:card_id,:deck_id,:quantity,:side_board,:maybe_board)";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':card_id',$cardId);
        $statement->bindParam(':deck_id',$deckId);
        $statement->bindParam(':quantity',$quantity);
        $statement->bindParam(':side_board',$sideBoard);
        $statement->bindParam(':maybe_board',$maybeBoard);
        $statement->execute();
        return $statement->rowCount() > 0;  
    }    
}