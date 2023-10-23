<?php

class ClubView {

    function showClubes($clubes, $llamadoDesde, $idClubAEliminar){
        require_once './templates/listaClubes.phtml';
    }

    function showClub($club, $jugadores, $llamadoDesde){
        require_once './templates/Club.phtml';
    }

    function showClubModificar($club){
        require_once './templates/FormularioModificarClub.phtml';
    }

    function showError($error){
        require_once './templates/error.phtml';
    }
}