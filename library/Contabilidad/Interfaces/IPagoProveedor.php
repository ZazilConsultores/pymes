<?php
    interface Contabilidad_Interfaces_IPagoProveedor{

		public function busca_Cuentasxp($idSucursal,$pr);
		public function aplica_Pago( $idFactura, array $datos);
		public function obtiene_Factura ($idFactura);
		public function actualiza_Saldo($idFactura, array $datos);
		public function obtenerSucursal($idFactura);
    }
?>