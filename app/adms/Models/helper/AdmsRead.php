<?php

namespace App\adms\Models\helper;


use PDO;
use PDOException;

/**
 *  class  classe genérica para SELECIONAR  registro no banco de dados (select generico)
 */
class AdmsRead extends AdmsConn
{
    /** @var string $select Recebe o QUERY */
    private string $select;
    /** @var array $values Recebe os valores que deve ser atribuidos nos link da QUERY com bindValue */
    private array $values = [];
    /** @var array $result Recebe os registros do banco de dados e retorna para a Models */
    private array $result;
    /** @var object $query Recebe a QUERY preparada */
    private object $query;
    /** @var object $conn Recebe a conexao com BD */
    private object $conn;

    /**
     * @return array Retorna o array de dados
     */
    function getResult(): array
    {
        return $this->result;
    }

    /** 
     * Recebe os valores para montar a QUERY.
     * Converte a parseString de string para array.
     * @param string $table Recebe o nome da tabela do banco de dados
     * @param string $terms Recebe os links da QUERY, ex: sts_situation_id =:sts_situation_id
     * @param string $parseString Recebe o valores que devem ser subtituidos no link, ex: sts_situation_id=1
     * 
     * @return void
     */
    public function exeRead(string $table, string $terms, string $parseString): void
    {
        //parseString não é valor obrigatorio, nem sempre vai precisar, entao se parseString for diferente de vazio
        //executa a instrucao dentro do if
        if(!empty($parseString)){
            //se tiver parseString tem que tratar este dado e vai atribuir ele pra $this->values
            parse_str($parseString, $this->values);
           
        }

        $this->select = "SELECT * FROM {$table} {$terms}";
        var_dump($this->select);
        //instancia aqui o método criado abaixo
        $this->exeInstruction();

    }

    /**
     * Recebe os valores para montar a QUERY.
     * Converte a parseString de string para array.
     * @param string $query Recebe a QUERY da Models
     * @param string $parseString Recebe o valores que devem ser subtituidos no link, ex: sts_situation_id=1
     * 
     * @return void
     */
    public function fullRead(string $query, string $parseString): void
    {
        $this->select = $query;
        if(!empty($parseString)){
            parse_str($parseString, $this->values);
        }    
        $this->exeInstruction();
    }

    /**
     * Executa a QUERY. 
     * Quando executa a query com sucesso retorna o array de dados, senão retorna null.
     * 
     * @return void
     */
    private function exeInstruction(): void
    {
        //instancia aqui o método de conexao abaixo
        $this->connection();
        try{
            $this->exeParameter();
            $this->query->execute();
            $this->result = $this->query->fetchAll();
        }catch(PDOException $err){
            $this->result = null;
        }
    }

    /**
     * Obtem a conexão com o banco de dados da classe pai "Conn".
     * Prepara uma instrução para execução e retorna um objeto de instrução.
     * 
     * @return void
     */
    private function connection(): void
    {
        $this->conn = $this->connectDb();
        //agora prepara a query
        $this->query = $this->conn->prepare($this->select);
        //agora vai ler os valores
        $this->query->setFetchMode(PDO::FETCH_ASSOC);
    }

    /**
     * Substitui os linsk da QUERY pelos valores utilizando o bindValue
     * 
     * @return void
     */
    private function exeParameter(): void
    {
        // se existir a parse string ele vai substituir pelo valor tratado na funcao exeRead
        if($this->values){
            foreach($this->values as $link => $value) {
                if(($link == 'limit') or ($link == 'offset') or ($link == 'id')) {
                    $value = (int) $value;
                }
                //aqui esta deixando aquela parte de atribuir os values no select para as ":nomesvalues" automatizada, generica
                //se for inteiro vai forçar a passar inteiro..is_int verifica se for inteiro -> PDO::PARAM_INT
                //se for diferente de inteiro -> PDO::PARAM_STR   (e um operador ternario que tem ali)
                
                $this->query->bindValue(":{$link}", $value, (is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR));
            }
        }
    }


}