<?php

interface Inventario_Interfaces_IMunicipio {
	public function obtenerMunicipio($idMunicipio);
	public function obtenerMunicipios($idEstado);
	public function crearMunicipio(Application_Model_Municipio $idMunicipio);
	public function editarMunicipio($idMunicipio, Application_Model_Municipio $municipio);
	public function eliminarMunicipio($idMunicipio);
}