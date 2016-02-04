<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Sistema_Interfaces_IEmpresa {
		
	public function obtenerEmpresa($idEmpresa);
	public function obtenerEmpresas();
	public function obtenerClientes();
	public function obtenerProveedores();
	public function crearEmpresa(Sistema_Model_Empresa $empresa);
	public function editarEmpresa($idEmpresa, array $empresa);
	public function eliminarEmpresa($idEmpresa);
	
	//public function obtenerEmpresaIdFiscales($idFiscales);
	//public function crearEmpresaFiscales(Sistema_Model_Fiscal $fiscal, Sistema_Model_Domicilio $domicilio, Sistema_Model_Telefono $telefono,Sistema_Model_Email $email);
}
