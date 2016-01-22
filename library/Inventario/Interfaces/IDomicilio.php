<?php

interface Inventario_Interfaces_IDomicilio{
	public function obtenerDomiclio($idDomicilio);
	public function obtenerDomicilios();
	public function obtenerMunicipio($idEstado,$idDomicilio);
	public function obtenerEstado($idEstado,$idMunicipio, $idDomicilio);
	public function crearDomicilio(Sistema_Model_Domicilio $domicilio);
	public function editarDomicilio($idDomiclio, array $domicilio);
	public function eliminarDomicilio($idDomiclio);
}
