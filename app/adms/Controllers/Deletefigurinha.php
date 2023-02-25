<?php

namespace App\adms\Controllers;


/**
 * Controller apagar usuário
 * @author Cesar <cesar@celke.com.br>
 */
class Deletefigurinha
{

    /** @var  $id Recebe o id do registro */
    private $id;

    private $nome;
    
    /**
     * Método apagar figurinha
     * 
     * 
     *
     * @param  $id
     * @return void
     */
    public function index($id = null): void
    {

        if (!empty($id)) {
            $this->id = (int) $id;
            $this->nome = $_SESSION['nome'];
            
            
            $deleteUser = new \App\adms\Models\AdmsDeletefigurinha();
            $deleteUser->deleteUser($this->id, $this->nome);            
        } 

        $urlRedirect = URLADM . "todasfigurinhas/index";
        header("Location: $urlRedirect");

    }
}
