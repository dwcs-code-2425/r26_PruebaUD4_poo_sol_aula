<?php
namespace App\Tests\Service;

use App\Model\Cliente;

use App\Model\CuentaCorriente;
use App\Service\OperacionesService;
use PHPUnit\Framework\TestCase;
class OperacionesServiceTest extends TestCase
{


    public function testTransferirConSaldoSuficiente()
    {
        $cliente1 = new Cliente("Juan Pérez", "12345678A");
        $cliente2 = new Cliente("María Gómez", "87654321B");

        $cuentaOrigen = new CuentaCorriente("ES12345678901234567890", 1000, $cliente1);
        $cuentaDestino = new CuentaCorriente("ES09876543210987654321", 500, $cliente2);

        $cliente1->addCuentaBancaria($cuentaOrigen);
        $cliente2->addCuentaBancaria($cuentaDestino);

        $cuentasAntesCliente1 = $cliente1->getCuentasBancarias();
        $cuentasAntesCliente2 = $cliente2->getCuentasBancarias();

        $cuentaOrigenMovsCount = count($cuentaOrigen->getMovimientos());
        $cuentaDestinoMovsCount = count($cuentaDestino->getMovimientos());

        $servicio = new OperacionesService();

        $servicio->transferir($cuentaOrigen, $cuentaDestino, 300);

        //Verificar que el saldo se ha actualizado correctamente
        $this->assertEqualsWithDelta(700, $cuentaOrigen->getSaldo(), 0.001);
        $this->assertEqualsWithDelta(800, $cuentaDestino->getSaldo(), 0.001);

        //Verificar que las cuentas bancarias de los clientes no han cambiado
        $this->assertEquals($cuentasAntesCliente1, $cliente1->getCuentasBancarias());
        $this->assertEquals($cuentasAntesCliente2, $cliente2->getCuentasBancarias());

        //Verificar que se han registrado los movimientos correctamente
        $this->assertCount($cuentaOrigenMovsCount + 1, $cuentaOrigen->getMovimientos());
        $this->assertCount($cuentaDestinoMovsCount + 1, $cuentaDestino->getMovimientos());


        //Extra: Verificar mensajes de movimientos
        $this->assertEquals(OperacionesService::TIPO_MOV_TRANSFERENCIA_ORIGEN . "300€", $cuentaOrigen->getMovimientos()[0]);
        $this->assertEquals(OperacionesService::TIPO_MOV_TRANSFERENCIA_DESTINO . "300€", $cuentaDestino->getMovimientos()[0]);


    }


    public function testTransferirConSaldoInSuficiente()
    {
        $cliente1 = new Cliente("Juan Pérez", "12345678A");
        $cliente2 = new Cliente("María Gómez", "87654321B");

        $cuentaOrigen = new CuentaCorriente("ES12345678901234567890", 1000, $cliente1);
        $cuentaDestino = new CuentaCorriente("ES09876543210987654321", 500, $cliente2);


        $cliente1->addCuentaBancaria($cuentaOrigen);
        $cliente2->addCuentaBancaria($cuentaDestino);

        
        $cuentasAntesCliente1 = $cliente1->getCuentasBancarias();
        $cuentasAntesCliente2 = $cliente2->getCuentasBancarias();

         $cuentaOrigenMovsCount = count($cuentaOrigen->getMovimientos());
        $cuentaDestinoMovsCount = count($cuentaDestino->getMovimientos());


        $servicio = new OperacionesService();

        $this->expectException(\App\Model\Exception\SaldoInsuficienteException::class);
        $this->expectExceptionMessage("Saldo insuficiente para realizar la operación");

        $servicio->transferir($cuentaOrigen, $cuentaDestino, 1000.01);

        //En este momento se lanza la excepción, por lo que el código siguiente no se ejecutará. 
        // Sin embargo, si por alguna razón no se lanza la excepción, estas aserciones verificarán que el estado de las cuentas no ha cambiado.

        $this->assertEqualsWithDelta(1000, $cuentaOrigen->getSaldo(), 0.001);
        $this->assertEqualsWithDelta(500, $cuentaDestino->getSaldo(), 0.001);

          //Verificar que las cuentas bancarias de los clientes no han cambiado
        $this->assertEquals($cuentasAntesCliente1, $cliente1->getCuentasBancarias());
        $this->assertEquals($cuentasAntesCliente2, $cliente2->getCuentasBancarias());

        //Verificar que no se han registrado los movimientos correctamente
        $this->assertCount($cuentaOrigenMovsCount, $cuentaOrigen->getMovimientos());
        $this->assertCount($cuentaDestinoMovsCount, $cuentaDestino->getMovimientos());
    }
}