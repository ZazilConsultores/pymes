<?php
/**
 * 
 */
class Sistema_DAO_Fiscales implements Sistema_Interfaces_IFiscales {
	
	private $tablaFiscales;
	
	private $tablaFiscalesDomicilios;
	private $tablaDomicilio;
	private $tablaFiscalesTelefonos;
	private $tablaTelefono;
	private $tablaFiscalesEmail;
	private $tablaEmail;
	
	public function __construct() {
		$this->tablaFiscales = new Sistema_Model_DbTable_Fiscales;
		$this->tablaDomicilio = new Sistema_Model_DbTable_Domicilio;
		$this->tablaFiscalesDomicilios = new Sistema_Model_DbTable_FiscalesDomicilios;
		$this->tablaTelefono = new Sistema_Model_DbTable_Telefono;
		$this->tablaFiscalesTelefonos = new Sistema_Model_DbTable_FiscalesTelefonos;
		$this->tablaEmail = new Sistema_Model_DbTable_Email;
		$this->tablaFiscalesEmail = new Sistema_Model_DbTable_FiscalesEmail;
	}
	
	public function obtenerFiscales($idFiscales){
		$tablaFiscales = $this->tablaFiscales;
		$select = $tablaFiscales->select()->from($tablaFiscales)->where("idFiscales = ?", $idFiscales);
		$rowFiscal = $tablaFiscales->fetchRow($select);
		$modelFiscal = new Sistema_Model_Fiscales($rowFiscal->toArray());
		
		return $modelFiscal;
	}
	
	public function obtenerDomicilioFiscal($idFiscales){
		$tablaFiscalesDomicilio = $this->tablaFiscalesDomicilios;
		$select = $tablaFiscalesDomicilio->select()->from($tablaFiscalesDomicilio)->where("idFiscales = ?", $idFiscales);
		$rowDF = $tablaFiscalesDomicilio->fetchRow($select);
		//---------------------------------------------------------
		$tablaDomicilio = $this->tablaDomicilio;
		$select = $tablaDomicilio->select()->from($tablaDomicilio)->where("idDomicilio = ?", $rowDF->idDomicilio);
		$rowD = $tablaDomicilio->fetchRow($select);
		$modelDomicilio = new Sistema_Model_Domicilio($rowD->toArray());
		return $modelDomicilio;
	}
	
	public function obtenerTelefonosFiscales($idFiscales){
		$tablaFiscalesTelefonos = $this->tablaFiscalesTelefonos;
		$select = $tablaFiscalesTelefonos->select()->from($tablaFiscalesTelefonos)->where("idFiscales = ?", $idFiscales);
		$rowsTF = $tablaFiscalesTelefonos->fetchAll($select);
		//---------------------------------------------------------
		$tablaTelefono = $this->tablaTelefono;
		$modelsTelefonos = array();
		foreach ($rowsTF as $row) {
			$select = $tablaTelefono->select()->from($tablaTelefono)->where("idTelefono = ?",$row->idTelefono);
			$rowT = $tablaTelefono->fetchRow($select);
			$modelTelefono = new Sistema_Model_Telefono($rowT->toArray());
			$modelsTelefonos[] = $modelTelefono;
		}
		
		return $modelsTelefonos;
	}
	
	public function obtenerEmailsFiscales($idFiscales){
		$tablaFiscalesEmails = $this->tablaFiscalesEmail;
		$select = $tablaFiscalesEmails->select()->from($tablaFiscalesEmails)->where("idFiscales = ?", $idFiscales);
		$rowsEF = $tablaFiscalesEmails->fetchAll($select);
		//---------------------------------------------------------
		//print_r($rowsEF->toArray());
		$tablaEmails = $this->tablaEmail;
		$modelsEmails = array();
		foreach ($rowsEF as $row) {
			$select = $tablaEmails->select()->from($tablaEmails)->where("idEmail = ?",$row->idEmail);
			$rowE = $tablaEmails->fetchRow($select);
			$modelEmail = new Sistema_Model_Email($rowE->toArray());
			$modelsEmails[] = $modelEmail;
		}
		return $modelsEmails;
	}
	
	public function crearFiscales(Sistema_Model_Fiscales $fiscales){
		$tablaFiscales = $this->tablaFiscales;
		$fiscales->setHash($fiscales->getHash());
		$tablaFiscales->insert($fiscales->toArray());
		
		$select = $tablaFiscales->select()->from($tablaFiscales)->where("hash = ?", $fiscales->getHash());
		$rowFiscal = $tablaFiscales->fetchRow($select);
		$fiscales = new Sistema_Model_Fiscales($rowFiscal->toArray());
		return $fiscales; 
	}
	
	public function agregarDomicilioFiscal($idFiscales, Sistema_Model_Domicilio $domicilio){
		$tablaFiscalesDomicilios = $this->tablaFiscalesDomicilios;
		$registro = array();
		$registro["idFiscales"] = $idFiscales;
		$registro["idDomicilio"] = $domicilio->getIdDomicilio();
		$registro["esSucursal"] = "N";
		
		$tablaFiscalesDomicilios->insert($registro);
	}
	
	public function agregarTelefonoFiscal($idFiscales, Sistema_Model_Telefono $telefono){
		$tablaFiscalesTelefonos = $this->tablaFiscalesTelefonos;
		$registro = array();
		$registro["idFiscales"] = $idFiscales;
		$registro["idTelefono"] = $telefono->getIdTelefono();
		
		$tablaFiscalesTelefonos->insert($registro);
	}
	
	public function agregarEmailFiscal($idFiscales, Sistema_Model_Email $email){
		$tablaFiscalesEmail = $this->tablaFiscalesEmail;
		$registro = array();
		$registro["idFiscales"] = $idFiscales;
		$registro["idEmail"] = $email->getIdEmail();
		
		$tablaFiscalesEmail->insert($registro);
	}
	
}
