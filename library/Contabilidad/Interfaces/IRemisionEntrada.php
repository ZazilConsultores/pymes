<?php

interface Contabilidad_Interfaces_IRemisionEntrada {
	
	
	public function agregarProducto(array $encabezado, $producto,$formaPago);
	public function obtenerProducto ($idProducto);
	public function obtenerProveedores();

}
