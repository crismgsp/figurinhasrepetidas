<?php

namespace App\adms\Controllers;



class Inicio
{
    private $data;

  
    public function index(): void
    {

        $this->data = "";

                
        $loadView = new \Core\ConfigView("adms/Views/inicio", $this->data);
        $loadView->loadView();
    }
}