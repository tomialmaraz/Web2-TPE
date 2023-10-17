<?php

class ClubView {

    function showClubes($clubes, $posMsj, $clubNew){
        switch ($posMsj) {
            case '0':
                require_once './templates/Header.phtml';  
                require_once './templates/ListaClubes.phtml';
                require_once './templates/FormAgregarClub.phtml';
                require_once './templates/Footer.phtml'; 
                break;
            case '1':
                require_once './templates/Header.phtml';  
                require_once './templates/ListaClubes.phtml';
                require_once './templates/MensajeCorrectoAgregarClub.phtml';
                require_once './templates/FormAgregarClub.phtml';
                require_once './templates/Footer.phtml'; 
                break;
            case '2':
                require_once './templates/Header.phtml';  
                require_once './templates/ListaClubes.phtml';
                require_once './templates/AdvertenciaEliminarClub.phtml';
                require_once './templates/FormAgregarClub.phtml';
                require_once './templates/Footer.phtml'; 
                break;
            case '3':
                require_once './templates/Header.phtml';  
                require_once './templates/ListaClubes.phtml';
                require_once './templates/MensajeCorrectoEliminarClub.phtml';
                require_once './templates/FormAgregarClub.phtml';
                require_once './templates/Footer.phtml'; 
                break;
            default: 
                require_once './templates/Header.phtml';  
                require_once './templates/ListaClubes.phtml';
                require_once './templates/FormAgregarClub.phtml';
                require_once './templates/Footer.phtml'; 
                break;
        }
    }

    function showClub($club, $jugadores, $posMsj=0){
        switch ($posMsj) {
            case '0':
                require_once './templates/Header.phtml';  
                require_once './templates/Club.phtml';
                require_once './templates/Footer.phtml';
                break;
            case '1':
                require_once './templates/Header.phtml';  
                require_once './templates/Club.phtml';
                require_once './templates/MensajeCorrectoModificarClub.phtml';
                require_once './templates/Footer.phtml';
                break;
            default: 
                require_once './templates/Header.phtml';  
                require_once './templates/Club.phtml';
                require_once './templates/Footer.phtml';
                break;
        } 
    }

    function showClubModificar($club){
        require_once './templates/FormularioModificarClub.phtml';
    }

    function showError($error) {
        require_once './templates/error.phtml';
    }
}