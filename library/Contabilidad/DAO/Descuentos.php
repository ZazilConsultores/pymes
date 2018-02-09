<?php
/**
 * @author Areli Morales Palma
 * @copyright 2017, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Contabilidad_DAO_Descuentos implements Contabilidad_Interfaces_IDescuentos{
	private $tablaDescuentos;

	
	public function __construct(){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaDescuentos = new Contabilidad_Model_DbTable_Descuentos(array('db'=>$dbAdapter));

	}
	
	public function obtenerDescuentos(){
	    $tD = $this->tablaDescuentos;
	    $rowsD = $tD->fetchAll();
	    
	    if(is_null($rowsD)){
	        return null;
	    }else{
	        return $rowsD->toArray();
	    }
	
	}
	
	public function obtenerDescuento($idDescuento){
	    $tD = $this->tablaDescuentos;
	    $select = $tD->select()->from($tD)->where("idDescuentos = ?",$idDescuento);
	    $rowDescuento  = $tD->fetchRow($select);
	    
	    if(is_null($rowDescuento)){
	        return null;
	    }else{
	        return $rowDescuento->toArray();
	    }
	    
	}
}
