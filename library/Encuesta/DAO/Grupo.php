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
		
	function __construct() {
		$this->tablaSeccion = new Encuesta_Model_DbTable_Seccion;
		$this->tablaGrupo = new Encuesta_Model_DbTable_Grupo;
		$this->tablaPregunta = new Encuesta_Model_DbTable_Pregunta;
		
	}
	
	public function obtenerGrupo($idGrupo) {
		$tablaGrupo = $this->tablaGrupo;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("idGrupo = ?", $idGrupo);
		$rowGrupo = $tablaGrupo->fetchRow($select);
		
		$modelGrupo = new Encuesta_Model_Grupo($rowGrupo->toArray());
		
		$modelGrupo->setIdGrupo($rowGrupo->idGrupo);
		$modelGrupo->setIdSeccion($rowGrupo->idSeccion);
		$modelGrupo->setOrden($rowGrupo->orden);
		$modelGrupo->setElementos($rowGrupo->elementos);
		
		return $modelGrupo;
	}
	
	public function obtenerGrupos($idSeccion) {
		$tablaGrupo = $this->tablaGrupo;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("idSeccion = ?", $idSeccion);
		$rowsGrupos = $tablaGrupo->fetchAll($select);
		$modelGrupos = array();
		foreach ($rowsGrupos as $rowGrupo) {
			$modelGrupo = new Encuesta_Model_Grupo($rowGrupo->toArray());
			$modelGrupo->setIdGrupo($rowGrupo->idGrupo);
			$modelGrupo->setIdSeccion($rowGrupo->idSeccion);
			$modelGrupo->setOrden($rowGrupo->orden);
			$modelGrupo->setElementos($rowGrupo->elementos);
			
			$modelGrupos[] = $modelGrupo;
		} 
		return $modelGrupos;
	}
	
	public function obtenerPreguntas($idGrupo){
		$tablaPregunta = $this->tablaPregunta;
		$select = $tablaPregunta->select()->from($tablaPregunta)->where("origen = ?", "G")->where("idOrigen = ?", $idGrupo);
		
		$rowsPreguntas = $tablaPregunta->fetchAll($select);
		$modelPreguntas = array();
		
		foreach ($rowsPreguntas as $rowPregunta) {
			$modelPregunta = new Encuesta_Model_Pregunta($rowPregunta->toArray());
			$modelPregunta->setIdPregunta($rowPregunta->idPregunta);
			
			$modelPreguntas[] = $modelPregunta;
		}
		
		return $modelPreguntas;
	}
	
	public function crearGrupo(Encuesta_Model_Grupo $grupo) {
		$tablaSeccion = $this->tablaSeccion;
		$tablaGrupo = $this->tablaGrupo;
		
		$select = $tablaSeccion->select()->from($tablaSeccion)->where("idSeccion = ?", $grupo->getIdSeccion());
		$seccion = $tablaSeccion->fetchRow($select);
		//obtenemos todos los grupos de la seccion y los contamos
		//$select = $tablaGrupo->select()->from($tablaGrupo)->where("idSeccion = ?", $grupo->getIdSeccion());
		//$numeroGrupos = count($tablaGrupo->fetchAll($select));
		//$grupo->setIdSeccion($idSeccion);
		//$grupo->setOrden($numeroGrupos);
		$grupo->setOrden($seccion->elementos);
		$seccion->elementos++;
		$seccion->save();
		$tablaGrupo->insert($grupo->toArray());
	}
	
	public function editarGrupo($idGrupo, Encuesta_Model_Grupo $grupo) {
		$tablaGrupo = $this->tablaGrupo;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("idGrupo = ?", $grupo->getIdGrupo())->where("idSeccion = ?", $grupo->getIdSeccion());
		$grupo->setIdGrupo($idGrupo);
		//$grupo->setIdSeccion($idSeccion);
		$tablaGrupo->update($grupo, $select);
	}
	
	public function eliminarGrupo($idGrupo) {
		$tablaGrupo = $this->tablaGrupo;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("idGrupo = ?", $idGrupo);
		$tablaGrupo->delete($select);
	}
}
