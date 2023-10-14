<?php
require_once './app/models/ClubModel.php';
require_once './app/views/ClubView.php';
require_once './app/helpers/AuthHelper.php';//agregar verificaciones y relogueos
//no deberiamos hacer una class padre "Controller"?
class ClubController {

    private $model;
    private $view;

    function __construct() {
        //por que tengo que reloguear al usuario acá? 
        //lo que deberiamos hacer en el constructor no es verificar si está logeado? "verify()"
        //AuthHelper::initialize();
        $this->view = new ClubView();
        $this->model = new ClubModel();
    }

    function showClubes(){
        //deberia usar una funcion que solo selectee los nombres y los ids de clubes?
        //creo que el profe dijo que le manderamos un * que no pasa nada...
        $clubes = $this->model->getClubes();
        if(!empty($clubes))
            $this->view->showClubes($clubes);
        else 
            //es necesario indicar el numero correspondiente a cada tipo de error?
            $this->view->showError('404: Los clubes aún no se encuentran cargados o fueron eliminados');
    }
    
    function showClubById($id){
        $club = $this->model->getClubById($id);
        if(!empty($club))
            $this->view->showClub($club);
        else 
            $this->view->showError('404: Los datos club aún no se encuentran cargados o fueron eliminados');
    }
    public function agregarClub() {

        // obtengo los datos del usuario
        $nombre = $_POST['nombre'];
        $fecha_creacion = $_POST['fecha_creacion'];
        $ubicacion = $_POST['ubicacion'];
        $estadio = $_POST['estadio'];
        //esto no se si es dato tipo input o string (pq en la tabla db tiene que ser input)
        $campeonatos_locales = $_POST['campeonatos_locales'];

        // como hacemos para no meter 234234 or en la validacion? podemos hacer alguna especie de for aca para que quede mas lindo?
        if (empty($nombre) || empty($fecha_creacion) || empty($ubicacion) || empty($estadio) || empty($campeonatos_locales)) {
            $this->view->showError("Completar el formulario para finalizar la carga");
            return;
            //aca no va un "die;" o meter el resto en un "else"??? 
            //los returns cortan la ejecucion de las funciones?
        }
        // esto podria hacer
        $id = $this->model->insertClub($nombre, $fecha_creacion, $ubicacion, $estadio, $campeonatos_locales);
        //insertClub() nunca va retornar null, pq si no se logra agregar un nuevo club va retornar el id del ultimo club de la tabla,
        // a menos que este completamente vacia. Que hace exactamente "lastInsertId()"?
        if ($id) {
                 //header('Location: ' . BASE_URL); no se como hacerlo de esta manera
                 $this->showClubes();
        } else {
                 $this->view->showError("Error, el club no se pudo cargar");
        }
    }

    function eliminarClub($id){
        $this->model->borrarClubById($id);
        //header('Location: ' . BASE_URL); no se como hacerlo de esta manera
        $this->showClubes();
    }  
}
