<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
 class Sistema_DAO_RegimenFiscal implements Sistema_Interfaces_IRegimenFiscal {
 	
	private $tablaRegimenFiscal;
	
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		
		$this->tablaRegimenFiscal = new Sistema_Model_DbTable_RegimenFiscal(array('db'=>$dbAdapter));
	}

	public function obtenerRegimesFiscales(){
	    $tablaRF = $this->tablaRegimenFiscal;
	    
	    $select = $tablaRF->select()->from($tablaRF)->order("descripcion ASC");
	    $rowsRF = $tablaRF->fetchAll($select);
	    //print_r($select->__toString());
	    if(is_null($rowsRF)){
	        return null;
	    }else{
	        return $rowsRF->toArray();
	    }
	    
	}
 }