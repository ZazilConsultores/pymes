<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Ciclo implements Encuesta_Interfaces_ICiclo {
	
	private $tablaCiclo;
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodencuesta');
		
		$this->tablaCiclo = new Encuesta_Model_DbTable_CicloEscolar(array('db'=>$dbAdapter));
		//$this->tablaCiclo->setDefaultAdapter($dbAdapter);
	}
	
	public function obtenerCiclos($idPlan){
		$tablaCiclo = $this->tablaCiclo;
		$select = $tablaCiclo->select()->from($tablaCiclo)->where("idPlanEducativo = ?",$idPlan);
		$rowsCiclos = $tablaCiclo->fetchAll($select);
		$modelCiclos = array();
		
		foreach ($rowsCiclos as $row) {
			$modelCiclo = new Encuesta_Model_Ciclo($row->toArray());
			$modelCiclos[] = $modelCiclo;
		}
		
		return $modelCiclos;
	}
	
	public function obtenerCiclo($idCiclo){
		$tablaCiclo = $this->tablaCiclo;
		$select = $tablaCiclo->select()->from($tablaCiclo)->where("idCicloEscolar = ?",$idCiclo);
		$row = $tablaCiclo->fetchRow($select);
		
		//$modelCiclo = new Encuesta_Model_Ciclo($row->toArray());
		
		return $row->toArray();
	}
	
	public function obtenerCicloActual(){
		$tablaCiclo = $this->tablaCiclo;
		$select = $tablaCiclo->select()->from($tablaCiclo)->where("vigente = ?","1");
		$row = $tablaCiclo->fetchRow($select);
		
		if(is_null($row)){
			throw new Util_Exception_BussinessException("Error: No hay ciclos escolares");
		}
		
		$modelCiclo = new Encuesta_Model_Ciclo($row->toArray());
		
		return $modelCiclo;
	}
	
	/**
	 * Inserta un nuevo ciclo escolar en el modulo de encuestas
	 */
	public function crearCiclo(array $ciclo){
		$tablaCiclo = $this->tablaCiclo;
		
		$tablaCiclo->insert($ciclo);
	}
	
	public function editarCiclo($idCiclo, array $datos){
		$tablaCiclo = $this->tablaCiclo;
		$where = $tablaCiclo->getAdapter()->quoteInto("idCicloEscolar = ?", $idCiclo);
		$tablaCiclo->update($datos, $where);
	}
	
	public function eliminarCiclo($idCiclo){
		$tablaCiclo = $this->tablaCiclo;
		$where = $tablaCiclo->getAdapter()->quoteInto("idCicloEscolar = ?", $idCiclo);
		$tablaCiclo->delete($where);
	}
}
