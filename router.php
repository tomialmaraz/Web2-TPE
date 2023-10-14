<?php
require_once './app/controllers/AuthController.php';
require_once './app/controllers/JugadorController.php';
require_once './app/controllers/ClubController.php';

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

$action = 'listarJugadores'; // accion por defecto
if (!empty( $_GET['action'])) {
    $action = $_GET['action'];
}

// listarJugadores               ->    JugadorController->showJugadores();
// verDetalleJugador/id_jugador  ->    JugadorController->showJugadorById($id);
// editarJugador                 ->    JugadorController->
// eliminarJugador/id_jugador    ->    JugadorController->eliminarJugador($id);
// agregarJugador                ->    JugadorController->agregarJugador();
// listarClubes                  ->    ClubController->showClubes()  
// verDetalleClub/id_club        ->    ClubController->showClubById($id);
// editarClub                    ->    ClubController->editarClub();
// eliminarClub/id_club          ->    ClubController->eliminarClub($id);
// agregarClub                   ->    ClubController->agregarClub();
// login                         ->    authContoller->showLogin();
// logout                        ->    authContoller->logout();
// auth                          ->    authContoller->auth(); // toma los datos del post y autentica al usuario


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
    case 'listarClubes':
        $controller = new ClubController();
        $controller->showClubes();
        break;
    case 'club':
        $controller = new ClubController();
        $controller->showClubById($params[1]);
        break;
    case 'eliminarClub':
        $controller = new ClubController();
        $controller->eliminarClub($params[1]);
        break;
    case 'login':
        $controller = new AuthController();
        $controller->showLogin();
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
    case 'auth':
        $controller = new AuthController();
        $controller->authenticate();
        break;
    /* case 'agregar':
        $controller = new TaskController();
        $controller->addTask();
        break;
        */
    default: 
        echo "404 Page Not Found";
        break;
}