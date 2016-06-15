<?php
/**
 * 
 */
class Sistema_DAO_Sucursal implements Sistema_Interfaces_ISucursal {
	
	private $tablaSucursal;
	
	public function __construct() {
		$this->tablaSucursal = new Sistema_Model_DbTable_Sucursal;
	}
	
	public function agregarSucursal($idFiscales, array $datos){
		$tablaSucursal = $this->tablaSucursal;
		//Obt
	}
	
	public function editarDomicilioSucursal($idSucursal, $idDomicilio,array $datos){
		$tablaSucursal = $this->tablaSucursal;
	}
	
	public function editarTelefonoSucursal($idSucursal, $idTelefono,array $datos){
		$tablaSucursal = $this->tablaSucursal;
	}
	
	public function editarEmailSucursal($idSucursal, $idEmail,array $datos){
		$tablaSucursal = $this->tablaSucursal;
	}
}
