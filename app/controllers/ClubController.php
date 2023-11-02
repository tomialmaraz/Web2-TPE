<?php
require_once './app/models/ClubModel.php';
require_once './app/models/JugadorModel.php';
require_once './app/views/ClubView.php';
require_once './app/helpers/AuthHelper.php';

class ClubController {

    private $model;
    private $jugadorModel;
    private $view;

    function __construct() {
        AuthHelper::initialize();

        $this->view = new ClubView();
        $this->model = new ClubModel();
        $this->jugadorModel = new JugadorModel();
    }

    function showClubes() {
        $clubes = $this->model->getClubes();
        if(!empty($clubes)){
            $this->view->showClubes($clubes);
        } else {
            $this->view->showError('No se pudo acceder a los datos. Es posible que de momento no
                 existan clubes cargados o hayan sido eliminados');
        }
    }
    
    function showClubById($id) {
        $club = $this->model->getClubById($id);
        if(!empty($club)) {
            $jugadores=$this->jugadorModel->getJugadoresConNombreDeClubByClubId($id);
            $this->view->showClub($club, $jugadores);
        } else { 
            $this->view->showError('No se pudo acceder a los datos del club solicitado. 
                Aún no se encuentran cargados o fueron eliminados');
        }
    }

    public function agregarClub() {
        AuthHelper::verify();
        $nombre = $_POST['nombre'];
        $fecha_creacion = $_POST['fecha_creacion'];
        $ubicacion = $_POST['ubicacion'];
        $estadio = $_POST['estadio'];
        $campeonatos_locales = $_POST['campeonatos_locales'];

        if (empty($nombre) || empty($fecha_creacion) || empty($ubicacion) || empty($estadio) || empty($campeonatos_locales)) {
            $this->view->showError('Por favor completar todos los campos antes de agregar');
            return;
        } 
        $id = $this->model->insertClub($nombre, $fecha_creacion, $ubicacion, $estadio, $campeonatos_locales);
        if ($id) {
            header('Location: ' . BASE_URL . "listarClubes");
        } else {
            $this->view->showError('Error, la carga del club ha fallado');
        }
    }

    function showClubAModificar($id){
        AuthHelper::verify();
        $club = $this->model->getClubById($id);
        if(!empty($club)) {
        $this->view->showClubModificar($club);
        } else {
            $this->view->showError('No se pudo acceder a los datos del club solicitado. 
                Aún no se encuentran cargados o fueron eliminados');
        }
    }

    function modificarClub($id){
        AuthHelper::verify();
        if(isset($_POST['nombre']) && isset($_POST['fecha_creacion']) && isset($_POST['ubicacion']) && isset($_POST['estadio']) && isset($_POST['campeonatos_locales'])&&
          !empty($_POST['nombre']) && !empty($_POST['fecha_creacion']) && !empty($_POST['ubicacion']) && !empty($_POST['estadio']) && !empty($_POST['campeonatos_locales'])){
            $nombre = $_POST['nombre'];
            $fecha_creacion = $_POST['fecha_creacion'];
            $ubicacion = $_POST['ubicacion'];
            $estadio = $_POST['estadio'];
            $campeonatos_locales = $_POST ['campeonatos_locales'];

            $this->model->modificarClub($id, $nombre, $fecha_creacion, $ubicacion, $estadio, $campeonatos_locales);
            $this->view->showMensaje("Se modifico correctamente");
        } else {
            $this->view->showError('Error, para modificar el club, verifica que todos los campos esten completos');
        }
    }

    function solicitudEliminarClub($id) {
        AuthHelper::verify();
        $jugadoresClubId=$this->jugadorModel->getJugadoresConNombreDeClubByClubId($id);
        if (empty($jugadoresClubId)) {
            $this->eliminarClub($id);
        } else {
            $this->view->showAdvertenciaEliminarClub($id);
        }
    }
    
    function eliminarClub($id) {
        AuthHelper::verify();
        $this->jugadorModel->borrarJugadoresByIdClub($id);
        $this->model->borrarClubById($id);
        $clubEliminado=$this->model->getClubById($id);
        if (empty($clubEliminado)) {
            header('Location: ' . BASE_URL . "listarClubes");
        } else {
            $this->view->showError('Error, el club no pudo eliminarse');
        }
    } 
}
