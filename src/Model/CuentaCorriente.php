<?php 
namespace App\Model;
class CuentaCorriente extends CuentaBancaria{
  
    public function __construct(string $numeroCuenta, float $saldo, Cliente $titular){
        parent::__construct($numeroCuenta, $saldo, $titular);
       
    }

      public function calcularIntereses(): float{
        return 0;
      }
}