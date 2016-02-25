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
	
	public function obtenerNivel($idNivel){
		$tablaNivel = $this->tablaNivel;
		$select = $tablaNivel->select()->from($tablaNivel)->where("idNivel = ?",$idNivel);
		$rowNivel = $tablaNivel->fetchRow($select);
		$modelNivel = new Encuesta_Model_Nivel($rowNivel->toArray());
		
		return $modelNivel;
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
		$nivel->setHash($nivel->getHash());
		$select = $tablaNivel->select()->from($tablaNivel)->where("hash = ?", $nivel->getHash());
		$row = $tablaNivel->fetchRow($select);
		if(!is_null($row)) throw new Util_Exception_BussinessException("Nivel: <strong>" . $nivel->getNivel() . "</strong> duplicado en el sistema");
		try{
			$tablaNivel->insert($nivel->toArray());
		}catch(Exception $ex){
			throw new Util_Exception_BussinessException("<strong>" . $ex->getMessage() . "</strong>");
		}
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
