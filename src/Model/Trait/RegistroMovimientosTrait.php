<?php 
namespace App\Model\Trait;
trait RegistroMovimientosTrait{
    private array $movimientos = [];
    public function registrarMovimiento(string $descripcion){
        $this->movimientos[] = $descripcion;
    }

    /**
     * Get the value of movimientos
     *
     * @return array
     */
    public function getMovimientos(): array
    {
        return $this->movimientos;
    }
}