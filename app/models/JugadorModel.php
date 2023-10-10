<?php

require_once './config.php';

class JugadorModel extends UserModel{
    private $dataBase;

    function __construct(){
        $this->dataBase = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
    }

    function getJugadores(){
        $query = $this->dataBase->prepare('SELECT jugadores.*, clubes.nombre AS nombre_club FROM jugadores INNER JOIN clubes ON jugadores.id_club = clubes.id_club');
        $query->execute();

        $jugadores = $query->fetchAll(PDO::FETCH_OBJ);
        return $jugadores;
    }

    function getJugadorById($id){
        $query = $this->dataBase->prepare('SELECT jugadores.*, clubes.nombre AS nombre_club FROM jugadores INNER JOIN clubes ON jugadores.id_club = clubes.id_club WHERE id_jugador = ?');
        $query->execute([$id]);

        $jugador = $query->fetch(PDO::FETCH_OBJ);
        return $jugador;
    }

    function borrarJugador($id){
        $query = $this->dataBase->prepare('DELETE FROM jugadores WHERE id_jugador = ?');
        $query->execute([$id]);
    }

    //ME FALTA FUNCION DE AGREGAR JUGADOR Y FUNCION DE MODIFICAR

}