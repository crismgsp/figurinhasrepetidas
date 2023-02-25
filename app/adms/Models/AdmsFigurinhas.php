<?php

namespace App\adms\Models;


class AdmsFigurinhas
{
    /**@var $dados recebe os dados enviados pelo usuario, quem deve enviar estes dados é a controller Login */
    private $data;
  
    /**@var $result recebe true quando executar o  processo com sucesso e false quando houver erro */
    private $result;

    /** @var  $resultBd Recebe os registros do banco de dados */
    private  $resultBd;

    /** @var  $resultBd2 Recebe os registros do banco de dados quando ha pesquisa no formulario de pesquisa */
    private  $resultBd2;

    //parse string so para colocar na funcao fullRead como parametro...pois exige este parametro
    private $parseString;

    private array $listRegistryAdd;

    /** @var  $searchName Recebe o nome do usuario */
    private  $searchName;

    /** @var  $searchEmail Recebe o email do usuario */
    private  $searchFigurinha;

    /** @var  $searchNameValue Recebe o nome do usuario */
    private $searchNameValue;

    /** @var  $searchEmailValue Recebe o e-mail do usuario */
    private $searchFigurinhaValue;
  
    function getResult()
    {
        return $this->result;
    }

   
    function getResultBd()
    {
        return $this->resultBd;
    }

    function getResultBd2()
    {
        return $this->resultBd2;
    }

   
    public function create($data)
    {
        //$this->data é o atribuido que irá receber os dados
        $this->data = $data;
       
        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);

        //se getResult retornar true significa que nao houve erro, entao pode cadastar no banco de dados
        if ($valEmptyField->getResult()) {
            $this->add();
        } else{
            $this->result = false;     
        }
    }  
    
    
   
    private function add(): void
    {
       
        //vai instanciar agora o AdmsCreate e atribuir para um objeto chamado createUser

        $createUser = new \App\adms\Models\helper\AdmsCreate();
        //var_dump($this->data);
        //exit();
        $createUser->exeCreate("figurinhas", $this->data);

      
        if($createUser->getResult()){
            $_SESSION['msg'] = "<p class='alert-success'>Figurinha cadastrada com sucesso</p>";
            $this->result = true;
        }else{
            //ta caindo aqui...nao sei porque por isso pus esta mensagem
            $_SESSION['msg'] = "<p class='alert-success'>Figurinha não cadastrada.</p>";
            $this->result = false;
        }
    }

    //listar dados pra aparecer em um select
    public function listSelect(): array    
    {
        $this->parseString = "";   //so para colocar como parametro na hora de instanciar o metodo fullRead
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id , nome, codigo, ordem, grupo FROM figurinhas ORDER BY ordem ASC", $this->parseString);
        //vai atribuir o resultado para o array abaixo...na posicao figurinhas
        $registry['figurinhas']= $list->getResult();
        
        
        $this->listRegistryAdd = ['figurinhas' => $registry['figurinhas']];

        return $this->listRegistryAdd;
    }

    public function listUsers(): void
    {
       
        $this->parseString = "";   //so para colocar como parametro na hora de instanciar o metodo fullRead
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id , nome, codigo, ordem, grupo FROM figurinhas ORDER BY ordem, codigo ASC",
         $this->parseString);

        $this->resultBd = $list->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhuma figurinha encontrada!</p>";
            $this->result = false;
        }
    }

    public function listSearchUsers( $search_name,  $search_figurinha): void
    {
        
        
        $this->searchName = trim($search_name);
        $this->searchFigurinha = trim($search_figurinha);

        $this->searchNameValue = "%" . $this->searchName . "%";
        $this->searchFigurinhaValue = "%" . $this->searchFigurinha . "%";

        if ((!empty($this->searchName)) and (!empty($this->searchFigurinha))) {
            $this->searchUserNameFigurinha();
        } elseif ((!empty($this->searchName)) and (empty($this->searchFigurinha))) {
            $this->searchUserName();
        } elseif ((empty($this->searchName)) and (!empty($this->searchFigurinha))) {
            $this->searchUserFigurinha();
        } else {
            $this->searchUserNameFigurinha();
        }
    }

    /**
     * Metodo pesquisar pelo nome
     * @return void
     */
    public function searchUserName(): void
    {
        
        $listFigurinhas = new \App\adms\Models\helper\AdmsRead();
        $listFigurinhas->fullRead("SELECT id, nome, codigo, ordem FROM figurinhas
                    WHERE nome LIKE :search_name 
                    ORDER BY ordem ASC"
                   , "search_name={$this->searchNameValue}");

        $this->resultBd2 = $listFigurinhas->getResult();
        if ($this->resultBd2) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Nenhuma figurinha deste usuario encontrada!</p>";
            $this->result = false;
        }
    }/**
     * Metodo pesquisar pelo e-mail
     * @return void
     */
    public function searchUserFigurinha(): void
    {
        

        $listFigurinhas = new \App\adms\Models\helper\AdmsRead();
        $listFigurinhas->fullRead("SELECT id, nome, codigo, ordem FROM figurinhas
                    WHERE codigo LIKE :search_figurinha OR codigo = '$this->searchFigurinha'
                    ORDER BY ordem ASC"
                   , "search_figurinha={$this->searchFigurinhaValue}");

        $this->resultBd2 = $listFigurinhas->getResult();
        if ($this->resultBd2) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Nenhuma figurinha encontrada com este código!!!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo pesquisar pelo nome e e-mail
     * @return void
     */
    public function searchUserNameFigurinha(): void
    {
      
        $listFigurinhas = new \App\adms\Models\helper\AdmsRead();
        $listFigurinhas->fullRead("SELECT id, nome, codigo, ordem FROM figurinhas
                    WHERE codigo LIKE :search_figurinha OR name LIKE :search_name
                    ORDER BY ordem ASC"
                   , "search_figurinha={$this->searchFigurinhaValue}&search_name={$this->searchNameValue}");

        $this->resultBd2 = $listFigurinhas->getResult();
        if ($this->resultBd2) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Nenhuma figurinha encontrada!</p>";
            $this->result = false;
        }
    }
}
    


