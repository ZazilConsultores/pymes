<?php
  interface Contabilidad_Interfaces_IFacturaCliente{
  	
	public function guardaFactura(array $encabezado, $importe, $formaPago, $productos);
	public function actualizarSaldoBanco($formaPago);
	public function actualizaSaldoCliente($encabezado, $formaPago);
	//public function guardaDetalleFactura(array $encabezado, $producto, $importe);
	
	public function consecutivoEmpresa($encabezado);
	public function guardaImportesImpuesto(array $encabezado, $importe, $productos);
	public function guardaIva(array $encabezado, $importe);
	
	public function guardaDetalleFactura(array $encabezado, $producto, $importe);
  } 
?>