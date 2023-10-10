<?php
require_once './app/controllers/AuthController.php';
require_once './app/controllers/JugadorController.php';

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

$action = 'listarJugadores'; // accion por defecto
if (!empty( $_GET['action'])) {
    $action = $_GET['action'];
}

// listar    ->         taskController->showTasks();
// agregar   ->         taskController->addTask();
// eliminar/:ID  ->     taskController->removeTask($id); 
// finalizar/:ID  ->    taskController->finishTask($id);
// about ->             aboutController->showAbout();
// login ->             authContoller->showLogin();
// logout ->            authContoller->logout();
// auth                 authContoller->auth(); // toma los datos del post y autentica al usuario

// parsea la accion para separar accion real de parametros
$params = explode('/', $action);

switch ($params[0]) {
    case 'listarJugadores':
        $controller = new JugadorController();
        $controller->showJugadores();
        break;
    case 'jugador':
        $controller = new JugadorController();
        $controller->showJugadorById($params[1]);
        break;
    case 'eliminarJugador':
        $controller = new JugadorController();
        $controller->eliminarJugador($params[1]);
        break;
    case 'login':
        $controller = new AuthController();
        $controller->showLogin();
        break;
    case 'auth':
        $controller = new AuthController();
        $controller->authenticate();
        break;
    /* case 'agregar':
        $controller = new TaskController();
        $controller->addTask();
        break;
    case 'finalizar':
        $controller = new TaskController();
        $controller->finishTask($params[1]);
        break;
    case 'about':
        $controller = new AboutController();
        $controller->showAbout();
        break;*/
    /* case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;  */
    default: 
        echo "404 Page Not Found";
        break;
}