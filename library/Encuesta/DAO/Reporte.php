<?php
/**
 * 
 */
class Encuesta_DAO_Reporte implements Encuesta_Interfaces_IReporte {
	
	private $tablaReporte;
	
	public function __construct() {
		$this->tablaReporte = new Encuesta_Model_DbTable_Reporte;
	}
	
	/**
	 * Agrega un nuevo reporte en la tabla Reporte
	 */
	public function agregarReporte($nombreReporte){
		$tablaReporte = $this->tablaReporte;
		
		$tablaReporte->insert(array('nombreReporte'=>$nombreReporte));
		$idReporte = $tablaReporte->getAdapter()->lastInsertId('Reporte','idReporte');
		//print_r($idReporte);
		return $idReporte;
	}
	
	/**
	 * 
	 */
	public function obtenerReporte($idReporte){
		$tablaReporte = $this->tablaReporte;
		$select = $tablaReporte->select()->from($tablaReporte)->where("idReporte=?",$idReporte);
		$rowReporte = $tablaReporte->fetchRow($select);
		
		return $rowReporte->toArray();
	}
}
