<?php
    interface Contabilidad_Interfaces_IPagoProveedor{
    	public function obtieneFacturaProveedor($idSucursal, $idCoP, $numeroFactura);
		public function obtenerFactura();
		
		public function busca_facturap($idCoP);
		public function busca_Cuentasxp($idSucursal, $idCoP,$numeroFolio);
		
		public function guardacxp ($numeroFactura, $valores);
    }
?>