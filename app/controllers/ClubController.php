<?php
require_once './app/models/ClubModel.php';
require_once './app/views/ClubView.php';
require_once './app/helpers/AuthHelper.php';

//no deberiamos hacer una class padre "Controller"?
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
    //puedo meterle otro parametro más, con el nombre del club eliminado aca
    //asi cuando te confirma te dice que club fue eliminado en el texto, pero creo que es sebarme
    function showClubes($case=0, $clubNew=null) {
        //deberia usar una funcion que solo selectee los nombres y los ids de clubes?
        //creo que el profe dijo que le manderamos un * que no pasa nada...
        $clubes = $this->model->getClubes();
        if(!empty($clubes))
            $this->view->showClubes($clubes, $case, $clubNew);
        else 
            //es necesario indicar el numero de error? como se si no es por problemas del servidor?
            //por ej (la tabla no esta vacia: no se pudo acceder por problemas del servidor o error de ejecucion en el pedido)
            //en esos casos el mensaje que estamos enviando es incorrecto
            $this->view->showError('404: No se pudo acceder a los datos. Es posible que de momento no existan clubes cargados o han fueron eliminados');
    }
    
    function showClubById($id, $case=0) {
        $club = $this->model->getClubById($id);
        if(!empty($club))
            $this->view->showClub($club);
        else 
            $this->view->showError('404: No se pudo acceder a los datos. Los datos del club aún no se encuentran cargados o fueron eliminados');
    }

    public function agregarClub() {
        AuthHelper::verify();
        $nombre = $_POST['nombre'];
        $fecha_creacion = $_POST['fecha_creacion'];
        $ubicacion = $_POST['ubicacion'];
        $estadio = $_POST['estadio'];
        //esto no se si es dato tipo input o string (pq en la tabla db tiene que ser input)
        $campeonatos_locales = $_POST['campeonatos_locales'];

        // como hacemos para no meter 234234 or en la validacion? podemos hacer alguna especie de for aca para que quede mas lindo?
        // meter en $_POST en un array (o $_POST ya es un array?) y recorrerlo con el empty().. algo asi 
        if (empty($nombre) || empty($fecha_creacion) || empty($ubicacion) || empty($estadio) || empty($campeonatos_locales)) {
            $this->view->showError("Por favor completar todos los campos antes de agregar");
            return;
        }
        //aca no va un "die;" un "break;" o meter el resto de la funcion en un else? 
        //los returns cortan la ejecucion de las funciones?
        
        $id = $this->model->insertClub($nombre, $fecha_creacion, $ubicacion, $estadio, $campeonatos_locales);
        // A menos que la table este completamente vacia "insertClub()" nunca va retornar null
        // pq si no se logra agregar un nuevo club te va retornar el id del ultimo club que tenga la tabla...
        // O q hace exactamente "lastInsertId()"???
        if ($id) {
                 /* no puedo hacerlo de esta manera porque necesito meterle un parametro
                 header('Location: ' . BASE_URL . '/listarClubes/1');
                 está mal? */
                 $this->showClubes(1);
        } else {
                 $this->view->showError("Error, la carga de club ha fallado");
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
            $this->view->showError("Error al modificar el club, verifica que todos los campos esten completos");
        }
    }

    function solicitudEliminarClub($id) {
        AuthHelper::verify();
        $JugadoresIdClub=$this->jugadorModel->getJugadoresIdByClubId($id);
        if (empty($JugadoresIdClub)) {
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
        //aca no se si va "isset" o "empty" creo que isset va, sino lo de arriba(solicitarEli) no tiene sentido...
        if (empty($clubEliminado)) {
            $this->showClubes(3, $copiaClub);
        } else {
            $this->view->showError("Error, el club no pudo eliminarse");
        }
    } 
}
