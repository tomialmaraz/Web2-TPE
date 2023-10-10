<?php
require_once './app/models/JugadorModel.php';
require_once './app/views/JugadorView.php';

class JugadorController {

    private $view;
    private $model;

    function __construct() {
        AuthHelper::initialize();

        $this->view = new JugadorView();
        $this->model = new JugadorModel();
    }
    // todo mal si le metomos un switch a esta?
    function showJugadores(){
        $jugadores = $this->model->getJugadoresClubes();
        $this->view->showJugadores($jugadores);
    }

    function showJugadoresByClub($club){
        $jugadores = $this->model->getJugadoresByClub($club);
        $this->view->showJugadores($jugadores);
    }

    function showJugadoresByPosicion($posicion){
        $jugadores = $this->model->getJugadoresByPosicion($posicion);
        $this->view->showJugadores($jugadores);
    }

    function showJugadorById($id){
        $jugador = $this->model->getJugadorById($id);
        $this->view->showJugador($jugador);
    }

    function eliminarJugador($id){
        $this->model->borrarJugador($id);
        header('Location: ' . BASE_URL);
    }

}