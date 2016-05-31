<?php
/**
 * 
 */
interface Sistema_Interfaces_IEmpresa {
	
	public function obtenerEmpresa($idEmpresa);
	public function obtenerEmpresaPorIdFiscales($idFiscales);
	
	public function obtenerIdFiscalesEmpresas();
	public function obtenerIdFiscalesClientes();
	public function obtenerIdFiscalesProveedores();
	
	//public function crearEmpresa(array $datos);
	//public function crearCliente($datos);
	//public function crearProveedor($datos);
	
}
