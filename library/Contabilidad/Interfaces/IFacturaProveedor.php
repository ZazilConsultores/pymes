<?php

interface Contabilidad_Interfaces_IFacturaProveedor {

	public function guardaFactura(array $encabezado, $importe, $formaPago, $productos);
	public function actualizaSaldoProveedor($encabezado, $formaPago);
	public function guardaDetalleFactura(array $encabezado, $producto, $importe);

}