<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Inventario_DAO_Empresa implements Inventario_Interfaces_IEmpresa {
	
	private $tablaEmpresa;
	
	private $tablaEmpresas;
	private $tablaClientes;
	private $tablaProveedores;
	
	function __construct() {
		$this->tablaEmpresa = new Application_Model_DbTable_Empresa;
		
		$this->tablaEmpresas = new Application_Model_DbTable_Empresas;
		$this->tablaClientes = new Application_Model_DbTable_Clientes;
		$this->tablaProveedores = new Application_Model_DbTable_Proveedores;
	}
	
	public function obtenerEmpresas(){
		$tablaEmpresas = $this->tablaEmpresas;
		$rowsEmpresas = $tablaEmpresas->fetchAll();
		print_r($rowsEmpresas);
		$empresas = array();
		foreach ($rowsEmpresas as $rowEmpresa) {
			//print_r($rowEmpresa);
			$empresaModel = new Application_Model_Empresas($rowEmpresa->toArray());
			$empresaModel->setIdEmpresa($rowEmpresa->idEmpresa);
			
			$empresas[] = $empresaModel;
		}
		print_r($empresas);
		return $empresas;
	}
	
	public function obtenerClientes(){
		$tablaClientes=$this->tablaClientes;
		$rowClientes=$tablaClientes->fetchAll();
		
		$cliente=array();
		foreach($rowClientes as $rowCliente){
			$clienteModel = new Application_Model_Cliente($rowCliente->toArray());
			$clienteModel->setIdCliente($rowCliente->idCliente);
			
			$cliente[]=$clienteModel;
		}
		return $cliente;
	}
	
	public function obtenerProveedores(){
		$tablaProvedores= $this->tablaProveedores;
		$rowProveedores=$tablaProvedores->fetchAll();
		
		$proveedor = array();
		foreach ($rowProveedores as $rowProveedor){
			$proveedorModel = new Application_Model_DbTable_Proveedores($rowProveedor->toArray());
			$proveedorModel->setIdProveedor($rowProveedor->idProveedor);
			
			$proveedor[] = $proveedorModel;
		}
		return $proveedor;
		
	}
}
