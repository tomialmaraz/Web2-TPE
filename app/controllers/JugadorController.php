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

    function showJugadores(){
        $jugadores = $this->model->getJugadores();
        $this->view->showJugadores($jugadores);
    }

    function showJugadorById($id){
        $jugador = $this->model->getJugadorById($id);
        $this->view->showJugador($jugador);
    }

    function showJugadorAModificar($id){
        $jugador = $this->model->getJugadorById($id);
        $this->view->showJugadorAModificar($jugador);
    }

    

    function modificarJugador($id){
        if(isset($_POST['nombre']) && isset($_POST['edad']) && isset($_POST['nacionalidad']) &&  isset($_POST['posicion']) &&  isset($_POST['pie_habil']) &&  isset($_POST['id_club']) &&
        !empty($_POST['nombre']) && !empty($_POST['edad']) && !empty($_POST['nacionalidad']) && !empty($_POST['posicion']) && !empty($_POST['pie_habil']) && !empty($_POST['id_club'])){
            $nombre = $_POST['nombre'];
            $edad = $_POST['edad'];
            $nacionalidad = $_POST['nacionalidad'];
            $posicion = $_POST ['posicion'];
            $pie_habil = $_POST ['pie_habil'];
            $id_club = $_POST ['id_club'];

            $this->model->modificarJugador($id, $nombre, $edad, $nacionalidad, $posicion, $pie_habil, $id_club);
            $this->view->showMensaje("Se modifico correctamente");
        }
        else{
            $this->view->showError("Error al Modificar Jugador");
        }
    }

    function eliminarJugador($id){
        $this->model->borrarJugador($id);
        header('Location: ' . BASE_URL);
    }

}