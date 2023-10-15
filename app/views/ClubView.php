<?php

class ClubView {

    function showError($error) {
        require_once './templates/Error.phtml';
    }
    function showClubes($clubes){
        require_once './templates/ListaClubes.phtml';
    }
    function showClub($club){
        require_once './templates/Club.phtml';
    }
}