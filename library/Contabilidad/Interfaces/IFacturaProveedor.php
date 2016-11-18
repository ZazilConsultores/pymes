<?php

interface Contabilidad_Interfaces_IFacturaProveedor {
	
	public function agregarFactura(array $encabezado, $formaPago, $producto);
	public function guardaFactura(array $encabezado,  $importe, $formaPago);
	
	//public function existeFactura($numeroFactura,$idTipoMovimiento,$idCoP, $idSucursal);
	
	//public function convierteMultiplo($idProducto, $idUnidad);
	
	//public function buscarProducto($idProducto);

}