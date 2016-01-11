<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Inventario_DAO_Fiscales implements Inventario_DAO_IFiscales {
	
	private $tablaFiscales;
	private $tablaDomicilio;
	private $tablaTelefono;
	private $tablaEmail;
	
	function __construct() {
		$this->tablaFiscales = new Application_Model_DbTable_Fiscales;
		$this->tablaDomicilio = new Application_Model_DbTable_Domicilio;
		$this->tablaTelefono = new Application_Model_DbTable_Telefono;
		$this->tablaEmail = new Application_Model_DbTable_Email;
	}
	
	public function obtenerFiscales($idEmpresa){
		
	}
	
	public function obtenerDomicilios($idEmpresa){
		
	}
	
	public function obtenerTelefonos($idEmpresa){
		
	}
	
	public function obtenerEmails($idEmpresa){
		
	}
}
