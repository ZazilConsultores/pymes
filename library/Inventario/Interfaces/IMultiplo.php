<?php

interface Inventario_Interfaces_IMultiplo {
	public function obtenerMultiplo($idMultiplos);
	public function obtenerMultiplos($idProducto);
	public function crearMultiplos(Inventario_Model_Multiplos $idMultiplos);
	public function editarMultiplo($idMultiplos, array $multiplo);
	public function eliminarMultiplo($idMultiplos);
}