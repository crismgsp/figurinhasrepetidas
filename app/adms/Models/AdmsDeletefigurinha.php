<?php

namespace App\adms\Models;


class AdmsDeletefigurinha
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var  $id Recebe o id do registro */
    private  $id;

    /** @var  $resultBd Recebe os registros do banco de dados */
    private  $resultBd;

    private $nome;

   
    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

   
    public function deleteUser(int $id, $nome): void
    {
        $this->id = (int) $id;
        $this->nome = $nome;
        //var_dump( $this->nome);
        //exit();

        if($this->viewFigurinha()){
            //var_dump($this->resultBd[0]['nome']);
            //echo "nome do usuario logado";
            //var_dump($this->nome);
            //exit();

            if($this->resultBd[0]['nome'] == $this->nome) {
                $deleteUser = new \App\adms\Models\helper\AdmsDelete();
            
                $deleteUser->exeDelete("figurinhas", "WHERE id =:id AND nome=:nome", "id={$this->id}&nome={$this->nome}");

                $_SESSION['msg'] = "<p class='alert-success'>Figurinha apagada</p>";
                $this->result = true;

            }else {
                $_SESSION['msg'] = "<p class='alert-danger'>Voce não pode apagar a figurinha de outra pessoa!</p>";
                $this->result = false;
            }
        }    
            

                
           /* if ($deleteUser->getResult()) {
                //$this->deleteImg();
                $_SESSION['msg'] = "<p class='alert-success'>Figurinha apagada</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Voce não pode apagar a figurinha de outra pessoa!</p>";
                $this->result = false;
            }
        }else{
            $this->result = false;
        } */
        
    }

    private function viewFigurinha(): bool
    {

        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead(
            "SELECT id, nome, codigo
                            FROM figurinhas                          
                            WHERE id=:id
                            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Figurinha não encontrada!</p>";
            return false;
        }
    }

}   