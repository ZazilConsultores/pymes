<?php

interface Contabilidad_Interfaces_IFacturaProveedor {
	
	//public function agregarFactura(array $encabezado, $formaPago, $producto);
	public function guardaFactura(array $encabezado, $importe, $formaPago, $productos);
	public function actualizarSaldoBanco($formaPago);
	public function actualizaSaldoProveedor($encabezado, $formaPago);
	public function guardaDetalleFactura(array $encabezado, $producto, $importe);
	
	public function suma(array $encabezado, $producto);
	
	//public function existeFactura($numeroFactura,$idTipoMovimiento,$idCoP, $idSucursal);
	
	//public function convierteMultiplo($idProducto, $idUnidad);
	
	//public function buscarProducto($idProducto);

}