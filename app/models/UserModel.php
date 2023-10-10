<?php

require_once './config.php';

class UserModel {
    private $dataBase;

    function __construct(){
        $this->dataBase = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
    }

    function getUserByUsername($username){
        $query = $this->dataBase->prepare('SELECT * FROM users WHERE username = ?');
        $query->execute([$username]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

}