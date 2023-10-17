<?php

class JugadorView {

    function showJugadores($jugadores, $clubes){
        require_once './templates/ListaJugadores.phtml';
    }

    function showJugador($jugador){
        require_once './templates/Jugador.phtml';
    }

    function showJugadorAModificar($jugador, $clubes){
        require_once './templates/FormularioModificarJugador.phtml';
    }

    public function showError($error) {
        require_once 'templates/Error.phtml';
    }

    public function showMensaje($mensaje) {
        require_once 'templates/MensajeCorrecto.phtml';
    }

}