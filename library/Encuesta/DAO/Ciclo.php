<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Ciclo implements Encuesta_Interfaces_ICiclo {
	
	private $tablaCiclo;
	
	public function __construct() {
		$this->tablaCiclo = new Encuesta_Model_DbTable_CicloE;;
	}
	
	public function obtenerCiclos($idPlan){
		$tablaCiclo = $this->tablaCiclo;
		$select = $tablaCiclo->select()->from($tablaCiclo)->where("idPlanE=?",$idPlan);
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
		$select = $tablaCiclo->select()->from($tablaCiclo)->where("idCiclo = ?",$idCiclo);
		$row = $tablaCiclo->fetchRow($select);
		
		$modelCiclo = new Encuesta_Model_Ciclo($row->toArray());
		
		return $modelCiclo;
	}
	
	public function obtenerCicloActual(){
		$tablaCiclo = $this->tablaCiclo;
		$select = $tablaCiclo->select()->from($tablaCiclo)->where("actual = ?","1");
		$row = $tablaCiclo->fetchRow($select);
		
		if(is_null($row)){
			throw new Util_Exception_BussinessException("Error: No hay ciclos escolares");
		}
		
		$modelCiclo = new Encuesta_Model_Ciclo($row->toArray());
		
		return $modelCiclo;
	}
	
	public function crearCiclo(Encuesta_Model_Ciclo $ciclo){
		$tablaCiclo = $this->tablaCiclo;
		$ciclo->setHash($ciclo->getHash());
		$select = $tablaCiclo->select()->from($tablaCiclo)->where("hash = ?",$ciclo->getHash());
		$row = $tablaCiclo->fetchRow($select);
		if(!is_null($row)) throw new Util_Exception_BussinessException("Error Ciclo: <strong>" . $ciclo->getCiclo() ."</strong> duplicado en el Sistema.");
		
		try{
			$tablaCiclo->insert($ciclo->toArray());
		}catch(Exception $ex){
			throw new Util_Exception_BussinessException("Error: <strong>" . $ex->getMessage() ."</strong>");
		}
		
	}
	
	public function editarCiclo($idCiclo, array $datos){
		$tablaCiclo = $this->tablaCiclo;
		$where = $tablaCiclo->getAdapter()->quoteInto("idCiclo = ?", $idCiclo);
		$tablaCiclo->update($datos, $where);
	}
	
	public function eliminarCiclo($idCiclo){
		$tablaCiclo = $this->tablaCiclo;
		$where = $tablaCiclo->getAdapter()->quoteInto("idCiclo = ?", $idCiclo);
		$tablaCiclo->delete($where);
	}
}
