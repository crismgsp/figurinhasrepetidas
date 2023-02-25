<?php

namespace App\adms\Controllers;

/**
 * Controller da pagina de buscar figurinhas
 */
class Buscar
{
    /** @var $data recebe os dados que devem ser enviados */
    private $data;

      /** @var $dataForm */
    private $dataForm;

    private $searchName;
    private $searchFigurinha;

     

    public function index()
    {      
         $listFigurinhas = new \App\adms\Models\AdmsFigurinhas();
         $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
       
        
            if(!empty($this->dataForm['SendSearchUser'])) {
                
                $this->searchName = $this->dataForm['search_name'];
                $this->searchFigurinha = $this->dataForm['search_figurinha'];
                        
                
                $listFigurinhas->listSearchUsers($this->searchName, $this->searchFigurinha);

                $this->data['form']['search_name'] = $this->searchName;    
                $this->data['form']['search_figurinha'] = $this->searchFigurinha;  

                $this->data = $listFigurinhas->getResultBd2(); 
                //var_dump($this->data);

               
            
            }     
            else{  //quando nao tiveer peesquisanddo  nao lista nada na busca
                //$listFigurinhas->listUsers();
                //$this->data = $listFigurinhas->getResultBd();
                $this->data = "";
            }    
            
        
        //instanciando a classe ConfigView, criando um objeto da classe chamado $loadView
        $loadView = new \Core\ConfigView("adms/Views/buscar", $this->data);
        //instanciando o método loadView que fica na classe ConfigView
        $loadView->loadView();
    }
}