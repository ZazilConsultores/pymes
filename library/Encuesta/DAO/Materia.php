<?php
/**
 * 
 */
class Encuesta_DAO_Materia implements Encuesta_Interfaces_IMateria {
	
	private $tablaMateria;
	
	public function __construct()
	{
		$this->tablaMateria = new Encuesta_Model_DbTable_MateriaE;
	}
	
	public function obtenerMateria($idMateria){
		$tablaMateria = $this->tablaMateria;
		$select = $tablaMateria->select()->from($tablaMateria)->where("idMateria = ?",$idMateria);
		$rowMateria = $tablaMateria->fetchRow($select);
		$modelMateria = new Encuesta_Model_Materia($rowMateria->toArray());
		
		return $modelMateria;
	}
	
	public function obtenerMaterias($idCiclo,$idGrado){
		$tablaMateria = $this->tablaMateria;
		$select = $tablaMateria->select()->from($tablaMateria)->where("idCiclo=?",$idCiclo)->where("idGrado=?",$idGrado);
		$rowsMaterias = $tablaMateria->fetchAll($select);
		$modelMaterias = array();
		foreach ($rowsMaterias as $row) {
			$modelMateria = new Encuesta_Model_Materia($row->toArray());
			$modelMaterias[] = $modelMateria;
		}
		
		return $modelMaterias;
	}
	
	public function obtenerMateriasGrupo($idCiclo,$idGrupo){
		$tablaMateria = $this->tablaMateria;
		$select = $tablaMateria->select()->from($tablaMateria)->where("idCiclo=?",$idCiclo)->where("idGrupo=?",$idGrupo);
		$rowsMaterias = $tablaMateria->fetchAll($select);
		$modelMaterias = array();
		foreach ($rowsMaterias as $row) {
			$modelMateria = new Encuesta_Model_Materia($row->toArray());
			$modelMaterias[] = $modelMateria;
		}
		return $modelMaterias;
	}
	
	public function crearMateria(Encuesta_Model_Materia $materia){
		$tablaMateria = $this->tablaMateria;
		$materia->setHash($materia->getHash());
		$select = $tablaMateria->select()->from($tablaMateria)->where("hash=?",$materia->getHash());
		
		try{
			$tablaMateria->insert($materia->toArray());
			
		}catch(Exception $ex){
			throw new Util_Exception_BussinessException("Materia: ". $materia->getMateria() ." duplicada en el sistema.\n<br />" . $ex->__toString());
		}
		
		
	}
	
	public function editarMateria($idMateria, array $materia){
		$tablaMateria = $this->tablaMateria;
		$where = $tablaMateria->getAdapter()->quoteInto("idMateria=?", $idMateria);
		$tablaMateria->update($materia, $where);
	}
}
