<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */

class Contabilidad_DAO_CFDI implements Contabilidad_Interfaces_Icfdi{
     
     private $tablaCFDI;
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaCFDI = new Contabilidad_Model_DbTable_CFDI(array('db'=>$dbAdapter));
	}
	
	public function obtenerCFDI()
	{
		$tablaCFDI = $this->tablaCFDI;
		
		$select = $tablaCFDI->select()->from($tablaCFDI)->order("descripcion ASC");
		$rowsCFDI = $tablaCFDI->fetchAll($select);
		//print_r($select->__toString());
		if(is_null($rowsCFDI)){
		    return null;
		}else{
		    return $rowsCFDI->toArray();
		}
	}
	
 }