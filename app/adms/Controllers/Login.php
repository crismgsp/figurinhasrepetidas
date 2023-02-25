<?php

namespace App\adms\Controllers;



class Login
{

    /** @var  $data Recebe os dados que devem ser enviados para VIEW */
    private  $data = [];

    /** @var  $dataForm Recebe os dados do formulario */
    private  $dataForm;

    public function index(): void
    {

        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);        

        if(!empty($this->dataForm['SendLogin'])){
            $valLogin = new \App\adms\Models\AdmsLogin();
            $valLogin->login($this->dataForm);
            if($valLogin->getResult()){
                $urlRedirect = URLADM . "inicio/index";
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
            }            
        }

        $loadView = new \Core\ConfigView("adms/Views/login", $this->data);
        $loadView->loadView();
    }
}
