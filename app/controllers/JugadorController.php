<?php
require_once './app/models/JugadorModel.php';
require_once './app/views/JugadorView.php';
require_once './app/models/ClubModel.php';
require_once './app/helpers/AuthHelper.php';

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
        //obtengo jugadores
        $jugadores = $this->model->getJugadoresClubes();
        
        $clubes = $this->clubModel->getClubes();
        //obtengo los clubes y se lo mando a la vista porque cuando muestra los jugadores
        //puede agregar nuevos(si esta logueado) y cuando agrega necesita cada nombre de club
        //para el select del formulario agregar.
        $this->view->showJugadores($jugadores, $clubes);
    }

    function showJugadorById($id){
        $jugador = $this->model->getJugadorById($id);
        $this->view->showJugador($jugador);
    }

    function showJugadorAModificar($id){
        //con solo verificar en la funcion de modificar jugador mas abajo ya es suficiente
        //pero tambien verifico aca para que no puedan entrar a el template de modificar jugador
        //(por mas que no ande) no tendria sentido que entren
        AuthHelper::verify();
        $jugador = $this->model->getJugadorById($id);
        $clubes = $this->clubModel->getClubes();
        $this->view->showJugadorAModificar($jugador, $clubes);
    }

    function agregarJugador(){
        AuthHelper::verify();
        if(isset($_POST['nombre']) && isset($_POST['edad']) && isset($_POST['nacionalidad']) &&  isset($_POST['posicion']) &&  isset($_POST['pie_habil']) &&  isset($_POST['id_club']) &&
        !empty($_POST['nombre']) && !empty($_POST['edad']) && !empty($_POST['nacionalidad']) && !empty($_POST['posicion']) && !empty($_POST['pie_habil']) && !empty($_POST['id_club'])){
            $nombre = $_POST['nombre'];
            $edad = $_POST['edad'];
            $nacionalidad = $_POST['nacionalidad'];
            $posicion = $_POST ['posicion'];
            $pie_habil = $_POST ['pie_habil'];
            $id_club = $_POST ['id_club'];

            $id = $this->model->agregarJugador($nombre, $edad, $nacionalidad, $posicion, $pie_habil, $id_club);
            if ($id) {
                header('Location: ' . BASE_URL . '/listarJugadores');
            } else {
                $this->view->showError("Error al insertar jugador");
            }
        }
        else{
            $this->view->showError("Error al Insertar Jugador, todos los campos deben estar completos");
        }
    }

    function modificarJugador($id){
        AuthHelper::verify();
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
            $this->view->showError("Error al Modificar Jugador, verifica que todos los campos esten completos");
        }
    }

    function eliminarJugador($id){
        AuthHelper::verify();
        $this->model->borrarJugador($id);
        header('Location: ' . BASE_URL . '/listarJugadores');
    }

}