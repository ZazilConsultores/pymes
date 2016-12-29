<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Contabilidad_DAO_Tesoreria implements Contabilidad_Interfaces_ITesoreria{
	
	private $tablaMovimiento;
	private $tablaFactura;
	private $tablaFacturaDetalle;
	
	private $tablaEmpresa;
	
	public function __construct(){
		$this->tablaMovimiento = new Contabilidad_Model_DbTable_Movimientos;
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa;
	}
	public function obtenerEmpleadosNomina(){
		
	$tablaEmpresa = $this->tablaEmpresa;
		$select=$tablaEmpresa->select()
		->setIntegrityCheck(false)
		->from($tablaEmpresa, array('idEmpresa'))
		->join('Fiscales', 'Empresa.idFiscales = Fiscales.idFiscales', array('razonSocial'))
		->join('Proveedores','Empresa.idEmpresa = Proveedores.idEmpresa')
		->where('Proveedores.idTipoProveedor = 2')
		->order('razonSocial ASC');
		return $tablaEmpresa->fetchAll($select);		
		
	}
	
	public function crearNomina( array $datos){
		
	}	
}