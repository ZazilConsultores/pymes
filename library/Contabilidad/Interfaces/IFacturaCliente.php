<?php
  interface Contabilidad_Interfaces_IFacturaCliente{
  	
	public function guardaFactura(array $encabezado, $importe, $formaPago, $productos);
	public function consecutivoEmpresa($encabezado);
	public function guardaDetalleFactura(array $encabezado, $producto, $importe);
	public function creaCardex(array $encabezado, $producto);	
	public function editaNumeroFactura($idSucursal);

  } 
?>