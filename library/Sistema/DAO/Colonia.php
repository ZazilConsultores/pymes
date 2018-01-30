<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
 class Sistema_DAO_Colonia implements Sistema_Interfaces_IColonia {
 	
	private $tablaColonia;

	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		
		$this->tablaColonia = new Sistema_Model_DbTable_Colonia(array('db'=>$dbAdapter));
		
	}
	
	public function obtenerColonia($idColonia){
	    $tablaCol= $this->tablaColonia;
	    $select = $tablaCol->select()->from($tablaCol)->where("idColonia=?",$idColonia);
	    $rowColonia= $tablaCol->fetchRow($select);
	    return $rowColonia->toArray();
	    //print_r($select->__toString());
	    
	}
 }