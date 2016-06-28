<?php
/**
 * 
 */
class Sistema_DAO_Sucursal implements Sistema_Interfaces_ISucursal {
	
	private $tablaSucursal;
	private $tablaDomicilio;
	private $tablaTelefono;
	
	public function __construct() {
		$this->tablaSucursal = new Sistema_Model_DbTable_Sucursal;
		$this->tablaDomicilio = new Sistema_Model_DbTable_Domicilio;
		$this->tablaTelefono = new Sistema_Model_DbTable_Telefono;
	}
	
	/**
	 * Obtenemos una sucursal de la T.Sucursal
	 */
	public function obtenerSucursal($idSucursal){
		$tablaSucursal = $this->tablaSucursal;
		$select = $tablaSucursal->select()->from($tablaSucursal)->where("idSucursal=?",$idSucursal);
		$rowSucursal = $tablaSucursal->fetchRow($select);
		
		if(!is_null($rowSucursal)){
			return $rowSucursal->toArray();
		}else{
			return null;
		}
	}
	
	public function obtenerSucursales($idFiscales){
		$tablaSucursal = $this->tablaSucursal;
		$select = $tablaSucursal->select()->from($tablaSucursal)->where("idFiscales=?",$idFiscales);
		$rowsSucursal = $tablaSucursal->fetchAll($select);
		
		if(!is_null($rowsSucursal)){
			return $rowsSucursal->toArray();
		}else{
			return null;
		}
	}	
	
	public function agregarSucursal($idFiscales, array $datos){
		$tablaSucursal = $this->tablaSucursal;
		//Obt
	}
	
	/**
	 * Obtenemos el Objeto model domicilio.
	 */
	public function obtenerDomicilioSucursal($idSucursal){
		$tablaDomicilio = $this->tablaDomicilio;
		$sucursal = $this->obtenerSucursal($idSucursal);
		$select = $tablaDomicilio->select()->from($tablaDomicilio)->where("idDomicilio=?",$sucursal["idDomicilio"]); 
		$rowDomicilio = $tablaDomicilio->fetchRow($select);
		
		if(!is_null($rowDomicilio)){
			return $rowDomicilio->toArray();
		}else{
			return null;
		}
	}
	
	/**
	 * Obtenemos todos los telefonos de la sucursal.
	 */
	public function obtenerTelefonosSucursal($idSucursal){
		$sucursal = $this->obtenerSucursal($idSucursal);
		$idsTelefonosSucursal = explode(",", $sucursal["idsTelefonos"]);
		$telefonos = array();
		$tablaTelefono = $this->tablaTelefono;
		foreach ($idsTelefonosSucursal as $index => $idTelefono) {
			$select = $tablaTelefono->select()->from($tablaTelefono)->where("idTelefono=?",$idTelefono);
			$rowTelefono = $tablaTelefono->fetchRow($select);
			$telefonos[] = $rowTelefono->toArray();
		}
		
		return $telefonos;
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
