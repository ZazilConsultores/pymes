<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Sistema_DAO_Rol implements Sistema_Interfaces_IRol {
	
	private $tablaRol;
	
	public function __construct() {
		$this->tablaRol = new Sistema_Model_DbTable_Rol;
	}
	
	public function obtenerRoles() {
		$rowsRol = $this->tablaRol->fetchAll();
		
		$modelRoles = array();
		foreach ($rowsRol as $row) {
			$modelRol = new Sistema_Model_Rol($row->toArray());
			$modelRoles[] = $modelRol;
		}
		
		return $modelRoles;
	}
	
	public function crearRol(Sistema_Model_Rol $rol) {
		$rol->setHash($rol->getHash());
		$rol->setFecha(date("Y-m-d H:i:s", time()));
		
		$this->tablaRol->insert($rol->toArray());
	}
}
