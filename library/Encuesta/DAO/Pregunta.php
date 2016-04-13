<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Pregunta implements Encuesta_Interfaces_IPregunta {
	
	private $tablaSeccion;
	private $tablaGrupo;
	private $tablaPregunta;
	private $tablaPreferenciaSimple;
	
	function __construct() {
		$this->tablaSeccion = new Encuesta_Model_DbTable_Seccion;
		$this->tablaGrupo = new Encuesta_Model_DbTable_Grupo;
		$this->tablaPregunta = new Encuesta_Model_DbTable_Pregunta;
		$this->tablaPreferenciaSimple = new Encuesta_Model_DbTable_PreferenciaSimple;
	}
	// =====================================================================================>>>   Buscar
	public function obtenerPregunta($idPregunta) {
		$tabla = $this->tablaPregunta;
		
		$select = $tabla->select()->from($tabla)->where("idPregunta = ?", $idPregunta);
		$rowPregunta = $tabla->fetchRow($select);
		$modelPregunta = new Encuesta_Model_Pregunta($rowPregunta->toArray());
		
		return $modelPregunta;
	}
	
	public function obtenerPreguntaHash($hash){
		$tabla = $this->tablaPregunta;
		
		$select = $tabla->select()->from($tabla)->where("hash = ?", $hash);
		$rowPregunta = $tabla->fetchRow($select);
		$modelPregunta = new Encuesta_Model_Pregunta($rowPregunta->toArray());
		
		return $modelPregunta;
	}
	
	public function obtenerPreguntasEncuesta($idEncuesta){
		$tabla = $this->tablaPregunta;
		$select = $tabla->select()->from($tabla)->where("idEncuesta=?",$idEncuesta)->order(array("idPregunta ASC"));
		$rowPreguntas = $tabla->fetchAll($select);
		$modelPreguntas = array();
		foreach ($rowPreguntas as $row) {
			$modelPregunta = new Encuesta_Model_Pregunta($row->toArray());
			$modelPreguntas[] = $modelPregunta;
		}
		
		return $modelPreguntas;
	}
	
	public function obtenerPreguntasAbiertasEncuesta($idEncuesta){
		$tablaPregunta = $this->tablaPregunta;
		$select = $tablaPregunta->select()->from($tablaPregunta)->where("tipo=?","AB")->where("idEncuesta=?",$idEncuesta);
		$preguntas = $tablaPregunta->fetchAll($select);
		if(is_null($preguntas)) throw new Util_Exception_BussinessException("Error: No hay preguntas abiertas en esta encuesta", 1);
		
		return $preguntas->toArray();
	}
	// =====================================================================================>>>   Crear
	public function crearPregunta($idPadre, $tipoPadre, Encuesta_Model_Pregunta $pregunta) {
			
		if($tipoPadre === "S"){
			$tablaSeccion = $this->tablaSeccion;
			$select = $tablaSeccion->select()->from($tablaSeccion)->where("idSeccion = ?", $idPadre);
			$rowSeccion = $tablaSeccion->fetchRow($select);
			
			$rowSeccion->elementos++;
			$rowSeccion->save();
			$pregunta->setOrden($rowSeccion->elementos);
			
		}elseif($tipoPadre === "G"){
			$tablaGrupo = $this->tablaGrupo;
			$select = $tablaGrupo->select()->from($tablaGrupo)->where("idGrupo = ?", $idPadre);
			$rowGrupo = $tablaGrupo->fetchRow($select);
			
			$rowGrupo->elementos++;
			$pregunta->setOpciones($rowGrupo->opciones);
			$pregunta->setOrden($rowGrupo->elementos);
			
			$rowGrupo->save();
		}
		
		$pregunta->setHash($pregunta->getHash());
		$pregunta->setFecha(date("Y-m-d H:i:s", time()));
		
		$tablaPregunta = $this->tablaPregunta;
		$tablaPregunta->insert($pregunta->toArray());
		
		$pregunta = $this->obtenerPreguntaHash($pregunta->getHash());
		return $pregunta;
	}
	// =====================================================================================>>>   Editar
	public function editarPregunta($idPregunta, array $pregunta) {
		$tablaPregunta = $this->tablaPregunta;
		$where = $tablaPregunta->getAdapter()->quoteInto("idPregunta = ?", $idPregunta);
		
		$tablaPregunta->update($pregunta, $where);
	}
	// =====================================================================================>>>   Eliminar
	public function eliminarPregunta($idPregunta) {
		//Primero eliminamos de la tabla preferencia simple
		$tablaPreferenciaSimple = $this->tablaPreferenciaSimple;
		$where = $tablaPreferenciaSimple->getAdapter()->quoteInto("idPregunta = ?", $idPregunta);
		try{
			$tablaPreferenciaSimple->delete($where);
		}catch(Exception $ex){
			
		}
		
		$tablaPregunta = $this->tablaPregunta;
		$where = $tablaPregunta->getAdapter()->quoteInto("idPregunta = ?", $idPregunta);
		
		$tablaPregunta->delete($where);
	}
	
	
}