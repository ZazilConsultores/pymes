<?php
/**
 * 
 */
interface Sistema_Interfaces_IFiscales {
	
	public function obtenerFiscales($idFiscales);
	
	public function obtenerDomiciliosPorIdFiscal($idFiscales);
	//public function obtenerDomicilioFiscal($idFiscales);
	public function obtenerTelefonosFiscales($idFiscales);
	public function obtenerEmailsFiscales($idFiscales);
	
	public function crearFiscales(Sistema_Model_Fiscales $fiscales);
	
	public function agregarDomicilioFiscal($idFiscales, Sistema_Model_Domicilio $domicilio);
	public function agregarTelefonoFiscal($idFiscales, Sistema_Model_Telefono $telefono);
	public function agregarEmailFiscal($idFiscales, Sistema_Model_Email $email);
	
}
