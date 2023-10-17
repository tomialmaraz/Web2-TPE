<?php
 require_once './app/models/UserModel.php';
 require_once './app/views/AuthView.php';
 require_once './app/helpers/AuthHelper.php';

class AuthController {

    private $view;
    private $model;

    function __construct() {
        $this->view = new AuthView();
        $this->model = new UserModel();
    }

    function showLogin(){
        $this->view->showLogin();
    }

    public function logout() {
        AuthHelper::logout();
        header('Location: ' . BASE_URL . '/login');    
    }

    function authenticate(){
        if (!empty($_POST['username']) && !empty($_POST['password'])){
            $username = $_POST['username'];
            $password = $_POST['password'];
            //Obtengo los datos ingresados por usuario

            $user = $this->model->getUserByUsername($username);
            //agarro al usuario entero y verifico si existe y si coincide la contraseña
            if($user && password_verify($password, $user->password)){
                AuthHelper::login($user);
                header('Location: ' . BASE_URL);
            } 
            else{
                $this->view->showLogin('Datos incorrectos');
            }
        }
        else{
            $this->view->showLogin('Campos sin rellenar');
        }
    }
}