<?php

interface Sistema_Interfaces_IMunicipio {
	public function obtenerMunicipio($idMunicipio);
	public function obtenerMunicipios($idEstado);
	public function crearMunicipio(Sistema_Model_Municipio $idMunicipio);
	public function editarMunicipio($idMunicipio, array $municipio);
	public function eliminarMunicipio($idMunicipio);
}