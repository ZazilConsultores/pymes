<?php

class Contabilidad_DAO_TipoMovimiento implements Contabilidad_Interfaces_ITipoMovimiento {

	private $tablaTipoMovimiento;
	
	public function __construct()
	{
		$this->tablaTipoMovimiento= new Contabilidad_Model_DbTable_TipoMovimiento;
	}
	
	public function obtenerTiposMovimientos(){
		$tablaTipoMovimiento = $this->tablaTipoMovimiento;
		$rowTiposMovimientos = $tablaTipoMovimiento->fetchAll();
		
		$modelTiposMovimientos = array();
		
		foreach ($rowTiposMovimientos as $rowTipoMovimiento) {
			$modelTipoMovimiento = new Contabilidad_Model_TipoMovimiento($rowTipoMovimiento->toArray());
			$modelTipoMovimiento->setIdTipoMovimiento($rowTipoMovimiento->idTipoMovimiento);
			
			$modelTiposMovimientos[] = $modelTipoMovimiento;
		}
		
		return $modelTiposMovimientos;
	}
}