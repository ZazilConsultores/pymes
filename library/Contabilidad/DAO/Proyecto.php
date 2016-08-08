<?php

class Contabilidad_DAO_Proyecto implements Contabilidad_Interfaces_IProyecto {
		
	private $tablaProyecto;
	
	public function __construct()
	{
		$this->tablaProyecto= new Contabilidad_Model_DbTable_Proyecto;
	}
	
	public function crearProyecto(Contabilidad_Model_Proyecto $proyecto)
	{
		$fechaApertura = new Zend_Date($proyecto->getFechaApertura());	
		$stringIni = $fechaApertura->toString('yyyy-MM-dd');
		
		$fechaCierre = new Zend_Date($proyecto->getFechaCierre());	
		$stringFin = $fechaCierre->toString('yyyy-MM-dd');
		
		//$Ganancia = $proyecto->getCostoFinal()- $proyecto->getCostoInicial();
		
		$proyecto->setFechaApertura($stringIni);		
		$proyecto->setFechaCierre($stringFin);
		//$proyecto->setGanancia($Ganancia);
		
		$this->tablaProyecto->insert($proyecto->toArray());		
	}
	
	public function obtenerProyectos(){
		$tablaProyecto = $this->tablaProyecto;
		$select = $tablaProyecto->select()->from($tablaProyecto);
		$rowProyectos = $tablaProyecto->fetchAll($select);
		
		$modelProyectos = array();
		
		foreach ($rowProyectos as $rowProyecto) {
			$modelProyecto = new Contabilidad_Model_Proyecto($rowProyecto->toArray());
			$modelProyecto->setIdProyecto($rowProyecto->idProyecto);
			
			$modelProyectos[] = $modelProyecto;
			
		}
		
		return $modelProyectos;
	}
	
	public function obtenerProyecto($idSucursal){
		$tablaProyecto = $this->tablaProyecto;
		$select = $tablaProyecto->select()->from($tablaProyecto)->where("idSucursal=?",$idSucursal);
		$rowsProyectos = $tablaProyecto->fetchAll($select);
		
		if(!is_null($rowsProyectos)){
			return $rowsProyectos->toArray();
		}else{
			return null;
		}
	}
}