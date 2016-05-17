<?php
/**
 * 
 */
class Encuesta_DAO_Reporte implements Encuesta_Interfaces_IReporte {
	
	private $tablaReporte;
	private $tablaERealizadas;
	
	public function __construct() {
		$this->tablaReporte = new Encuesta_Model_DbTable_Reporte;
		$this->tablaERealizadas = new Encuesta_Model_DbTable_ERealizadas;
		
	}
	
	/**
	 * Agrega un nuevo reporte en la tabla Reporte
	 */
	public function agregarReporteGrupal($nombreReporte,$idEncuesta,$idAsignacion){
		$tablaReporte = $this->tablaReporte;
		$select = $tablaReporte->select()->from($tablaReporte)->where("nombreReporte=?",$nombreReporte);
		$rowReporte = $tablaReporte->fetchRow($select);
		$idReporte = null;
		if(is_null($rowReporte)){
			$tablaReporte->insert(array('nombreReporte'=>$nombreReporte,'estatus'=>'A'));
			$idReporte = $tablaReporte->getAdapter()->lastInsertId('Reporte','idReporte');
		}else{
			$idReporte = $rowReporte->idReporte;
		}
		
		$tablaERealizadas = $this->tablaERealizadas;
		$select = $tablaERealizadas->select()->from($tablaERealizadas)->where("idEncuesta=?",$idEncuesta)->where("idAsignacion=?",$idAsignacion);
		$rowRealizadas = $tablaERealizadas->fetchRow($select);
		
		$rowRealizadas->idReporte = $idReporte;
		$rowRealizadas->save();
		
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
