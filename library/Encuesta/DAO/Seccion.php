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
		//$modelSeccion->setIdSeccion($rowSeccion->idSeccion);
		//$modelSeccion->setIdEncuesta($rowSeccion->idEncuesta);
		//$modelSeccion->setOrden($rowSeccion->orden);
		//$modelSeccion->setElementos($rowSeccion->elementos);
		
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
		
		foreach ($rowsSecciones as $rowSeccion) {
			$modelSeccion = new Encuesta_Model_Seccion($rowSeccion->toArray());
			//$modelSeccion->setIdSeccion($rowSeccion->idSeccion);
			//$modelSeccion->setIdEncuesta($rowSeccion->idEncuesta);
			//$modelSeccion->setOrden($rowSeccion->orden);
			//$modelSeccion->setElementos($rowSeccion->elementos);
			
			$modelSecciones[] = $modelSeccion;
		}
		
		return $modelSecciones;
	}
	
	public function obtenerElementos($idSeccion) {
		$tablaGrupo = $this->tablaGrupo;
		$tablaPregunta = $this->tablaPregunta;
		
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("idSeccion = ?", $idSeccion);
		$gruposSeccion = $tablaGrupo->fetchAll($select);
		
		$select = $tablaPregunta->select()->from($tablaPregunta)->where("origen = ?", "S")->where("idOrigen = ?", $idSeccion);
		$preguntasSeccion = $tablaPregunta->fetchAll($select);
		
		$elementos = array();
		
		foreach ($gruposSeccion as $grupo) {
			$grupoModel = new Encuesta_Model_Grupo($grupo->toArray());
			
			$elementos[$grupo->orden] = $grupoModel; 
		}
		
		foreach ($preguntasSeccion as $pregunta) {
			$preguntaModel = new Encuesta_Model_Pregunta($pregunta->toArray());
			$preguntaModel->setIdPregunta($pregunta->idPregunta);
			
			$elementos[$pregunta->orden] = $preguntaModel;
		}
		
		ksort($elementos);
		
		return $elementos;
	}
	
	public function obtenerPreguntas($idSeccion){
		$tablaPregunta = $this->tablaPregunta;
		$select = $tablaPregunta->select()->from($tablaPregunta)->where("origen = ?", "S")->where("idOrigen = ?", $idSeccion);
		
		$rowsPreguntas = $tablaPregunta->fetchAll($select);
		$modelPreguntas = array();
		foreach ($rowsPreguntas as $rowPregunta) {
			$modelPregunta = new Encuesta_Model_Pregunta($rowPregunta->toArray());
			
			$modelPreguntas[] = $modelPregunta;
		}
		
		return $modelPreguntas;
	}
	
	public function obtenerGrupos($idSeccion){
		$tablaGrupo = $this->tablaGrupo;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("idSeccion = ?", $idSeccion);
		$rowsGrupos = $tablaGrupo->fetchAll($select);
		$modelGrupos = array();
		
		foreach ($rowsGrupos as $rowGrupo) {
			$modelGrupo = new Encuesta_Model_Grupo($rowGrupo->toArray());
			
			$modelGrupos[] = $modelGrupo;
		}
		
		return $modelGrupos;
	}
	// =====================================================================================>>>   Crear
	public function crearSeccion(Encuesta_Model_Seccion $seccion) {
		//primero buscamos todas las secciones asociadas con la encuesta, si no hay esta se designa como la seccion 0
		$tablaSeccion = $this->tablaSeccion;
		//Seleccionamos todas las secciones de la encuesta
		$select = $tablaSeccion->select()->from($tablaSeccion)->where("idEncuesta = ?", $seccion->getIdEncuesta());
		$orden = count($tablaSeccion->fetchAll($select));
		$orden++;
		$seccion->setOrden($orden);
		$seccion->setElementos("0");
		$seccion->setHash($seccion->getHash());
		
		$tablaSeccion->insert($seccion->toArray());
	}
	// =====================================================================================>>>   Editar
	public function editarSeccion($idSeccion, array $seccion) {
		$tablaSeccion = $this->tablaSeccion;
		/*
		$select = $tablaSeccion->select()->from($tablaSeccion)->where("idSeccion = ?", $idSeccion);
		$rowSeccion = $tablaSeccion->fetchRow($select);
		
		$seccion->setIdSeccion($idSeccion);
		$seccion->setIdEncuesta($rowSeccion->idEncuesta);
		$seccion->setFecha($rowSeccion->fecha);
		$seccion->setOrden($rowSeccion->orden);
		$seccion->setElementos($rowSeccion->elementos);
		$seccion->setHash($seccion->getHash());
		*/
		$where = $tablaSeccion->getAdapter()->quoteInto("idSeccion = ?", $idSeccion);
		
		//print_r($seccion->toArray());
		//$select = $tablaSeccion->select()->from($tablaSeccion)->where("idSeccion = ?", $idSeccion); 
		$tablaSeccion->update($seccion, $where);
	}
	// =====================================================================================>>>   Eliminar
	public function eliminarSeccion($idSeccion) {
		$tablaSeccion = $this->tablaSeccion;
		$where = $tablaSeccion->getAdapter()->quoteInto("idSeccion = ?", $idSeccion);
		//$select = $tablaSeccion->select()->from($tablaSeccion)->where("idSeccion = ?", $idSeccion);
		$tablaSeccion->delete($where);
	}
	
	public function eliminarPreguntas($idSeccion){
		$tablaPregunta = $this->tablaPregunta;
		$select = $tablaPregunta->select()->from($tablaPregunta)->where("origen = ?", "S")->where("idOrigen = ?", $idSeccion);
		
		$tablaSeccion->delete($select);
	}
	
	public function eliminarGrupos($idSeccion){
		$tablaGrupo = $this->tablaGrupo;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("idSeccion = ?", $idSeccion);
		//antes de borrar los grupos cerciorarse de que esten vacios.
		$tablaGrupo->delete($select);
	}
}
