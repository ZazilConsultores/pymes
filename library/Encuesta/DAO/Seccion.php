<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Seccion implements Encuesta_Interfaces_ISeccion {
	
	private $tablaEncuesta;
	private $tablaSeccion;
	private $tablaGrupo;
	private $tablaPregunta;
	
	public function __construct() {
		$this->tablaEncuesta = new Encuesta_Model_DbTable_Encuesta;
		$this->tablaSeccion = new Encuesta_Model_DbTable_Seccion;
		$this->tablaGrupo = new Encuesta_Model_DbTable_Grupo;
		$this->tablaPregunta = new Encuesta_Model_DbTable_Pregunta;
	}
	// =====================================================================================>>>   Buscar
	public function obtenerSeccion($idSeccion) {
		$tablaSeccion = $this->tablaSeccion;
		
		$select = $tablaSeccion->select()->from($tablaSeccion)->where("idSeccion = ?", $idSeccion);
		$rowSeccion = $tablaSeccion->fetchRow($select);
		
		$modelSeccion = new Encuesta_Model_Seccion($rowSeccion->toArray());
		
		return $modelSeccion;
	}
	
	public function obtenerSeccionHash($hash){
		$tablaSeccion = $this->tablaSeccion;
		
		$select = $tablaSeccion->select()->from($tablaSeccion)->where("hash = ?", $hash);
		$rowSeccion = $tablaSeccion->fetchRow($select);
		
		$modelSeccion = new Encuesta_Model_Seccion($rowSeccion->toArray());
		
		return $modelSeccion;
	}
	
	public function obtenerSecciones($idEncuesta) {
		$tablaSeccion = $this->tablaSeccion;
		$select = $tablaSeccion->select()->from($tablaSeccion)->where("idEncuesta = ?", $idEncuesta);
		
		$rowsSecciones = $tablaSeccion->fetchAll($select);
		$modelSecciones = array();
		
		foreach ($rowsSecciones as $row) {
			$modelSeccion = new Encuesta_Model_Seccion($row->toArray());
			$modelSecciones[] = $modelSeccion;
		}
		
		return $modelSecciones;
	}
	
	public function obtenerPreguntas($idSeccion){
		$tablaPregunta = $this->tablaPregunta;
		$select = $tablaPregunta->select()->from($tablaPregunta)->where("origen = ?", "S")->where("idOrigen = ?", $idSeccion);
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
	
	public function obtenerGrupos($idSeccion){
		$tablaGrupo = $this->tablaGrupo;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("idSeccion = ?", $idSeccion);
		$rowsGrupos = $tablaGrupo->fetchAll($select);
		$modelGrupos = array();
		if(!is_null($rowsGrupos)){
			foreach ($rowsGrupos as $rowGrupo) {
				$modelGrupo = new Encuesta_Model_Grupo($row->toArray());
				$modelGrupos[] = $modelGrupo;
			}
		}
		
		return $modelGrupos;
	}
	// =====================================================================================>>>   Crear
	public function crearSeccion(Encuesta_Model_Seccion $seccion) {
		$tablaSeccion = $this->tablaSeccion;
		$select = $tablaSeccion->select()->from($tablaSeccion)->where("idEncuesta = ?", $seccion->getIdEncuesta());
		$orden = count($tablaSeccion->fetchAll($select));
		$orden++;
		
		$seccion->setOrden($orden);
		$seccion->setElementos("0");
		$seccion->setHash($seccion->getHash());
		$seccion->setFecha(date("Y-m-d H:i:s", time()));
		
		$tablaSeccion->insert($seccion->toArray());
	}
	// =====================================================================================>>>   Editar
	public function editarSeccion($idSeccion, array $seccion) {
		$tablaSeccion = $this->tablaSeccion;
		$where = $tablaSeccion->getAdapter()->quoteInto("idSeccion = ?", $idSeccion);
		
		$tablaSeccion->update($seccion, $where);
	}
	// =====================================================================================>>>   Eliminar
	public function eliminarSeccion($idSeccion) {
		$tablaSeccion = $this->tablaSeccion;
		$where = $tablaSeccion->getAdapter()->quoteInto("idSeccion = ?", $idSeccion);
		
		$tablaSeccion->delete($where);
	}
	
	public function eliminarPreguntas($idSeccion){
		$tablaPregunta = $this->tablaPregunta;
		$select = $tablaPregunta->select()->from($tablaPregunta)->where("origen = ?", "S")->where("idOrigen = ?", $idSeccion);
		
		$tablaSeccion->delete($select);
	}
	
	public function eliminarGrupos($idSeccion){
		$tablaGrupo = $this->tablaGrupo;
		$tablaPregunta = $this->tablaPregunta;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("idSeccion = ?", $idSeccion);
		$grupos = $tablaGrupo->fetchAll($select);
		//Borramos todas las preguntas grupo por grupo
		foreach ($grupos as $grupo) {
			$selectP = $tablaPregunta->select()->from($tablaPregunta)->where("origen = ?", "G")->where("idOrigen = ?", $grupo->idGrupo);
			$tablaPregunta->delete($selectP); 
		}
		//Borramos todos los grupos
		$tablaGrupo->delete($select);
	}
}
