<?php

namespace Chat\Repository;

use Chat\Entity\Users;

class UsersRepository extends AbstractRepository
{


    public function getConectedUser()
    {
        $statement = $this->pdo->prepare(' SELECT * FROM users WHERE active=TRUE ');
        $statement->setFetchMode(\PDO::FETCH_CLASS, Users::class);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findByUsername($username)
    {
        $statement = $this->pdo->prepare(' SELECT * FROM users WHERE username=:username');
        $statement->setFetchMode(\PDO::FETCH_CLASS, Users::class);
        $statement->execute(array("username"=>$username));
        return $statement->fetch();

    }

    public function login($params)
    {
        $statement = $this->pdo->prepare(' SELECT * FROM users WHERE username=:username , password = :password ');
        $statement->execute(array("username"=>$params['username'] ,'password' =>md5($params['password'])));
    }

    public function create($params)
    {
        $statement = $this->pdo->prepare("INSERT INTO users (username, password,created_at) VALUES (:username, :password,:created_at)");
        $statement->bindParam(':username', $params['username']);
        $statement->bindParam(':password',$params['password']);
        $statement->bindParam(':created_at',$params['created_at']);
        $statement->execute();
    }

    public function find($id)
    {
        $statement = $this->pdo->prepare(' SELECT * FROM users WHERE id=:id');
        $statement->setFetchMode(\PDO::FETCH_CLASS, Users::class);
        $statement->execute(array("id"=>$id));
        return $statement->fetch();
    }
}