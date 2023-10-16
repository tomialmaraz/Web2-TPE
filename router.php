<?php
require_once './app/controllers/AuthController.php';
require_once './app/controllers/JugadorController.php';
require_once './app/controllers/ClubController.php';
require_once './app/controllers/HomeController.php';

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

$action = 'home'; // accion por defecto
if (!empty( $_GET['action'])) {
    $action = $_GET['action'];
}

// (ir al home)                     home                        ->    HomeController()->showHome();
// (ver una lista de los jugadores) listarJugadores             ->    JugadorController->showJugadores();
// (ver en detalle un jugador)      jugador/id_jugador          ->    JugadorController->showJugadorById($id);
// (ver form modificar-jugador)     formModificarJugador        ->    JugadorController->showJugadorAModificar($id)
// (aplicar datos form mod-jugador) modificarJugador            ->    JugadorController->modificarJugador($id)
// (agregar a un nuevo jugador)     agregarJugador              ->    JugadorController->agregarJugador();
// (eliminar a un jugador)          eliminarJugador/id_jugador  ->    JugadorController->eliminarJugador($id);
// (ver una lista de los clubes)    listarClubes                ->    ClubController->showClubes()  
// (ver en detalle un club)         club/id_club                ->    ClubController->showClubById($id);
// (ver form modificar-club)        formModificarClub/id_club   ->    ClubController->showClubAModificar();
// (modificar datos de un club)     modificarClub/id_club       ->    ClubController->modificarClub();
// (agregar un nuevo club)          agregarClub                 ->    ClubController->agregarClub();
// (eliminar un club)               eliminarClub/id_club        ->    ClubController->solicitudEliminarClub($id);
// (iniciar una sesion)             login                       ->    authContoller->showLogin();
// (cerrar la sesion actual)        logout                      ->    authContoller->logout();

//esto no va el router? no lo hace el controller?
// auth                          ->    authContoller->auth(); // toma los datos del post y autentica al usuario


$params = explode('/', $action);

switch ($params[0]) {
    case 'home':
        $controller = new HomeController();
        $controller->showHome();
        break;
    case 'listarJugadores':
        $controller = new JugadorController();
        $controller->showJugadores();
        break;
    case 'jugador':
        $controller = new JugadorController();
        $controller->showJugadorById($params[1]);
        break;
    case 'formModificarJugador':
        $controller = new JugadorController();
        $controller->showJugadorAModificar($params[1]);
        break;
    case 'modificarJugador':
        $controller = new JugadorController();
        $controller->modificarJugador($params[1]);
        break;
    case 'agregarJugador':
        $controller = new JugadorController();
        $controller->agregarJugador();
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
    case 'formModificarClub':
        $controller = new ClubController();
        $controller->showClubAModificar($params[1]);
        break;
    case 'modificarClub':
        $controller = new ClubController();
        $controller->modificarClub($params[1]);
        break;
    case 'agregarClub':
        $controller = new ClubController();
        $controller->agregarClub();
        break;
    case 'solicitudEliminarClub':
        $controller = new ClubController();
        $controller->solicitudEliminarClub($params[1]);
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
        // quien llama a esto?
    case 'auth':
        $controller = new AuthController();
        $controller->authenticate();
        break;
    default: 
        echo "404 Page Not Found";
        break;
}