<?php

namespace App\adms\Controllers;


class Todasfigurinhas
{
  
    private $data;

     
    
    public function index(): void
    {
       
        $figur =  new \App\adms\Models\AdmsFigurinhas();
        $figurinhas = $figur->listSelect();

        $this->data['figurinhas'] = $figurinhas;

        

        $loadView = new \Core\ConfigView("adms/Views/todasfigurinhas", $this->data);
        $loadView->loadView(); 
    }
        
        
}



