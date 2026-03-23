<?php 
namespace App\Model;
class Cliente{
    private string $nombre;
    
    private string $dni;

    private array $cuentasBancarias = [];
    public function __construct(string $nombre,  string $dni){
        $this->nombre = $nombre;
       
        $this->dni = $dni;
    }

    /**
     * Get the value of cuentasBancarias
     *
     * @return array
     */
    public function getCuentasBancarias(): array
    {
        return $this->cuentasBancarias;
    }


    public function addCuentaBancaria(CuentaBancaria $cuenta){
        if(!in_array($cuenta, $this->cuentasBancarias)){
            $this->cuentasBancarias[] = $cuenta;
            $cuenta->setTitular($this);
        }
        
    }
}