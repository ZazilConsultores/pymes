<?php
    interface Contabilidad_Interfaces_IPagoProveedor{

		public function busca_Cuentasxp($idSucursal,$pr);
		public function aplica_Pago($idFactura, $pago);
		public function actualiza_Saldo();
    }
?>