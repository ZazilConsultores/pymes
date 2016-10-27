<?php

interface Contabilidad_Interfaces_IFacturaProveedor {
	
	public function agregarFactura(array $encabezado, $formaPago, $producto);
	
	public function existeFactura($numeroFactura,$idTipoMovimiento,$idCoP, $idSucursal);
	
	public function convierteMultiplo($idProducto, $idUnidad);

}