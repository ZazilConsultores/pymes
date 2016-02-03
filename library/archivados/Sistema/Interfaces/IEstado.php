<?php

interface Sistema_Interfaces_IEstado {
	public function obtenerEstado($idEstado);
	public function obtenerEstados();
	public function obtenerMunicipios($idEstado);
	public function crearEstado(Sistema_Model_Estado $estado);
	public function editarEstado($idEstado, array $estado);
	public function eliminarEstado($idEstado);
}
