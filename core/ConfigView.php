<?php

namespace Core;


/**
 * Carregar as páginas da view
 * @author Cristina (assistindo aula do Cesar Celke) <crismgsp@gmail.com>
 * 
 */
class ConfigView
{
    /**
     * Receber o endereco da View e os dados
     * @param string $nameView Endereco da view que deve ser carregada    
     * @param array|string|null $data(estas 3 opcoes juntas no php 8 $data   Dados que a VIEW deve receber*/
    private string $nameView;
    private $data;
     

    public function __construct(string $nameView, $data)
    {
        //o professor tirou o que ta logo abaixo do comentario mas tirei e deu erro quando tirei isto
        //quando comento a linha a seguir aparece nameView fora Uncaught Error: Typed property Core\ConfigView::$nameView
        // must not be accessed before initialization in C:\xampp\htdocs\adm\core\ConfigView.php:24
      
       $this->nameView = $nameView;
       $this->data = $data;
        
    }

    /**
     * Carregar a view login, verificar se o arquivo existe e carregar caso exista
     * Se nao existir para o carregamento e apresenta mensagem de erro
     *
     * @return void
     */
    public function loadViewLogin(): void
    {
        if(file_exists('app/' .$this->nameView . '.php')) {
            include 'app/adms/Views/include/head_login.php';
            include 'app/' .$this->nameView . '.php';
            include 'app/adms/Views/include/footer_login.php';
        }else{
            //estes erros sao so pra treinar e um codigo que coloquei para erro ao carregar view
            die("Erro 005: Por favor tente novamente, caso o erro persista, entre em contato com o administrador
            " . EMAILADM);
        }
    }

    /**
     * Carregar a view, verificar se o arquivo existe e carregar caso exista
     * Se nao existir para o carregamento e apresenta mensagem de erro, a unica diferença desta view para a loadviewlogin é que esta carrega o menu
     *
     * @return void
     */
    public function loadView(): void
    {
        if(file_exists('app/' .$this->nameView . '.php')) {
            //include 'app/adms/Views/include/head.php';
            //include 'app/adms/Views/include/navbar.php';
            //include 'app/adms/Views/include/menu.php';
            include 'app/' .$this->nameView . '.php';
            //include 'app/adms/Views/include/footer.php';
        }else{
            //estes erros sao so pra treinar e um codigo que coloquei para erro ao carregar view
            die("Erro 002: Por favor tente novamente, caso o erro persista, entre em contato com o administrador
            " . EMAILADM);
        }
    }


}