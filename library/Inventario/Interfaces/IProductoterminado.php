<?php

interface Inventario_Interfaces_IProductoterminado{
	public function obtenerProducto();
	public function obtenerProductosTerminados();
	public function obtenerProductoTerminado($idProductoTerminado);
	
	public function crearProductoTerminado(array $datos);
	
}
