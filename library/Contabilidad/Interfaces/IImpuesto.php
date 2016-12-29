<?php
   interface Contabilidad_Interfaces_IImpuesto{
   	
	public function obtenerImpuestos();
	public function obtenerImpuesto($idImpuesto);
	public function nuevoImpuesto(Contabilidad_Model_Impuesto $impuesto);
	public function editarImpuesto($idImpuesto, array $datos);
	public function obtenerImpuestoProductos($idImpuesto);
	public function enlazarProductoImpuesto(Contabilidad_Model_ImpuestoProductos $impuestoProducto,$idImpuesto, $idProducto);
	public function obtenerByImpuestos($idImpuesto);
	public function obtenerByProductos($idProducto);
   }
?>