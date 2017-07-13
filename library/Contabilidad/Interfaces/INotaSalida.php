<?php

interface Contabilidad_Interfaces_INotaSalida {
	
	public function obtenerClientes();
	public function guardaMovimientos(array $encabezado, $producto);
	public function restaProducto(array $encabezado, $producto);
	public function creaCardex(array $encabezado, $producto);

}
