<?php

namespace App\adms\Models\helper;


use PDO;
use PDOException;

/**
 *  class  classe genérica para editar  registros no banco de dados (update generico)
 * vai ser instanciado no AdmsNewConfEmail, acho que em outros também, e capaz que noo AdmsConfEmail tambem,
 */
class AdmsUpdate extends AdmsConn
{
   private string $table;
   private $terms;   //o do professor era string ou nulo, o dele é php 8
   private $data;  //tirei o array daqui e do argumento pra ver se parava de dar erro em outro arquivo que usa esta classe
   private array $value = [];
   private string $result;
   private object $update;
   private string $query;
   private object $conn;
   private $parseString;

   function getResult(): string
   {
    return $this->result;
   }

   public function exeUpdate(string $table, $data, $terms, $parseString): void
   {
        $this->table = $table;
        $this->data = $data;
        $this->terms = $terms;
       
        parse_str($parseString, $this->value);
      
        $this->exeReplaceValues();
   }

   //vai criar uma função para substituir valores, ex: id=:id   o que vai entrar em :id
   private function exeReplaceValues():void
   {
    //usa um foreach pra caso tenha mais de 1 dado em id
        foreach($this->data as $key => $value){
                      
            $values[] = $key . "=:" . $key;
        }
        
        //vai converter um array para string usando implode, separando pela virgula 
        $values = implode(',', $values);
        
        $this->query = "UPDATE {$this->table} SET {$values} {$this->terms}";
        
        $this->exeInstruction();
   }

   private function exeInstruction(): void
   {
        $this->connection();
        try{
            //ta usando o array_merge para substituir (?) irei observar..acho que e para fazer o mesmo que aquelas substituicoes feitas com bindParam ou bindValue
            $this->update->execute(array_merge($this->data, $this->value));
            $this->result = true;
        }catch(PDOException $err){
            $this->result = null;
        }
   }

   /**
    * Obtem a conexao com o banco de dados da classe pai "Conn". Prepara uma instrucao para
    *execucao e retorna um objeto de instrução
    *
    * @return void
    */
   private function connection(): void
   {
        $this->conn = $this->connectDb();
        $this->update = $this->conn->prepare($this->query);
   }

}