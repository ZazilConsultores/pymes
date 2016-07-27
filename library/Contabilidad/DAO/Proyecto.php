<?php

class Contabilidad_DAO_Proyecto implements Contabilidad_Interfaces_IProyecto {
		
	private $tablaProyecto;
	
	public function __construct()
	{
		$this->tablaProyecto= new Contabilidad_Model_DbTable_Proyecto;
	}
	
	public function obtenerProyecto(){
		$tablaProyecto = $this->tablaProyecto;
		$rowProyectos = $tablaProyecto->fetchAll();
		
		$modelProyectos = array();
		foreach ($rowProyectos as $rowProyecto) {
			$modelProyecto = new Contabilidad_Model_Proyecto($rowProyecto->toArray());
			$modelProyecto->setIdProyecto($rowProyecto->idProyecto);
			
			$modelProyectos[] = $modelProyecto;
		}
		return $modelProyectos;
	}
	
	public function obtenerProyectos($idFiscales){
		$tablaProyecto = $this->tablaProyecto;
		$select = $tablaProyecto->select()->from($tablaProyecto)->where("idCoP=?",$idFiscales);
		$rowsProyecto = $tablaProyecto->fetchAll($select);
		
		if(!is_null($rowsProyecto)){
			return $rowsProyecto->toArray();
		}else{
			return null;
		}
	}
}