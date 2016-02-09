<?php
/**
 * 
 */
class Sistema_DAO_Empresa implements Sistema_Interfaces_IEmpresa {
	
	private $tablaEmpresa;
	
	private $tablaEmpresas;
	private $tablaClientes;
	private $tablaProveedores;
	
	
	public function __construct() {
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa;
		$this->tablaEmpresas = new Sistema_Model_DbTable_Empresas;
		$this->tablaClientes = new Sistema_Model_DbTable_Clientes;
		$this->tablaProveedores = new Sistema_Model_DbTable_Proveedores;
	}
	
	public function obtenerIdFiscalesEmpresas(){
		//Obtenemos todas las empresas
		$tablaEmpresas = $this->tablaEmpresas;
		$rowsEmpresas = $tablaEmpresas->fetchAll();
		
		$tablaEmpresa = $this->tablaEmpresa;
		
		$idFiscales = array();
		
		foreach ($rowsEmpresas as $row) {
			$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idEmpresa = ?", $row->idEmpresa);
			$rowEmpresa = $tablaEmpresa->fetchRow($select);
			
			$idFiscales[] = $rowEmpresa->idFiscales;
		}
		
		return $idFiscales;
	}
	
	public function obtenerIdFiscalesClientes(){
		$tablaClientes = $this->tablaClientes;
		$rowsClientes = $tablaClientes->fetchAll();
		
		$tablaEmpresa = $this->tablaEmpresa;
		
		$idFiscales = array();
		
		foreach ($rowsClientes as $row) {
			$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idEmpresa = ?", $row->idEmpresa);
			$rowEmpresa = $tablaEmpresa->fetchRow($select);
			
			$idFiscales[] = $rowEmpresa->idFiscales;
		}
		
		return $idFiscales;
	}
	
	public function obtenerIdFiscalesProveedores(){
		$tablaProveedores = $this->tablaProveedores;
		$rowsProveedores = $tablaProveedores->fetchAll();
		
		$tablaEmpresa = $this->tablaEmpresa;
		
		$idFiscales = array();
		
		foreach ($rowsProveedores as $row) {
			$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idEmpresa = ?", $row->idEmpresa);
			$rowEmpresa = $tablaEmpresa->fetchAll($select);
			
			$idFiscales[] = $rowEmpresa->idFiscales;
		}
		
	}
}
