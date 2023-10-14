<?php
//si las "define" son variables constantes y globales, para que las incluyo? 
//deberian ser accesibles por todos los archivos del programa
require_once './config.php';
//deberiamos crear una class padre "Model"?
class ClubModel {
    private $dataBase;

    function __construct(){
        $this->dataBase = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
    }
 
    function getClubes(){
        $query = $this->dataBase->prepare('SELECT * FROM clubes');
        $query->execute();

        $clubes = $query->fetchAll(PDO::FETCH_OBJ);
        return $clubes;
    }
    function getClubById($id){
        $query = $this->dataBase->prepare('SELECT * FROM clubes WHERE id_club = ?');
        $query->execute([$id]);

        $club = $query->fetch(PDO::FETCH_OBJ);
        return $club;
    }

    function insertClub($nombre, $fecha_creacion, $ubicacion, $estadio, $campeonatos_locales) {
        $query = $this->dataBase->prepare('INSERT INTO clubes (nombre, fecha_creacion, ubicacion, estadio, campeonatos_locales) VALUES(?,?,?,?,?)');
        $query->execute([$nombre, $fecha_creacion, $ubicacion, $estadio, $campeonatos_locales]);
                            // y esta funcion??? supongo que retorna el ultimo id_club que tenga la tabla o el siguente del ultimo? ni idea
        return $this->dataBase->lastInsertId();
    }

    function borrarClubById($id){
        $query = $this->dataBase->prepare('DELETE FROM clubes WHERE id_club = ?');
        $query->execute([$id]);
    }
}