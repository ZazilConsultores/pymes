<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Inventario_DAO_Estado implements Inventario_Interfaces_IEstado {
	private $tablaEstado;
	
	public function __construct()
	{
		$this->tablaEstado = new Application_Model_DbTable_Estado;
	}
	
	public function obtenerEstados(){
		$tablaEstado = $this->tablaEstado;
		$rowEstados = $tablaEstado->fetchAll();
		
		$modelEstados = array();
		
		foreach ($rowEstados as $rowEstado) {
			$modelEstado = new Application_Model_Estado($rowEstado->toArray());
			$modelEstado->setIdEstado($rowEstado->idEstado);
			
			$modelEstados[] = $modelEstado;
		}
		
		return $modelEstados;
	}
	
	public function obtenerMunicipios($idEstado){}
	
	public function crearEstado(Application_Model_Estado $estado){
		$tablaEstado = $this->tablaEstado;
		print_r($estado->toArray());
		//$tablaEstado->insert($estado->toArray());
	}
	
	public function editarEstado($idEstado, Application_Model_Estado $estado){}
	
	public function eliminarEstado($idEstado){}
}
