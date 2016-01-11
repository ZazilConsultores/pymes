<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Inventario_DAO_Empresa implements Inventario_DAO_IEmpresa {
	
	private $tablaEmpresa;
	
	function __construct() {
		$this->tablaFiscales = new Application_Model_DbTable_Fiscales;
		$this->tablaEmpresa = new Application_Model_DbTable_Empresa;
	}
	
	public function obtenerEmpresas(){
		$tablaEmpresa = $this->tablaEmpresa;
		$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("tipo = ?", "E");
		
		$rowEmpresas = $tablaEmpresa->fetchAll($select);
		$empresas = array();
		
		foreach ($rowEmpresas as $empresa) {
			$empresaModel = new Application_Model_Empresa($empresa->toArray());
			$empresaModel->setIdEmpresa($empresa->idEmpresa);
			
			$empresas[] = $empresaModel;
		}
		
		return $empresas;
	}
	
	public function obtenerClientes(){
		
	}
	
	public function obtenerProveedores(){
		
	}
}
