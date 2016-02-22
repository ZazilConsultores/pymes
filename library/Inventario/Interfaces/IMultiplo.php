<?php

interface Inventario_Interfaces_IMultiplo {
	public function obtenerMultiplo($idMultiplos);
	public function obtenerMultiplos($idProducto);
	public function crearMultiplos(Inventario_Model_Multiplos $idMultiplos);
	public function editarMultiplo($idMultiplos,Inventario_Model_Multiplos $multiplo);
	public function eliminarMultiplo($idMultiplos);
}