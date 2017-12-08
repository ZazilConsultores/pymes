<?php

interface Inventario_Interfaces_IProductoterminado{
	
	public function obtenerProductosTerminados();
	public function obtenerProductoTerminado($idProductoTerminado);
	
	public function crearProductoTerminado(array $datos);
	public function obtieneProductoTerminado($idPC);
}
