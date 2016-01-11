<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Seccion implements Zazil_Interfaces_ISeccion {
	
	private $tablaEncuesta;
	private $encuestaDAO;
	private $tablaSeccion;
	
	private $preguntaDAO;
	private $grupoDAO;
	
	function __construct() {
		$this->tablaEncuesta = new Encuesta_Model_DbTable_Encuesta;
		$this->tablaSeccion = new Encuesta_Model_DbTable_Seccion;
		$this->encuestaDAO = new Encuesta_DAO_Encuesta;
		
		$this->grupoDAO = new Encuesta_DAO_Grupo;
		$this->preguntaDAO = new Encuesta_DAO_Pregunta;
	}
	// =====================================================================================>>>   Buscar
	public function obtenerSeccionId($idSeccion) {
		$tabla = $this->tablaSeccion;
		
		$select = $tabla->select()->from($tabla)->where("idSeccion = ?", $idSeccion);
		$seccion = $tabla->fetchRow($select);
		
		$seccionM = new Zazil_Model_Seccion($seccion->toArray());
		
		return $seccionM;
	}
	
	public function obtenerSecciones($idEncuesta) {
		$tabla = $this->tablaSeccion;
		$select = $tabla->select()->from($tabla)->where("idEncuesta = ?", $idEncuesta);
		
		$secciones = $tabla->fetchAll($select);
		$arraySecciones = array();
		
		foreach ($secciones as $seccion) {
			$secM = new Zazil_Model_Seccion($seccion->toArray());
			$arraySecciones[] = $secM;
		}
		
		return $arraySecciones;
	}
	
	public function obtenerElementos($idSeccion) {
		$grupoDAO = $this->grupoDAO;
		$preguntaDAO = $this->preguntaDAO;
		$elementos = array();
		
		$grupos = $grupoDAO->obtenerGrupos($idSeccion);
		$preguntas = $preguntaDAO->obtenerPreguntas($idSeccion, "seccion");
		foreach ($grupos as $grupo) {
			$elementos[$grupo->getOrden()] = $grupo;
		}
		
		foreach ($preguntas as $pregunta) {
			$elementos[$pregunta->getOrden()] = $pregunta;
		}
		ksort($elementos);
		
		return $elementos;
	}
	// =====================================================================================>>>   Crear
	public function crearSeccion(Zazil_Model_Seccion $seccion) {
		//primero buscamos todas las secciones asociadas con la encuesta, si no hay esta se designa como la seccion 0
		$tabla = $this->tablaSeccion;
		//Seleccionamos todas las secciones de la encuesta
		$select = $tabla->select()->from($tabla)->where("idEncuesta = ?", $seccion->getIdEncuesta());
		$orden = count($tabla->fetchAll($select));
		$orden++;
		$seccion->setOrden($orden);
		
		$tabla->insert($seccion->toArray());
	}
	// =====================================================================================>>>   Editar
	public function editarSeccion($idSeccion, Zazil_Model_Seccion $seccion) {
		$tabla = $this->tablaSeccion;
		$select = $tabla->select()->from($tabla)->where("idSeccion = ?", $idSeccion); 
		$tabla->update($seccion->toArray(), $select);
	}
	// =====================================================================================>>>   Eliminar
	public function eliminarSeccion($idSeccion) {
		$tabla = $this->tablaSeccion;
		$select = $tabla->select()->from($tabla)->where("idSeccion = ?", $idSeccion);
		$tabla->delete($select);
	}
	
	
}
