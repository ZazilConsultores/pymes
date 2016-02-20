<?php

interface Inventario_Interfaces_IUnidad{
	public function obtenerUnidad($idUnidad);
	public function obtenerUnidades($idMultiplo);
	public function crearUnidad(Inventario_Model_Unidad $idUnidad);
	public function editarUnidad($idUnidad, Inventario_Model_Unidad $unidad);
	public function eliminar($idUnidad);
}