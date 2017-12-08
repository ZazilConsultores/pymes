<?php
    interface Contabilidad_Interfaces_ICobroCliente{

		public function busca_Cuentasxc($idSucursal,$pr);
		public function aplica_Cobro( $idFactura, array $datos);
		public function obtiene_Factura ($idFactura);
		public function actualiza_Saldo($idFactura, array $datos);
		public function obtenerSucursal($idFactura);
    }
?>