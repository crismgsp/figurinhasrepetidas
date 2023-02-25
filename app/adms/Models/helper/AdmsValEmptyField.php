<?php

namespace App\adms\Models\helper;



/**
 * classe criada para validar se os dados enviados pelo usuario estao preenchidos, além disso retira espaços do inicio
 * e fim e retira tags caso o usuario envie, é instanciada no AdmsNewUser pra validar dados preenchidos antes de cadastrar
 * no banco de dados
 */
class AdmsValEmptyField
{
    /**@var $dados recebe os dados enviados pelo usuario, quem deve enviar estes dados é a controller Login */
    private $data;
    private bool $result;

    function getResult(){
        return $this->result;
    }

    public function valField($data)
    {
        $this->data = $data;
        //vai verificar se o usuario nao vai enviar tag, se tiver é pra tirar elas
        $this->data = array_map('strip_tags', $this->data);
        //retirar espaço em branco no inicio e no final
        $this->data = array_map('trim', $this->data);

        //verificar se algum campo está vazio, caso nao tenha nenhum vazio recebe o true e pode continuar
        if(in_array('', $this->data)){
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessario preencher todos os campos</p>";
            $this->result = false;
        }else {
            $this->result = true;
        }


    }
        
    
    

}