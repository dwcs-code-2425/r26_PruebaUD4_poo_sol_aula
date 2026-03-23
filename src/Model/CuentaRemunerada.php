<?php 
namespace App\Model;
class CuentaRemunerada extends CuentaBancaria{
    private float $interes;
    public function __construct(string $numeroCuenta, float $saldo, Cliente $titular, float $interes){
        parent::__construct($numeroCuenta, $saldo, $titular);
        $this->interes = $interes;
    }
     public function calcularIntereses(): float
    {
        return $this->saldo * $this->interes;
    }
}