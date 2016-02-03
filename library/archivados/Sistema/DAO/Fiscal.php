<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Sistema_DAO_Fiscal implements Sistema_Interfaces_IFiscal {
	
	
	private $tablaFiscal;
	private $tablaEmpresa;
	private $empresaDAO;
	
	
	public function __construct() {
		$this->tablaFiscal = new Sistema_Model_DbTable_Fiscal;
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa;
		$this->empresaDAO = new Sistema_DAO_Empresa;
	}
	
	public function obtenerFiscales($idFiscal){
		$tablaFiscal = $this->tablaFiscal;
		$select  = $tablaFiscal->select()->from($tablaFiscal)->where("idFiscal = ?", $idFiscal);
		$rowFiscal = $tablaFiscal->fetchRow($select);
		$modelFiscal = new Sistema_Model_Fiscal($rowFiscal->toArray());
		return $modelFiscal;
	}
	
	public function obtenerFiscalesEmpresa() {
		
		$empresas = $this->empresaDAO->obtenerEmpresas();
		$tablaFiscal = $this->tablaFiscal;
		$modelFiscales = array();
		foreach ($empresas as $empresa) {
			$select = $tablaFiscal->select()->from($tablaFiscal)->where("idFiscal = ?", $empresa->getIdFiscal());
			$rowF = $tablaFiscal->fetchRow($select);
			
			$modelFiscal = new Sistema_Model_Fiscal($rowF->toArray());
			$modelFiscales[] = $modelFiscal;
		}
		
		return $modelFiscales;
	}
	
	public function obtenerFiscalesCliente() {
		
		$clientes = $this->empresaDAO->obtenerClientes();
		$tablaFiscal = $this->tablaFiscal;
		$modelFiscales = array();
		foreach ($clientes as $cliente) {
			$select = $tablaFiscal->select()->from($tablaFiscal)->where("idFiscal = ?", $cliente->getIdFiscal());
			$rowF = $tablaFiscal->fetchRow($select);
			
			$modelFiscal = new Sistema_Model_Fiscal($rowF->toArray());
			$modelFiscales[] = $modelFiscal;
		}
		
		return $modelFiscales;
	}
	
	public function obtenerFiscalesProveedor() {
		
		$proveedores = $this->empresaDAO->obtenerProveedores();
		$tablaFiscal = $this->tablaFiscal;
		$modelFiscales = array();
		foreach ($proveedores as $proveedor) {
			$select = $tablaFiscal->select()->from($tablaFiscal)->where("idFiscal = ?", $proveedor->getIdFiscal());
			$rowF = $tablaFiscal->fetchRow($select);
			
			$modelFiscal = new Sistema_Model_Fiscal($rowF->toArray());
			$modelFiscales[] = $modelFiscal;
		}
		
		return $modelFiscales;
	}
	
	public function crearFiscales(Sistema_Model_Fiscal $fiscal){
		$tablaFiscal = $this->tablaFiscal;
		$fiscal->setHash($fiscal->getHash());
		$fiscal->setFecha(date("Y-m-d H:i:s", time()));
		
		$tablaFiscal->insert($fiscal->toArray());
		$select = $tablaFiscal->select()->from($tablaFiscal)->where("hash = ?", $fiscal->getHash());
		$rowFiscal = $tablaFiscal->fetchRow($select);
		$modelFiscal = new Sistema_Model_Fiscal($rowFiscal->toArray());
		return $modelFiscal;
	}
	
	public function editarFiscales($idFiscal, array $fiscales){
		$tablaFiscal = $this->tablaFiscal;
		$where = $tablaFiscal->getAdapter()->quoteInto("idFiscal = ?", $idFiscal);
		$tablaFiscal->update($fiscales, $where);
		
	}
	
	public function eliminarFiscales($idFiscal){
		
	}
}