<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
 class Sistema_DAO_Domicilio implements Sistema_Interfaces_IDomicilio {
 	
	private $tablaDomicilio;
	private $tablaFiscalesDomicilios;
	
	public function __construct()
	{
		$this->tablaDomicilio = new Sistema_Model_DbTable_Domicilio;
		$this->tablaFiscalesDomicilios = new Sistema_Model_DbTable_FiscalesDomicilios;
	}
	
	public function obtenerDomicilio($idDomicilio) {
		$tablaDomicilio = $this->tablaDomicilio;
		$select = $tablaDomicilio->select()->from($tablaDomicilio)->where("idDomicilio = ?", $idDomicilio);
		$rowDomicilio = $tablaDomicilio->fetchRow($select);
		
		$modelDomicilio = new Sistema_Model_Domicilio($rowDomicilio->toArray());
		return $modelDomicilio;
	}
	
	public function obtenerDomicilioFiscal($idFiscal) {
		$tablaDomicilio = $this->tablaDomicilio;
		$tablaFiscalesDomicilio = $this->tablaFiscalesDomicilios;
		$select = $tablaFiscalesDomicilio->select()->from($tablaFiscalesDomicilio)->where("idFiscal = ?", $idFiscal);
		$rowFiscalesDomicilio = $tablaFiscalesDomicilio->fetchRow($select);
		$select = $tablaDomicilio->select()->from($tablaDomicilio)->where("idDomicilio = ?", $rowFiscalesDomicilio->idDomicilio);
		$rowDomicilio = $tablaDomicilio->fetchRow($select);
		$modelDomicilio = new Sistema_Model_Domicilio($rowDomicilio->toArray());
		
		return $modelDomicilio;
	}
	
	public function obtenerDomiciliosFiscales() {
		$tablaDomicilio = $this->tablaDomicilio;
		$tablaFiscalesDomicilio = $this->tablaFiscalesDomicilios;
		$rowsFiscalesDomicilio = $tablaFiscalesDomicilio->fetchAll();
		$modelDomicilios = array();
		
		foreach ($rowsFiscalesDomicilio as $row) {
			$select = $tablaDomicilio->select()->from($tablaDomicilio)->where("idDomicilio = ?", $row->idDomicilio);
			$rowDomicilio = $tablaDomicilio->fetchRow($select);
			$modelDomicilio = new Sistema_Model_Domicilio($rowDomicilio->toArray());
			$modelDomicilios[$row->idFiscales] = $modelDomicilio;
		}
		
		return $modelDomicilios;
	}
	
	public function obtenerDomicilioSucursal($idSucursal){}
	public function obtenerDomiciliosSucursales($idFiscal){}
	public function obtenerDomiciliosSucursalesEstado($idFiscal, $idEstado){}
	
	public function crearDomicilio(Sistema_Model_Domicilio $domicilio){
		$tablaDomicilio = $this->tablaDomicilio;
		$domicilio->setHash($domicilio->getHash());
		$tablaDomicilio->insert($domicilio->toArray());
	}
	
	public function crearDomicilioFiscal($idFiscal, Sistema_Model_Domicilio $domicilio) {
		$tablaDomicilio = $this->tablaDomicilio;
		$tablaFiscalesDomicilio = $this->tablaFiscalesDomicilios;
		//Creamos el domicilio en la tabla domicilio
		$domicilio->setHash($domicilio->getHash());
		$tablaDomicilio->insert($domicilio->toArray());
		//Creamos la relacion en la tabla fiscalesDomicilios
		$select = $tablaDomicilio->select()->from($tablaDomicilio)->where("hash = ?",$domicilio->getHash());
		$rowDomicilio = $tablaDomicilio->fetchRow($select);
		
		$datos = array();
		$datos["idDomicilio"] = $rowDomicilio->idDomicilio;
		$datos["idFiscales"] = $idFiscal;
		$datos["esSucursal"] = "N";
		
		$tablaFiscalesDomicilio->insert($datos);
	}
	
	public function editarDomicilio($idDomiclio, array $domicilio){}
	public function eliminarDomicilio($idDomiclio){}
 }