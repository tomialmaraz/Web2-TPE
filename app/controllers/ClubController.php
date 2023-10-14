<?php
require_once './app/models/ClubModel.php';
require_once './app/views/ClubView.php';
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

    function eliminarClub($id){
        $this->model->borrarClubById($id);
        //header('Location: ' . BASE_URL); no se como hacerlo de esta manera
        $this->showClubes();
    }  
}
