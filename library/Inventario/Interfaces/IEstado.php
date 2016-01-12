<?php

interface Inventario_Interfaces_IEstado {
	public function obtenerEstado($idEstado);
	public function obtenerEstados();
	public function obtenerMunicipios($idEstado);
	public function crearEstado(Application_Model_Estado $estado);
	public function editarEstado($idEstado, Application_Model_Estado $estado);
	public function eliminarEstado($idEstado);
}
