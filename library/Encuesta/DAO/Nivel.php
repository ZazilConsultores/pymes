<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Nivel implements Encuesta_Interfaces_INivel {
	
	private $tablaNivel;
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodencuesta');
		
		$this->tablaNivel = new Encuesta_Model_DbTable_NivelEducativo(array('db'=>$dbAdapter));
		//$this->tablaNivel->setDefaultAdapter($dbAdapter);
	}
	
	public function obtenerNivel($idNivel){
		$tablaNivel = $this->tablaNivel;
		$select = $tablaNivel->select()->from($tablaNivel)->where("idNivelEducativo = ?",$idNivel);
		$rowNivel = $tablaNivel->fetchRow($select);
		//$modelNivel = new Encuesta_Model_Nivel($rowNivel->toArray());
		
		return $rowNivel->toArray();
	}
	
	public function obtenerNiveles(){
		$tablaNivel = $this->tablaNivel;
		$rowsNiveles = $tablaNivel->fetchAll();
		/*
		$modelNiveles = array();
		foreach ($rowsNiveles as $row) {
			$modelNivel = new Encuesta_Model_Nivel($row->toArray());
			$modelNiveles[] = $modelNivel;
		}*/
		
		return $rowsNiveles->toArray();
	}
	
	public function crearNivel(array $nivel){
		$tablaNivel = $this->tablaNivel;
		try{
			$tablaNivel->insert($nivel);
		}catch(Exception $ex){
			throw new Util_Exception_BussinessException("<strong>" . $ex->getMessage() . "</strong>");
		}
	}
	
	public function editarNivel($idNivel, array $datos){
		$tablaNivel = $this->tablaNivel;
		$where = $tablaNivel->getAdapter()->quoteInto("idNivelEducativo = ?", $idNivel);
		$tablaNivel->update($datos, $where);
	}
	
	public function eliminarNivel($idNivel){
		$tablaNivel = $this->tablaNivel;
		$where = $tablaNivel->getAdapter()->quoteInto("idNivelEducativo = ?", $idNivel);
		$tablaNivel->delete($where);
	}
}
