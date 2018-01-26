<?php
namespace Chat\Repository;

use Chat\Entity\Messages;

class MessagesRepository extends AbstractRepository
{

    public function findAll()
    {
        $statement = $this->pdo->prepare(' SELECT * FROM messages');
        $statement->setFetchMode(\PDO::FETCH_CLASS, Messages::class);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function create($params)
    {
        $statement = $this->pdo->prepare("INSERT INTO messages (message, created_at,author,receiver) VALUES (:message, :created_at,:author,:receiver)");
        $statement->bindParam(':message', $params['message']);
        $statement->bindParam(':created_at',$params['created_at']);
        $statement->bindParam(':author',$params['author']);
        $statement->bindParam(':receiver',$params['receiver']);
        $statement->execute();
    }
    public function findMessageUser($author,$receiver)
    {
        $statement = $this->pdo->prepare('SELECT * FROM messages WHERE receiver IS NOT null AND (author = :author OR receiver = :receiver)  ');
        $statement->setFetchMode(\PDO::FETCH_CLASS, Messages::class);
        $statement->bindParam('author', $receiver);
        $statement->bindParam('receiver', $receiver);
        $statement->bindParam('author', $author);
        $statement->bindParam('receiver', $author);
        $statement->execute();
        return$statement->fetchAll();
    }
}