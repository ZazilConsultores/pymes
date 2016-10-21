<?php

interface Contabilidad_Interfaces_IFacturaProveedor {
	
	public function agregarFactura(array $encabezado, $formaPago, $producto);

}