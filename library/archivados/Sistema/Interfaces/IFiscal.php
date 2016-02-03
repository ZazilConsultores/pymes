<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Sistema_Interfaces_IFiscal {
	public function obtenerFiscales($idFiscal);
	
	public function obtenerFiscalesEmpresa();
	public function obtenerFiscalesCliente();
	public function obtenerFiscalesProveedor();
	
	public function crearFiscales(Sistema_Model_Fiscal $fiscal);
	public function editarFiscales($idFiscal, array $fiscales);
	public function eliminarFiscales($idFiscal);
}
