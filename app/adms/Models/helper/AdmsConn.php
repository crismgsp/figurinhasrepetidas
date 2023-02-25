<?php

namespace App\adms\Models\helper;



use PDOException;
use PDO;

/**
 * Conexão com o banco de dados
 *
 * @author Cristina (acompanhando o curso do professor Cesar Celke)
 */

abstract class AdmsConn
{
   /*** @var string $host Recebe o host da constante HOST*/
    private string $host = HOST;
    /*** @var string $user Recebe o usuario da constante USER*/
    private string $user = USER;
    /*** @var string $pass Recebe a senha da constante PASS*/
    private string $pass = PASS;
    /*** @var string $dbname Recebe o nome da base de dados da constante DBNAME*/
    private string $dbname = DBNAME;
    /*** @var string $port Recebe a porta da constante PORT*/
    private string $port = PORT;
    /*** @var string $connect Recebe a conexao com o banco de dados*/
    private object $connect;

    /**
     * Realiza a conexão com o banco de dados.
     * Não realizando o conexão corretamente, para o processamento da página e apresenta a mensagem de erro, com o e-mail de contato do administrador
     * @return object retorna a conexão com o banco de dados
     */
    protected function connectDb(): object
    {
        try{
            //conexao com a porta (vai testar com a porta e sem a porta) o meu e mariadb mas farei igual ao dele..
            //se nao funcionar troco depois
            //$this->connect = new PDO("mysql:host={$this->host};port={$this->port},dbname=" . 
            //$this->dbname, $this->user, $this->pass);

            //Conexao sem a porta
            $this->connect = new PDO("mysql:host={$this->host};dbname=" . $this->dbname, $this->user, $this->pass);

            return $this->connect;

        }catch(PDOException $err){
            //nas minhas anotacoes coloquei este erro 001 para indicar erro de conexao
            die("Erro 001: Por favor tente novamente, caso o erro persista, entre em contato com o administrador
            " . EMAILADM);
        }
    }
}