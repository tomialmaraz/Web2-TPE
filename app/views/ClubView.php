<?php

class ClubView {

    function showClubes($clubes){
        require_once './templates/listaClubes.phtml';
    }

    function showClub($club, $jugadores){
        require_once './templates/Club.phtml';
    }

    function showClubModificar($club){
        require_once './templates/FormularioModificarClub.phtml';
    }

    function showError($error){
        require_once './templates/error.phtml';
    }
    
    public function showMensaje($mensaje) {
        require_once 'templates/MensajeCorrecto.phtml';
    }
    
    function showAdvertenciaEliminarClub($idClubAEliminar){
        require_once 'templates/AdvertenciaEliminarClub.phtml';
    }
}