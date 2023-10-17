<?php
require_once './app/models/ClubModel.php';
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

    function showClubes($case=0, $clubNew=null) {
        $clubes = $this->model->getClubes();
        if(!empty($clubes))
            $this->view->showClubes($clubes, $case, $clubNew);
        else 
            $this->view->showError('404: No se pudo acceder a los datos. Es posible que de momento no existan clubes cargados o han fueron eliminados');
    }
    
    function showClubById($id, $case=0) {
        $club = $this->model->getClubById($id);
        if(!empty($club)){
            $jugadores=$this->jugadorModel->getJugadoresConNombreDeClubByClubId($id);
            $this->view->showClub($club, $jugadores, $case);
        } else { 
            $this->view->showError('404: No se pudo acceder a los datos del club solicitado. Aún no se encuentran cargados o fueron eliminados');
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
            $this->view->showError("Por favor completar todos los campos antes de agregar");
            return;
        } 
        $id = $this->model->insertClub($nombre, $fecha_creacion, $ubicacion, $estadio, $campeonatos_locales);
        if ($id) {
            $club=$this->model->getClubById($id);
            $this->showClubes(1, $club);
        } else {
            $this->view->showError("Error, la carga del club ha fallado");
        }
    }

    function showClubAModificar($id){
        AuthHelper::verify();
        $club = $this->model->getClubById($id);
        $this->view->showClubModificar($club);
    }

    function modificarClub($id){
        AuthHelper::verify();
        if(isset($_POST['nombre']) && isset($_POST['fecha_creacion']) && isset($_POST['estadio']) && isset($_POST['campeonatos_locales'])&&
          !empty($_POST['nombre']) && !empty($_POST['fecha_creacion']) && !empty($_POST['estadio']) && !empty($_POST['campeonatos_locales'])){
            $nombre = $_POST['nombre'];
            $fecha_creacion = $_POST['fecha_creacion'];
            $estadio = $_POST['estadio'];
            $campeonatos_locales = $_POST ['campeonatos_locales'];

            $this->model->modificarClub($id, $nombre, $fecha_creacion, $estadio, $campeonatos_locales);
            $this->showClubById($id, 1);
        }
        else{
            $this->view->showError("Error, para modificar el club, verifica que todos los campos esten completos");
        }
    }

    function solicitudEliminarClub($id) {
        AuthHelper::verify();
        $jugadoresClubId=$this->jugadorModel->getJugadoresByClubId($id);
        if (empty($jugadoresClubId)) {
            $this->eliminarClub($id);
        } else {
            $club=$this->model->getClubById($id);
            $this->showClubes(2, $club);
        }
    }
    
    function eliminarClub($id) {
        AuthHelper::verify();
        $copiaClub=$this->model->getClubById($id);
        $this->model->borrarClubById($id);
        $clubEliminado=$this->model->getClubById($id);
        if (empty($clubEliminado)) {
            $this->showClubes(3, $copiaClub);
        } else {
            $this->view->showError("Error, el club no pudo eliminarse");
        }
    } 
}
