<?php

namespace App\adms\Models;


class AdmsLogin
{

    /** @var  $data Recebe as informações do formulário */
    private  $data;

    /** @var  $resultBd Recebe os registros do banco de dados */
    private $resultBd;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

   
    public function login($data = null): void
    {
        $this->data = $data;

        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT id, nome, senha FROM cadastro WHERE nome =:nome ", "nome={$this->data['nome']}");

        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd) {
            $this->valPassword();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não existente</p>";
            $this->result = false;
        }
    }

   
    private function valPassword(): void
    {
        if (($this->data['senha'] === $this->resultBd[0]['senha'])) {
            $_SESSION['id'] = $this->resultBd[0]['id'];
            $_SESSION['nome'] = $this->resultBd[0]['nome'];
          
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Senha incorreta!</p>";
            $this->result = false;
        }
    }
}
