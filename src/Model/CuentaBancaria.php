<?php
namespace App\Model;



abstract class CuentaBancaria {
    use \App\Model\Trait\RegistroMovimientosTrait;
    protected string $numeroCuenta;
    protected float $saldo;
    protected Cliente $titular;
    public function __construct(string $numeroCuenta, float $saldo, Cliente $titular){
        $this->numeroCuenta = $numeroCuenta;
        $this->saldo = $saldo;
        $this->titular = $titular;
    }

     abstract public function calcularIntereses(): float;


    /**
     * Get the value of numeroCuenta
     *
     * @return string
     */
    public function getNumeroCuenta(): string
    {
        return $this->numeroCuenta;
    }

    /**
     * Get the value of saldo
     *
     * @return float
     */
    public function getSaldo(): float
    {
        return $this->saldo;
    }

    /**
     * Get the value of titular
     *
     * @return Cliente
     */
    public function getTitular(): Cliente
    {
        return $this->titular;
    }

   
    


    /**
     * Set the value of saldo
     *
     * @param float $saldo
     *
     * @return self
     */
    public function setSaldo(float $saldo): self
    {
        $this->saldo = $saldo;

        return $this;
    }

     /**
     * Set the value of titular
     *
     * @param Cliente $titular
     *
     * @return self
     */
    public function setTitular(Cliente $titular): self
    {
        $this->titular = $titular;

        return $this;
    }


}