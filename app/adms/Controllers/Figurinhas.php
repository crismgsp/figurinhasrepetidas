<?php

namespace App\adms\Controllers;


class Figurinhas
{
    /** 
     * @var $data recebe os dados que devem ser enviados para a view ..o que ta comentado so funciona no php 8 desta forma
     * coloquei do jeito que funciona na minha versao
     */
    //private array|string|null $data; isso funcionaria no php 8

    private $data;

    /** 
     * @var $dataform recebe os dados do formulario de cadastro
     */
    private $dataForm;

    private $numero;

   
    public function index(): void
    {
       

        $data = [];

        $this->data = $data;

        $this->dataForm = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        
        $usuarios = new \App\adms\Models\AdmsCadastro();
        //instancia o metodo login que esta dentro da classe AdmsLogin, parametro dados recebidos do usuario
        $nomes = $usuarios->listSelect();
        

        $this->data['nomes'] = $nomes;
              
        //se o usuario clicou no botao de cadastrar executa o que ta dentro deste if
        if(!empty($this->dataForm['SendAddFigurinha'])) {
           
            //faz o unset para tirar os dados do SendNewUser que estavam aparecendo no meio 
            //dos dados a cadastrar no banco de dados
            unset($this->dataForm['SendAddFigurinha']);  

            //fiz isso pois nao estava indo o dado da sessao para a tabela no BD..ai vi esta dica num forum
            $json = json_encode($_SESSION['nome']);
            //json_decode($json, true);
            json_decode($json, false);
            $this->dataForm['nome'] = str_replace('"', "", $json);
           
            
          

            $codigo = $this->dataForm['codigo'];

            
            $grupo = substr($codigo, 0, 3);
            $this->numero = substr($codigo, 3, 2);
            

            switch((strtolower($grupo))){
                case '00':
                    $ordem = 1;
                    break;
                case 'fwc':
                    $ordem = 2;
                    break; 
                case 'qat':
                    $ordem = 3;
                    break; 
                
                case 'ecu':
                    $ordem = 4;
                    break;          
                case "sen":
                    $ordem = 5;
                    break; 
                case 'ned':
                    $ordem = 6;
                    break;          
                case 'eng':
                
                    $ordem = 7;
                    break; 
                case 'irn':
                
                    $ordem = 8;
                    break; 
                case 'usa':
                
                    $ordem = 9;
                    break; 
                case 'wal':
                
                    $ordem = 10;
                    break; 
                case 'arg':
                
                    $ordem = 11;
                    break; 
                case 'ksa':
                
                    $ordem = 12;
                    break;  
                case 'mex':
                
                    $ordem = 13;
                    break; 
                case 'pol':
                
                    $ordem = 14;
                    break; 
                case 'fra':
                
                    $ordem = 15;
                    break; 
                case 'aus':
                
                    $ordem = 16;
                    break; 
                case 'den':
                
                    $ordem = 17;
                    break; 
                case 'tun':
                
                    $ordem = 18;
                    break; 
                case 'esp':
               
                    $ordem = 19;
                    break; 
                case 'crc':
                    $ordem = 20;
                    break; 
                case 'ger':
                
                    $ordem = 21;
                    break;  
                case 'jpn':
                
                    $ordem = 22;
                    break; 
                case 'bel':
                
                    $ordem = 23;
                    break;       
                case 'can':
                
                    $ordem = 24;
                    break; 
                case 'mar':
               
                    $ordem = 25;
                    break; 
                case 'cro':
                
                    $ordem = 26;
                    break; 
                case 'bra':
                
                    $ordem = 27;
                    break; 
                case 'srb':
               
                    $ordem = 28;
                    break; 
                case 'sui':
                case 'SUI':
                    $ordem = 29;
                    break; 
                case 'cmr':
              
                    $ordem = 30;
                    break; 
                case 'por':
               
                    $ordem = 31;
                    break; 
                case 'gha':
                
                    $ordem = 32;
                    break; 
                case 'uru':
                
                    $ordem = 33;
                    break; 
                case 'kor':
                
                    $ordem = 34;
                    break; 
                case 'c1':
                case 'c2':
                case 'c3': 
                case 'c4':
                case 'c5':
                case 'c6':
                case 'c7':
                case 'c8': 
                    $ordem = 35;
                    break; 
                default:
                    $ordem = 36;
                    
                    break;          
            }

            $this->dataForm['grupo'] = $grupo;
            $this->dataForm['ordem'] = $ordem;

            if((($this->dataForm['ordem'] === 36) OR (($this->dataForm['ordem'] === 2 AND $this->numero > 29)) OR
            ($this->dataForm['ordem'] != 2 AND $this->dataForm['ordem'] != 36 AND $this->numero > 20) )){
                $_SESSION['msg'] = "<p class='alert-danger'> Código de figurinha não existente </p>";
                $this->viewAddUser();
            }else {
                
             
                //instancia a classe ..vai criar ainda este e o do login...ira alterar...
                $createUser = new \App\adms\Models\AdmsFigurinhas();
                //instancia o metodo login que esta dentro da classe AdmsLogin, parametro dados recebidos do usuario
                $createUser->create($this->dataForm);
                //se getResult retornar True significa que conseguiu cadastrar com sucesso, ai direciona pra pagina de login 
                // se nao conseguiu pega o que veio do formulario e mantem la preenchido
                

                if($createUser->getResult()){
                    $urlRedirect = URLADM . "figurinhas/index";
                    header("Location: $urlRedirect");
                    
                } else {
                    
                    $this->data['form'] = $this->dataForm;
                    $this->viewAddUser();
                }
            } 
        }else {
            $this->viewAddUser();
        }      

    }

        //este pedaço abaixo é para carregar a pagina relacionada a esta controller que é a cadastro
    private function viewAddUser(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/figurinhas", $this->data);
        $loadView->loadView(); 
    }
        
        
}