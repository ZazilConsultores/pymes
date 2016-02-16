<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Sistema_DAO_Parametro implements Sistema_Interfaces_IParametro {
	
	private $tablaParametro;
	private $tablaSubparametro;
	
	function __construct($argument) {
		$this->tablaParametro = new Sistema_Model_DbTable_Parametro;
		$this->tablaSubparametro = new Sistema_Model_DbTable_Subparametro;
	}
	
	public function obtenerParametros(){
		$rowsParametros = $this->tablaParametro->fetchAll();
		$modelParametros = array();
		foreach ($rowsParametros as $row) {
			$modelParametro = new Sistema_Model_Parametro($row->toArray());
			$modelParametros[] = $modelParametro;
		}
		
		return $modelParametros;
	}
	
	public function obtenerSubparametros($idParametro){
		$rowsSubparametros = $this->tablaSubparametro->fetchAll();
		$modelSubparametros = array();
		foreach ($rowsSubparametros as $row) {
			$modelSubparametro = new Sistema_Model_Subparametro($row->toArray());
			$modelSubparametros[] = $modelSubparametro;
		}
		
		return $modelSubparametros;
	}
	
	public function crearParametro(Sistema_Model_Parametro $parametro){
		$parametro->setHash($parametro->getHash());
		$parametro->setFecha(date("Y-m-d H:i:s", time()));
		
		$this->tablaParametro->insert($parametro->toArray());
	}

}