<?php

namespace App\adms\Models\helper;



use PDO;
use PDOException;

/**
 *  class  classe genérica para apagar registros no banco de dados (delete generico)
 * 
 */
class AdmsDelete extends AdmsConn
{
   private string $table;
   private $terms;   //o do professor era string ou nulo, o dele é php 8
   
   private array $value = [];
   private string $result;
   private object $delete;
   private string $query;
   private object $conn;
   private $parseString;

   function getResult(): string
   {
    return $this->result;
   }

   public function exeDelete(string $table, $terms, $parseString): void
   {
        $this->table = $table;
        
        $this->terms = $terms;
       
        parse_str($parseString, $this->value);

        //vai criar a query generica para deletar
        $this->query = "DELETE FROM {$this->table} {$this->terms}";
      
        $this->exeInstruction();
   }

   
   
   private function exeInstruction(): void
   {
        $this->connection();
        try{
            $this->delete->execute($this->value);
            $this->result = true;
        }catch(PDOException $err){
            $this->result = false;
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
        $this->delete= $this->conn->prepare($this->query);
   }

}