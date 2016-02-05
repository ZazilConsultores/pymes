<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Grupo implements Encuesta_Interfaces_IGrupo {
	
	private $tablaSeccion;
	private $tablaGrupo;
	private $tablaPregunta;
		
	public function __construct() {
		$this->tablaSeccion = new Encuesta_Model_DbTable_Seccion;
		$this->tablaGrupo = new Encuesta_Model_DbTable_Grupo;
		$this->tablaPregunta = new Encuesta_Model_DbTable_Pregunta;
	}
	
	public function obtenerGrupo($idGrupo) {
		$tablaGrupo = $this->tablaGrupo;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("idGrupo = ?", $idGrupo);
		$rowGrupo = $tablaGrupo->fetchRow($select);
		
		$modelGrupo = new Encuesta_Model_Grupo($rowGrupo->toArray());
		
		return $modelGrupo;
	}
	
	public function obtenerGrupoHash($hash){
		$tablaGrupo = $this->tablaGrupo;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("hash = ?", $hash);
		$rowGrupo = $tablaGrupo->fetchRow($select);
		
		$modelGrupo = new Encuesta_Model_Grupo($rowGrupo->toArray());
		
		return $modelGrupo;
	}
	
	public function obtenerPreguntas($idGrupo) {
		$tablaPregunta = $this->tablaPregunta;
		$select = $tablaPregunta->select()->from($tablaPregunta)->where("origen = ?", "G")->where("idOrigen = ?", $idGrupo);
		$rowsPreguntas = $tablaPregunta->fetchAll($select);
		$modelPreguntas = array();
		
		if(!is_null($rowsPreguntas)){
			foreach ($rowsPreguntas as $row) {
				$modelPregunta = new Encuesta_Model_Pregunta($row->toArray());
				$modelPreguntas[] = $modelPregunta;
			}
		}
		
		return $modelPreguntas;
	}
	
	public function crearGrupo($idSeccion, Encuesta_Model_Grupo $grupo) {
		$tablaSeccion = $this->tablaSeccion;
		$select = $tablaSeccion->select()->from($tablaSeccion)->where("idSeccion = ?", $idSeccion);
		$seccion = $tablaSeccion->fetchRow($select);
		
		$tablaGrupo = $this->tablaGrupo;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("hash = ?", $grupo->getHash());
		$rowGrupo =$tablaGrupo->fetchRow($select);
		$existe = false;
		if(!is_null($rowGrupo)) $existe = true;
		
		if($existe){
			return $rowGrupo->idGrupo;
		}else{
			$seccion->elementos++;
			$seccion->save();
			
			$grupo->setOrden($seccion->elementos);
			$tablaGrupo->insert($grupo->toArray());
			$modelGrupo = $this->obtenerGrupoHash($grupo->getHash());
			return $modelGrupo->getIdGrupo();
		}
	}
	
	public function editarGrupo($idGrupo, array $grupo) {
		$tablaGrupo = $this->tablaGrupo;
		$where = $tablaGrupo->getAdapter()->quoteInto("idGrupo = ?", $idGrupo);
		
		$tablaGrupo->update($grupo, $where);
	}
	
	public function eliminarGrupo($idGrupo) {
		$tablaGrupo = $this->tablaGrupo;
		$where = $tablaGrupo->getAdapter()->quoteInto("idGrupo = ?", $idGrupo);
		
		$tablaGrupo->delete($where);
	}
	
	public function eliminarPreguntas($idGrupo){
		$tablaPregunta = $this->tablaPregunta;
		$where = $tablaPregunta->select()->from($tablaPregunta)->where("origen = ?", "G")->where("idOrigen = ?", $idGrupo);
		
		$tablaPregunta->delete($where);
	}
}
