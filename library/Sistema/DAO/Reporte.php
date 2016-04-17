<?php
/**
 * 
 */
class Sistema_DAO_Reporte implements Sistema_Interfaces_IReporte {
	
	private $tablaReporte;
	private $tablaTipoReporte;
	
	public function __construct() {
		$this->tablaTipoReporte = new Sistema_Model_DbTable_TipoReporte;
		$this->tablaReporte = new Sistema_Model_DbTable_Reporte;
	}
}
