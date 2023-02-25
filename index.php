<?php
session_start();

ob_start();

    
//carregar o Composer
require './vendor/autoload.php';
//Instanciar a classe ConfigController, responsável por tratar a URL
$home = new Core\ConfigController();
//Instanciar o método para carregar a página/controller
$home->loadPage();
