<?php
namespace deckbuilder_archive_php_version_only\api\gateways;
use PDO;
class ReadUserFromDBGateway
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
    public function createArchiveUser($mailAdress, $archiverName, $userPassword){
        $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
        $sql = "INSERT INTO archiveuser (mail_adress, archive_name, user_password) VALUES (:mail_adress, :archive_name, :user_password)";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(":mail_adress", $mailAdress);
        $statement->bindParam(":archive_name", $archiverName);
        $statement->bindParam(":user_password", $hashedPassword);
        $statement->execute();
        return $statement->rowCount() > 0;
    }
    
    public function getUserByMailAdress($mailAdress){
        $sql = "SELECT user_id, mail_adress, archive_name, user_password FROM archiveuser WHERE mail_adress = :mailAdress";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(":mailAdress", $mailAdress);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_OBJ);
        return $user;
    }
    public function getUserByID($userId){
        $sql = "SELECT user_id, mail_adress, archive_name, user_password FROM archiveuser WHERE user_id = :userId";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(":userId", $userId);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_OBJ);
        return $user;
    }
    public function upadteUserPasswordByMailAdress($mailAdress, $newPassword){
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE archiveuser SET user_password =:newPassword Where mail_adress =:mailAdress";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':newPassword', $hashedPassword);
        $statement->bindParam(':mailAdress', $mailAdress);
        $statement->execute();
        if($statement->rowCount() > 0){
            return true;
        }else{
            return false;
        }   
    }
    public function updateArchiverNameByMailAdress($mailAdress, $newUserName){
        $sql = "UPDATE archiveuser SET archive_name =:newArchiveName WHERE mail_adress = :mailAdress";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':newArchiveName', $newUserName);
        $statement->bindParam(':mailAdress',$mailAdress);
        $statement->execute();
        if($statement->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }
    public function updateMailAdressByMailAdress($mailAdres, $newMailAdress){
        $checkForCollison = $this->getUserByMailAdress($newMailAdress);
        if($checkForCollison !==null){
            return false;
        }else{
            $sql = "UPDATE archiveuser SET mail_adress = :newMailAdress WHERE mail_adress = :mailAdress";
            $statement = $this->pdo->prepare($sql);
            $statement->bindParam(':newMailAdress', $newMailAdress);
            $statement->bindParam(':mailAdress',$mailAdres);
            if($statement->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }
    }
    public function deleteArchiveUser($mailAdress){
        if(!$mailAdress){
            $failure = "No Data was received";
            return $failure;
        }else{
            $sqlUserWaitingOnDelete = $this->getUserByMailAdress($mailAdress);
            if($sqlUserWaitingOnDelete){
                $this->processUserData($sqlUserWaitingOnDelete->user_id);
                return true;
            }else{
                return false;
            }
        }
    }
    public function processUserData($userId){
        $sqlDeckIdentifier = "SELECT deck_id FROM decklists WHERE user_id = :userId";
        $statement = $this->pdo->prepare($sqlDeckIdentifier);
        $statement->bindParam(':deckId', $userId);
        $statement->execute();
        $deckDataIdentified = $statement->fetch(PDO::FETCH_OBJ);
        if($deckDataIdentified){
            $this->terminateDecklists($deckDataIdentified->deck_id);
            $this->terminateUser($userId);
            return true;
        }else{
            $this->terminateUser($userId);
            return true;
        }
    }
    public function terminateDecklists($deckId){
        $sqlDeleteDeckContent = "DELETE FROM cards_decklists WHERE deck_id LIKE :deckId";
        $statementContent = $this->pdo->prepare($sqlDeleteDeckContent);
        $statementContent->bindParam(':deckId',$deckId);
        $statementContent->execute();
        $sqlDeletDecklist = "DELETE FROM decklists WHERE user_id LIKE :userId";
        $statementDeckDeletor = $this->pdo->prepare($sqlDeletDecklist);
        $statementDeckDeletor->bindParam(':userId', $deckId);
        $statementDeckDeletor->execute();
    }
    public function terminateUser($userId){
        $sqlTerminateUser = "DELETE FROM archiveuser WHERE user_id= :userId";
        $statementTerminationFinal = $this->pdo->prepare($sqlTerminateUser);
        $statementTerminationFinal->bindParam(':userId',$userId);
        $statementTerminationFinal->execute();
        return true;
    }
}