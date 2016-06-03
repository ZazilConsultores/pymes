<?php

interface Contabilidad_Interfaces_INotaEntrada {
	
	
	public function obtenerNotaEntrada();
	public function agregarProducto(array $encabezado, $producto);
	public function obtenerProducto ($idProducto);

}
