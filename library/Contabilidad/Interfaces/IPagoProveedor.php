<?php
    interface Contabilidad_Interfaces_IPagoProveedor{

		public function busca_Cuentasxp($idSucursal,$pr);
		public function aplica_Pago( $idFactura, array $datos);
		public function actualiza_Saldo();
    }
?>