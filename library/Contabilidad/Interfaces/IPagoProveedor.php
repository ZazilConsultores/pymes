<?php
    interface Contabilidad_Interfaces_IPagoProveedor{
    	public function obtieneFacturaProveedor($idSucursal, $idCoP, $numeroFactura);
		public function obtenerFactura();
		
		public function busca_facturap($idCoP);
		public function busca_Cuentasxp($idSucursal);
		
		public function guardacxp ($idFactura, $idBanco, $idDivisa, $fecha,$referencia, $total);
	
		public function busca_Facturasxp ();
		public function aplica_Pago ($idFactura, $pago);
    }
?>