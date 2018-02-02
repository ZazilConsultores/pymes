<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
 class Inventario_DAO_Cardex implements Inventario_Interfaces_ICardex {
	
	private $tablaCardex;

	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
	
		$this->tablaCardex = new Contabilidad_Model_DbTable_Cardex(array('db'=>$dbAdapter));
	}
	public function obtenerIdProductoCardex($idSucursal,$idProducto){
	    $tablaCardex = $this->tablaCardex;
	    $select = $tablaCardex->select()->from($tablaCardex)->where("idProducto = ?", $idProducto)
	    ->where("idSucursal = ?", $idSucursal);
	    //print_r($select->__toString());
	    $rowsProducto = $tablaCardex->fetchAll($select);
	    if(is_null($rowsProducto)){
	        return null;
	    }else{
	        return $rowsProducto->toArray();
	    }
	    
	}
 }