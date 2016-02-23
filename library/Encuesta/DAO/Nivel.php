<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Nivel implements Encuesta_Interfaces_INivel {
	
	private $tablaNivel;
	
	public function __construct() {
		$this->tablaNivel = new Encuesta_Model_DbTable_NivelE;
		
	}
	
	public function obtenerNiveles(){
		$tablaNivel = $this->tablaNivel;
		$rowsNiveles = $tablaNivel->fetchAll();
		$modelNiveles = array();
		foreach ($rowsNiveles as $row) {
			$modelNivel = new Encuesta_Model_Nivel($row->toArray());
			$modelNiveles[] = $modelNivel;
		}
		
		return $modelNiveles;
	}
	
	public function crearNivel(Encuesta_Model_Nivel $nivel){
		$tablaNivel = $this->tablaNivel;
		$tablaNivel->insert($nivel->toArray());
	}
	
	public function editarNivel($idNivel, array $datos){
		$tablaNivel = $this->tablaNivel;
		$where = $tablaNivel->getAdapter()->quoteInto("idNivel = ?", $idNivel);
		$tablaNivel->update($datos, $where);
	}
	
	public function eliminarNivel($idNivel){
		$tablaNivel = $this->tablaNivel;
		$where = $tablaNivel->getAdapter()->quoteInto("idNivel = ?", $idNivel);
		$tablaNivel->delete($where);
	}
}
