<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Seccion implements Zazil_Interfaces_ISeccion {
	
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
	public function obtenerSeccionId($idSeccion) {
		$tablaSeccion = $this->tablaSeccion;
		
		$select = $tablaSeccion->select()->from($tablaSeccion)->where("idSeccion = ?", $idSeccion);
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
			$grupoModel->setIdGrupo($grupo->idGrupo);
			$grupoModel->setIdSeccion($grupo->idSeccion);
			$grupoModel->setOrden($grupo->orden);
			$grupoModel->setElementos($grupo->elementos);
			
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
	// =====================================================================================>>>   Crear
	public function crearSeccion(Encuesta_Model_Seccion $seccion) {
		//primero buscamos todas las secciones asociadas con la encuesta, si no hay esta se designa como la seccion 0
		$tablaSeccion = $this->tablaSeccion;
		//Seleccionamos todas las secciones de la encuesta
		$select = $tablaSeccion->select()->from($tablaSeccion)->where("idEncuesta = ?", $seccion->getIdEncuesta());
		$orden = count($tabla->fetchAll($select));
		$orden++;
		$seccion->setOrden($orden);
		
		$tabla->insert($seccion->toArray());
	}
	// =====================================================================================>>>   Editar
	public function editarSeccion($idSeccion, Encuesta_Model_Seccion $seccion) {
		$tablaSeccion = $this->tablaSeccion;
		$select = $tablaSeccion->select()->from($tablaSeccion)->where("idSeccion = ?", $idSeccion); 
		$tabla->update($seccion->toArray(), $select);
	}
	// =====================================================================================>>>   Eliminar
	public function eliminarSeccion($idSeccion) {
		$tablaSeccion = $this->tablaSeccion;
		$select = $tablaSeccion->select()->from($tablaSeccion)->where("idSeccion = ?", $idSeccion);
		$tablaSeccion->delete($select);
	}
	
	
}
