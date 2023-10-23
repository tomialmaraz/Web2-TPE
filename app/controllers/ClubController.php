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

    function showClubes($llamadoDesde=null, $idClubAEliminar=null) {
        $clubes = $this->model->getClubes();
        if(!empty($clubes))
            $this->view->showClubes($clubes, $llamadoDesde, $idClubAEliminar);
        else 
            $this->view->showError('404: No se pudo acceder a los datos. Es posible que de momento no existan clubes cargados o han fueron eliminados');
    }
    
    function showClubById($id, $llamadoDesde='') {
        $club = $this->model->getClubById($id);
        if(!empty($club)){
            $jugadores=$this->jugadorModel->getJugadoresConNombreDeClubByClubId($id);
            $this->view->showClub($club, $jugadores, $llamadoDesde);
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
            $this->view->showError('Por favor completar todos los campos antes de agregar');
            return;
        } 
        $id = $this->model->insertClub($nombre, $fecha_creacion, $ubicacion, $estadio, $campeonatos_locales);
        if ($id) {
            header('Location: ' . BASE_URL . "/listarClubes/agregarClub/''");
        } else {
            $this->view->showError('Error, la carga del club ha fallado');
        }
    }

    function showClubAModificar($id){
        AuthHelper::verify();
        $club = $this->model->getClubById($id);
        $this->view->showClubModificar($club);
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
            //como verifico si los datos se modificaron correctamente en la db? antes de dar el mensaje de confirmacion
            header('Location: ' . BASE_URL . "/club/$id/modificarClub");
        }
        else{
            $this->view->showError('Error, para modificar el club, verifica que todos los campos esten completos');
        }
    }

    function solicitudEliminarClub($id) {
        AuthHelper::verify();
        $jugadoresClubId=$this->jugadorModel->getJugadoresConNombreDeClubByClubId($id);
        if (empty($jugadoresClubId)) {
            $this->eliminarClub($id);
        } else {
            header('Location: ' . BASE_URL . "/listarClubes/solicitudEliminarClub/$id");
        }
    }
    
    function eliminarClub($id) {
        AuthHelper::verify();
        $copiaClub=$this->model->getClubById($id);
        $this->jugadorModel->borrarJugadoresByIdClub($id);
        $this->model->borrarClubById($id);

        $clubEliminado=$this->model->getClubById($id);
        if (empty($clubEliminado)) {
            header('Location: ' . BASE_URL . "/listarClubes/eliminarClub/''");
        } else {
            $this->view->showError('Error, el club no pudo eliminarse');
        }
    } 
}
