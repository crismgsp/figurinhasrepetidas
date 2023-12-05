<?php

namespace Core;


/**
 * Recebe a URL e manipula
 * Carregar a Controller
 * @author Cristina (assistindo aula do Cesar Celke) <crismgsp@gmail.com>
 */
class ConfigController extends Config
{
    /*** @var string $url Recebe a URL do .htaccess   */
    private string $url;
    /*** @var string $urlArray Recebe a URL  convertida para array   */
    private array $urlArray;
    /*** @var string $urlController Recebe da URL o nome da controller   */
    private string $urlController;
    /*** @var string $urlMetodo Recebe da URL o nome do metodo   */
    private string $urlMetodo;
    /*** @var string $urlParameter Recebe da URL o parametro   */
    private string $urlParameter;
    /*** @var string $classLoad Controller que deve ser carregada   */
    private string $classLoad;
    /*** @var string $format Recebe o array de caracteres especiais que devem ser substituidos   */
    private array $format;
    /*** @var string $urlSlugController Recebe o controller tratado   */
    private string $urlSlugController;
    /*** @var string $urlSlugMetodo Recebe o metodo tratado   */
    private string $urlSlugMetodo;


    /**
     * Recebe a URL do <div class="htaccess"
     * Validar a URL
     */
    public function __construct()
    {
        $this->configAdmin();
        if(!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))){
            $this->url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);
            //var_dump($this->url);
            $this->clearUrl();
            $this->urlArray = explode("/", $this->url);
            //var_dump($this->urlArray);

            if(isset($this->urlArray[0])){
                $this->urlController = $this->slugController($this->urlArray[0]);
            }else {
                $this->urlController = $this->slugController(CONTROLLER);
            }

            if(isset($this->urlArray[1])){
                $this->urlMetodo = $this->slugMetodo($this->urlArray[1]);
            }else {
                $this->urlMetodo = $this->slugMetodo(METODO);
            }

            if(isset($this->urlArray[2])){
                $this->urlParameter = $this->urlArray[2];
            }else {
                $this->urlParameter = "";
            }
            
        }else {
            $this->urlController = $this->slugController(CONTROLLERERRO);
            $this->urlMetodo = $this->slugMetodo(METODO);
            $this->urlParameter = "";
        }    
        
        //echo "Controller: {$this->urlController} <br>";
        //echo "Metodo: {$this->urlMetodo} <br>";
        //echo "Parametro: {$this->urlParameter} <br>";
        
    } 

    /**
     * Método privado, nao pode ser instanciado fora da classe
     * Limpa a URL, eliminando as TAGs, os espaços em brancos, retira barras no final
     * da URL e retira caracteres especiais
     *
     * @return void
     */
    private function clearUrl(): void
    {
        //eliminar as tags
        $this->url = strip_tags($this->url);
        //eliminar o espaço em branco
        $this->url = trim($this->url);
        //eliminar barra no final da URL
        $this->url = rtrim($this->url, "/");
        $this->format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]?;:.,\\\'<>°ºª ';
        $this->format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr-------------------------------------------------------------------------------------------------';
        //$this->url = strtr(utf8_decode($this->url), utf8_decode($this->format['a']), $this->format['b']); funcao utf8_decode depreciada
        $this->url = strtr(mb_convert_encoding($this->url, 'ISO-8859-1', 'UTF-8'), mb_convert_encoding($this->format['a'],'ISO-8859-1', 'UTF-8' ),$this->format['b'] );
        
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
    
    /**
     * Carregar as Controllers
     * Instanciar as classes da controller e carregar o método
     *
     * @return void
     */
    public function loadPage(): void
    {
        

        $loadPgAdm = new \Core\CarregarPgAdm();
        $loadPgAdm->loadPage($this->urlController, $this->urlMetodo, $this->urlParameter);
        
        
    }
    
}