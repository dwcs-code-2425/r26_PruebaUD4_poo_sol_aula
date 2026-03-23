<?php 
namespace App\Model\Exception;
class SaldoInsuficienteException extends \Exception{


    public function __construct($message = "Saldo insuficiente para realizar la operación") {
        parent::__construct($message);
      
    }


}