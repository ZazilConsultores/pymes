<?php
/**
 * 
 */
interface Sistema_Interfaces_ISucursal{
	public function agregarSucursal($idFiscales, array $datos);
	public function editarDomicilioSucursal($idSucursal, $idDomicilio,array $datos);
	public function editarTelefonoSucursal($idSucursal, $idTelefono,array $datos);
	public function editarEmailSucursal($idSucursal, $idEmail,array $datos);
	
	
}
