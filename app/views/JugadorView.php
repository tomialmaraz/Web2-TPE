<?php

class JugadorView {

    function showJugadores($jugadores){
        require_once './templates/ListaJugadores.phtml';
    }

    function showJugador($jugador){
        require_once './templates/Jugador.phtml';
    }

}