<?php
namespace deckbuilder_archive_php_version_only\api\gateways;
use deckbuilder_archive_php_version_only\api\models\DeckModel;
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

    public function checkForUserCreatedDBContent($userId){
        $sql = "SELECT deck_id, user_id, deck_name, format FROM decklists WHERE user_id LIKE :userId ORDER BY deck_id";
        $statement = $this->pdo->prepare($sql);
        $userId = '%'.$userId.'%';
        $statement->bindParam(':userId', $userId);
        $statement->execute();
        $listOfOwnedDecks = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->mapAllDecklists($listOfOwnedDecks);
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
}