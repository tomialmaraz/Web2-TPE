<?php
require_once './app/models/JugadorModel.php';
require_once './app/views/JugadorView.php';
require_once './app/models/ClubModel.php';

class JugadorController {

    private $view;
    private $model;
    private $clubModel;

    function __construct() {
        AuthHelper::initialize();

        $this->view = new JugadorView();
        $this->model = new JugadorModel();
        $this->clubModel = new ClubModel();
    }

    function showJugadores(){
        $jugadores = $this->model->getJugadoresClubes();
        $clubes = $this->clubModel->getClubes();
        $this->view->showJugadores($jugadores, $clubes);
    }

    function showJugadorById($id){
        $jugador = $this->model->getJugadorById($id);
        $this->view->showJugador($jugador);
    }

    function showJugadorAModificar($id){
        $jugador = $this->model->getJugadorById($id);
        $clubes = $this->clubModel->getClubes();
        $this->view->showJugadorAModificar($jugador, $clubes);
    }

    function agregarJugador(){
        if(isset($_POST['nombre']) && isset($_POST['edad']) && isset($_POST['nacionalidad']) &&  isset($_POST['posicion']) &&  isset($_POST['pie_habil']) &&  isset($_POST['id_club']) &&
        !empty($_POST['nombre']) && !empty($_POST['edad']) && !empty($_POST['nacionalidad']) && !empty($_POST['posicion']) && !empty($_POST['pie_habil']) && !empty($_POST['id_club'])){
            $nombre = $_POST['nombre'];
            $edad = $_POST['edad'];
            $nacionalidad = $_POST['nacionalidad'];
            $posicion = $_POST ['posicion'];
            $pie_habil = $_POST ['pie_habil'];
            $id_club = $_POST ['id_club'];

            $this->model->agregarJugador($nombre, $edad, $nacionalidad, $posicion, $pie_habil, $id_club);
            header('Location: ' . BASE_URL);
        }
        else{
            $this->view->showError("Error al Insertar Jugador");
        }
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