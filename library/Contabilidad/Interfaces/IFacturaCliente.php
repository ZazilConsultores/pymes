<?php
  interface Contabilidad_Interfaces_IFacturaCliente{
  	
	public function guardaFactura(array $encabezado, $importe, $formaPago, $productos);
	public function actualizarSaldoBanco($formaPago, $importe);
	public function actualizaSaldoCliente($encabezado, $formaPago);
	//public function guardaDetalleFactura(array $encabezado, $producto, $importe);
	
	public function consecutivoEmpresa($encabezado);
	public function guardaImportesImpuesto(array $encabezado, $importe, $productos);
	public function guardaIva(array $encabezado, $importe);
	
	public function guardaDetalleFactura(array $encabezado, $producto, $importe);
	
	public function resta(array $encabezado, $producto);
	public function creaCardex(array $encabezado, $producto);
	
	public function editaNumeroFactura($idSucursal);
	public function restaProductoTerminado(array $encabezado, $formaPago, $productos);
  } 
?>