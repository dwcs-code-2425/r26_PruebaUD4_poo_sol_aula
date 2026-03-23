<?php
namespace App\Service;
use App\Model\CuentaBancaria;
use App\Model\Exception\SaldoInsuficienteException;
class OperacionesService{

    const TIPO_MOV_RETIRADA = "Retirada de ";
    const TIPO_MOV_INGRESO = "Ingreso de ";

    const TIPO_MOV_TRANSFERENCIA_ORIGEN = "Transferencia enviada de ";
    const TIPO_MOV_TRANSFERENCIA_DESTINO = "Transferencia recibida de ";

     /**
      * Permite transferir una cantidad de dinero de una cuenta bancaria a otra. Si la cuenta de origen no tiene suficiente saldo, se lanzará una excepción.
      * @param CuentaBancaria $cuentaOrigen Cuenta desde la cual se realizará la transferencia.
      * @param CuentaBancaria $cuentaDestino Cuenta a la cual se realizará la transferencia.
      * @param float $cantidad Importe a transferir. Debe ser un valor positivo.
      * @throws SaldoInsuficienteException Si la cuenta de origen no tiene suficiente saldo para realizar la transferencia.
      * @throws \Exception Si la cantidad a transferir no es válida (por ejemplo, negativa).
      * @return void
      */
     public function transferir(CuentaBancaria $cuentaOrigen, CuentaBancaria $cuentaDestino, float $cantidad): void{
        if($cantidad >$cuentaOrigen->getSaldo())
            throw new SaldoInsuficienteException();
        if($cantidad > 0){
            $cuentaOrigen->setSaldo($cuentaOrigen->getSaldo() - $cantidad);
            $cuentaOrigen->registrarMovimiento( self::TIPO_MOV_TRANSFERENCIA_ORIGEN . $cantidad. "€");
            $cuentaDestino->setSaldo($cuentaDestino->getSaldo() + $cantidad);
            $cuentaDestino->registrarMovimiento( self::TIPO_MOV_TRANSFERENCIA_DESTINO . $cantidad. "€");
        }else{
            throw new \Exception("Cantidad no válida.");
        }
    }
}