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

    function getJugadoresIdByClubId($id){
        $query = $this->dataBase->prepare('SELECT id_jugador FROM jugadores WHERE id_club = ?');
        $query->execute([$id]);

        $jugadoresId = $query->fetch(PDO::FETCH_OBJ);
        return $jugadoresId;
    }

    function insertClub($nombre, $fecha_creacion, $ubicacion, $estadio, $campeonatos_locales) {
        $query = $this->dataBase->prepare('INSERT INTO clubes (nombre, fecha_creacion, ubicacion, estadio, campeonatos_locales) VALUES(?,?,?,?,?)');
        $query->execute([$nombre, $fecha_creacion, $ubicacion, $estadio, $campeonatos_locales]);
        //si esta funcion retorna el id_club del ultimo club agregado a la tabla
        // mientras la tabla no este vacia, siempre va retornar algo... incluso si el insert falla
        return $this->dataBase->lastInsertId();
    }

    function modificarClub($id, $nombre, $fecha_creacion, $estadio, $campeonatos_locales){
        $query = $this->dataBase->prepare('UPDATE clubes SET nombre = ?, fecha_creacion = ?, estadio = ?, campeonatos_locales = ? WHERE id_club = ?');
        $query->execute([$nombre, $fecha_creacion, $estadio, $campeonatos_locales, $id]);
    }

/* esta mal que vacie club y lo elimine en la misma funcion model, hay que desglosarlo? */
    function borrarClubById($id){
        $query = $this->dataBase->prepare('DELETE FROM jugadores WHERE id_club = ?');
        $query->execute([$id]);
        $query = $this->dataBase->prepare('DELETE FROM clubes WHERE id_club = ?');
        $query->execute([$id]);
    }
}