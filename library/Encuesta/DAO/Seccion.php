<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Seccion implements Encuesta_Interfaces_ISeccion {
	
	private $tablaEncuesta;
	private $tablaSeccionEncuesta;
	private $tablaGrupoEncuesta;
	private $tablaPregunta;
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodencuesta');
		
		$this->tablaEncuesta = new Encuesta_Model_DbTable_Encuesta(array('db'=>$dbAdapter));
		
		$this->tablaSeccionEncuesta = new Encuesta_Model_DbTable_SeccionEncuesta(array('db'=>$dbAdapter));
		
		$this->tablaGrupoEncuesta = new Encuesta_Model_DbTable_GrupoEncuesta(array('db'=>$dbAdapter));
		
		$this->tablaPregunta = new Encuesta_Model_DbTable_Pregunta(array('db'=>$dbAdapter));
	}
	// =====================================================================================>>>   Buscar
	public function obtenerSeccion($idSeccion) {
		$tablaSeccionEncuesta = $this->tablaSeccionEncuesta;
		
		$select = $tablaSeccionEncuesta->select()->from($tablaSeccionEncuesta)->where("idSeccionEncuesta = ?", $idSeccion);
		$rowSeccion = $tablaSeccionEncuesta->fetchRow($select);
		
		$modelSeccion = new Encuesta_Model_Seccion($rowSeccion->toArray());
		
		return $modelSeccion;
	}
	
	public function obtenerSecciones($idEncuesta) {
		$tablaSeccionEncuesta = $this->tablaSeccionEncuesta;
		$select = $tablaSeccionEncuesta->select()->from($tablaSeccionEncuesta)->where("idEncuesta = ?", $idEncuesta);
		
		$rowsSecciones = $tablaSeccionEncuesta->fetchAll($select);
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
		
		foreach ($rowsPreguntas as $row) {
			$modelPregunta = new Encuesta_Model_Pregunta($row->toArray());
			$modelPreguntas[] = $modelPregunta;
		}
		
		return $modelPreguntas;
	}
	
	public function obtenerGrupos($idSeccion){
		$tablaGrupoEncuesta = $this->tablaGrupoEncuesta;
		$select = $tablaGrupoEncuesta->select()->from($tablaGrupoEncuesta)->where("idSeccionEncuesta = ?", $idSeccion);
		$rowsGrupos = $tablaGrupoEncuesta->fetchAll($select);
		$modelGrupos = array();
		
		foreach ($rowsGrupos as $row) {
			$modelGrupo = new Encuesta_Model_Grupo($row->toArray());
			$modelGrupos[] = $modelGrupo;
		}
		
		return $modelGrupos;
	}
	// =====================================================================================>>>   Crear
	public function crearSeccion(Encuesta_Model_Seccion $seccion) {
		$tablaSeccion = $this->tablaSeccionEncuesta;
		$select = $tablaSeccion->select()->from($tablaSeccion)->where("idEncuesta = ?", $seccion->getIdEncuesta());
		$orden = count($tablaSeccion->fetchAll($select));
		$orden++;
		
		$seccion->setOrden($orden);
		$seccion->setElementos("0");
		//$seccion->setFecha(date("Y-m-d H:i:s", time()));
		
		$tablaSeccion->insert($seccion->toArray());
	}
	// =====================================================================================>>>   Editar
	public function editarSeccion($idSeccion, array $seccion) {
		$tablaSeccion = $this->tablaSeccionEncuesta;
		$where = $tablaSeccion->getAdapter()->quoteInto("idSeccionEncuesta = ?", $idSeccion);
		
		$tablaSeccion->update($seccion, $where);
	}
	// =====================================================================================>>>   Eliminar
	public function eliminarSeccion($idSeccion) {
		$tablaSeccion = $this->tablaSeccionEncuesta;
		$where = $tablaSeccion->getAdapter()->quoteInto("idSeccionEncuesta = ?", $idSeccion);
		
		$tablaSeccion->delete($where);
	}
	
	public function eliminarPreguntas($idSeccion){
		$tablaPregunta = $this->tablaPregunta;
		$select = $tablaPregunta->select()->from($tablaPregunta)->where("origen = ?", "S")->where("idOrigen = ?", $idSeccion);
		
		$tablaSeccion->delete($select);
	}
	
	public function eliminarGrupos($idSeccion){
		$tablaGrupoEncuesta = $this->tablaGrupoEncuesta;
		$tablaPregunta = $this->tablaPregunta;
		$select = $tablaGrupoEncuesta->select()->from($tablaGrupo)->where("idSeccionEncuesta = ?", $idSeccion);
		$grupos = $tablaGrupoEncuesta->fetchAll($select);
		//Borramos todas las preguntas grupo por grupo
		foreach ($grupos as $grupo) {
			$selectP = $tablaPregunta->select()->from($tablaPregunta)->where("origen = ?", "G")->where("idOrigen = ?", $grupo->idGrupo);
			$tablaPregunta->delete($selectP); 
		}
		//Borramos todos los grupos
		$tablaGrupo->delete($select);
	}
}
