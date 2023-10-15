<?php
require_once './app/views/HomeView.php';

class HomeController{

    private $view;

    function __construct() {
        AuthHelper::initialize();
        $this->view = new HomeView();
    }

    function showHome(){
        $this->view->showHome();
    }
}