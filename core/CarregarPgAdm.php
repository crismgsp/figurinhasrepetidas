<?php

namespace Core;


/**
 * Verificar se existe a classe
 * Carregar a Controller
 * @author Cristina (assistindo aula do Cesar Celke) <crismgsp@gmail.com>
 */
class CarregarPgAdm
{
     /*** @var string $urlController Recebe da URL o nome da controller   */
     private string $urlController;
     /*** @var string $urlMetodo Recebe da URL o nome do metodo   */
     private string $urlMetodo;
     /*** @var string $urlParameter Recebe da URL o parametro   */
     private string $urlParameter;
      /*** @var string $classLoad Controller que deve ser carregada   */
    private string $classLoad;
    /*** @var string $urlSlugController Recebe o controller tratado   */
    private string $urlSlugController;
    /*** @var string $urlSlugMetodo Recebe o metodo tratado   */
    private string $urlSlugMetodo;

    private array $listPgPublic;
    private array $listPgPrivate; 


     public function loadPage(string $urlController, string $urlMetodo, string $urlParameter)
     {
        $this->urlController = $urlController;
        $this->urlMetodo = $urlMetodo;
        $this->urlParameter = $urlParameter;

        //unset($_SESSION['user_id']);

        //var_dump($this->urlController);
        //var_dump($this->urlMetodo);
        //var_dump($this->urlParameter);

        $this->classLoad = "\\App\\adms\\Controllers\\" . $this->urlController;

        $this->pgPublic();

        
        //var_dump($this->classLoad); coloquei este var_dum e descobri o erro eu tinha esquecido de por \\ apos Controllers
        //se a classe existir carrega a pagina...se nao entra no die e mostra a msg
        //se ele tentar acessar uma url com dashboard funciona...se for um nome inexistente nao funciona..
        if(class_exists($this->classLoad)){
            $this->loadMetodo();

        }else{
            //se ele tentar acessar por ex: localhost/celke/adm/dashoard2/index ele entra neste else e pois esta com nome
            //do urlController diferente do existente ai aparece o erro abaixo codigo 003 que anotei pra indicar erro ao caregar a classe
            //tem a opcao de pausar o processamento que ta abaixo deixei comentada ou direcionar para a pagina de login
            //que foi a que deixei aqui... no caso a constante CONTROLLER do arquivo config é a Login
            //die("Erro 003: Por favor tente novamente, caso o erro persista, entre em contato com o administrador " . EMAILADM);
            //se nao encontrar a classe carrega a pagina de login
            $this->urlController = $this->slugController(CONTROLLER);
            $this->urlMetodo = $this->slugMetodo(METODO);
            $this->urlParameter = "";
            //abaixo ocorre uma funcao recursiva..uma funcao chamando ela dentro dela mesma
            $this->loadPage($this->urlController, $this->urlMetodo,$this->urlParameter);

        }
        
     }

     private function loadMetodo(): void
     {
        $classLoad = new $this->classLoad();
        if(method_exists($classLoad, $this->urlMetodo)){
            $classLoad->{$this->urlMetodo}($this->urlParameter);
        }else {
            //erro 004 anotei que é um erro que ocorre ao tentar carregar o metodo
            die("Erro 004: Por favor tente novamente, caso o erro persista, entre em contato 
            com o administrador " . EMAILADM);
        }
     }

     private function pgPublic():void
     {
        // a página login é uma pagina publica
        $this->listPgPublic = ["Inicio", "Buscar", "Todasfigurinhas", "Login", "Logout"];
        //se no array acima existir esta urlController faz o que ta ai, caso contrario faz o que ta no else
        if(in_array($this->urlController, $this->listPgPublic)) {
            //se for uma pagina publica carrega
            $this->classLoad= "\\App\\adms\\Controllers\\" . $this->urlController;
        }else{
            //se nao e uma pagina publica verifica se esta nas paginas privadas
            $this->pgPrivate();
        }
     }

     //observacao: estes nomes que ele coloca nas paginas publicas(acima) ou privadas(abaixo) sao os nomes das controllers
     private function pgPrivate(): void
     {
        $this->listPgPrivate = ["Deletefigurinha", "Cadastro", "Figurinhas"];
        if(in_array($this->urlController, $this->listPgPrivate)){
            //se a pagina for privada precisa verificar se o usuario esta logado
            $this->verifyLogin();
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'> Erro: página não encontrada </p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
     }

     private function verifyLogin(): void
     {
        //se existir estas variaveis globais com estes dados do usuario pode carregar a pagina 
        //caso contrario apresenta o erro e direciona pra pagina de login
        if((isset($_SESSION['id'])) and (isset($_SESSION['nome']))) {
            $this->classLoad= "\\App\\adms\\Controllers\\" . $this->urlController;
        }else {
        $_SESSION['msg'] = "<p class='alert-danger'> Erro: Para acessar a página realize o login </p>";
        $urlRedirect = URLADM . "login/index";
        header("Location: $urlRedirect");
        }
     }    


     /**
     * Converter o valor obtido da URL "view-users" no formato da classe "ViewUsers"
     * Utilizando as funcoes para converter tudo pra minusculo, traço para espaço, cada
     * letra da primeira palavra para maiusculo e depois retirar espaços em branco
     *
     * @param string $slugController    Nome da classe
     * @return string    retorna a controller "view-users" convertido para o nome da Classe "ViewUsers"
     */
    
     private function slugController(string $slugController): string
    {
        $this->urlSlugController = $slugController;
        //converter tudo para minusculo
        $this->urlSlugController = strtolower($this->urlSlugController);
        //converter o traço para espaço em branco
        $this->urlSlugController = str_replace("-", " ", $this->urlSlugController);
        //converter a primeira letra de cada palavra para maiusculo
        $this->urlSlugController = ucwords($this->urlSlugController);
        //retirar o espaço em branco ...acho que so fez isso agora pra poder transformar as iniciais em maiuscula antes
        $this->urlSlugController = str_replace(" ", "", $this->urlSlugController);

        //var_dump($this->urlSlugController);
        return $this->urlSlugController;
    }

    /**
     * Tratar o método
     *Insstanciar o método que trata a controller
     *Converter a primeira letra para minusculo
     *  
     * @param string $urlSlugMetodo
     * @return string
     */
    private function slugMetodo(string $urlSlugMetodo): string
    {
        $this->urlSlugMetodo = $this->slugController($urlSlugMetodo);
        //Converter para minusculo a primeira letra
        $this->urlSlugMetodo = lcfirst( $this->urlSlugMetodo);
        //var_dump($this->urlSlugMetodo);

        return $this->urlSlugMetodo;
    }
    
}