<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
 class Contabilidad_DAO_GuiaContable implements Contabilidad_Interfaces_IGuiaContable {
 

	private $tablaGuiaContable;
	private $tablaModulos;
	
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaGuiaContable = new Contabilidad_Model_DbTable_GuiaContable(array('db'=>$dbAdapter));
		$this->tablaModulos = new Contabilidad_Model_DbTable_Modulos(array('db'=>$dbAdapter));
		
	}
	
	public function altaModulo(Contabilidad_Model_Modelo $modulo){
		$tablaModulos = $this->tablaModulos;
		$tablaModulos->insert($modulo->toArray());
		
	}
	public function obtenerModulo($idModulo){
		
	}
	public function odtenerModulos(){
		
	}
	public function editarModulo(){
		
	}
	public function altaCuentaGuia(){
		
	}
	public function obtenerCuentasGuia(){
		
	}
	public function editarCuentaGuia(){
		
	}
	
 }