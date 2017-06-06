<?php

interface Inventario_Interfaces_IProductoterminado{
	public function obtenerProducto();
	public function obtenerProductoTerminado();
	
	public function crearProductoTerminado(array $datos);
	
}
