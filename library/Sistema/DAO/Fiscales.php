<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Sistema_DAO_Fiscales implements Sistema_Interfaces_IFiscales {
	
	
	private $tablaFiscales;
	private $tablaEmpresa;
	
	public function __construct() {
		$this->tablaFiscales = new Sistema_Model_DbTable_Fiscales;
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa;
	}
	
	public function obtenerFiscales($idFiscales){
		$tablaFiscales = $this->tablaFiscales;
		$select  = $tablaFiscales->select()->from($tablaFiscales)->where("idFiscales = ?", $idFiscales);
		$rowFiscales = $tablaFiscales->fetchRow($select);
		$modelFiscales = new Sistema_Model_Fiscal($rowFiscales->toArray());
		return $modelFiscales;
	}
	
	public function obtenerFiscalesEmpresa() {
		
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("esEmpresa = ?", "S");
		$rowsEmpresas = $tablaEmpresa->fetchAll($select);
		
		$tablaFiscales = $this->tablaFiscales;
		$modelFiscales = array();
		foreach ($rowsEmpresas as $row) {
			$select = $tablaFiscales->select()->from($tablaFiscales)->where("idFiscales = ?", $row->idFiscales);
			$rowF = $tablaFiscales->fetchRow($select);
			
			$modelFiscal = new Sistema_Model_Fiscal($rowF->toArray());
			$modelFiscales[] = $modelFiscal;
		}
		
		return $modelFiscales;
	}
	
	public function obtenerFiscalesCliente() {
		$tablaFiscales = $this->tablaFiscales;
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("esCliente = ?", "S");
		$rowsEmpresas = $tablaEmpresa->fetchAll($select);
		
		$modelFiscales = array();
		foreach ($rowsEmpresas as $row) {
			$select = $tablaFiscales->select()->from($tablaFiscales)->where("idFiscales = ?", $row->idFiscales);
			$rowF = $tablaFiscales->fetchRow($select);
			
			$modelFiscal = new Sistema_Model_Fiscal($rowF->toArray());
			$modelFiscales[] = $modelFiscal;
		}
		
		return $modelFiscales;
	}
	
	public function obtenerFiscalesProveedor() {
		$tablaFiscales = $this->tablaFiscales;
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("esProveedor = ?", "S");
		$rowsEmpresas = $tablaEmpresa->fetchAll($select);
		
		$modelFiscales = array();
		foreach ($rowsEmpresas as $row) {
			$select = $tablaFiscales->select()->from($tablaFiscales)->where("idFiscales = ?", $row->idFiscales);
			$rowF = $tablaFiscales->fetchRow($select);
			
			$modelFiscal = new Sistema_Model_Fiscal($rowF->toArray());
			$modelFiscales[] = $modelFiscal;
		}
		
		return $modelFiscales;
	}
	
	public function crearFiscales(Sistema_Model_Fiscal $fiscal){
		$tablaFiscales = $this->tablaFiscales;
		$fiscal->setHash($fiscal->getHash());
		$fiscal->setFecha(date("Y-m-d H:i:s", time()));
		
		$tablaFiscales->insert($fiscal->toArray());
		$select = $tablaFiscales->select()->from($tablaFiscales)->where("hash = ?", $fiscal->getHash());
		$rowFiscal = $tablaFiscales->fetchRow($select);
		$modelFiscal = new Sistema_Model_Fiscal($rowFiscal->toArray());
		return $modelFiscal;
	}
	
	public function editarFiscales($idFiscal, array $fiscales){
		
	}
	
	public function eliminarFiscales($idFiscal){
		
	}
}