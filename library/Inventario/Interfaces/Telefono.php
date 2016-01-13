<?php

interface Inventario_Interfaces_ITelefonno {
	public function obtenerTelefono($idTelefono);
	public function obtenerTelefonos();
	public function crearTelefono(Application_Model_Estado $telefono);
	public function editarTelefono($idTelefono, Application_Model_Telefono $telefono);
	public function eliminarTelefono($idTelefono);
}
