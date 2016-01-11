<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Pregunta implements Zazil_Interfaces_IPregunta {
	
	private $tablaSeccion;
	private $tablaGrupo;
	private $tablaPregunta;
	
	private $tablaPreguntasSeccion;
	private $tablaPreguntasGrupo;
	
	function __construct() {
		$this->tablaSeccion = new Application_Model_DbTable_Seccion;
		$this->tablaGrupo = new Application_Model_DbTable_Grupo;
		$this->tablaPregunta = new Application_Model_DbTable_Pregunta;
		
		$this->tablaPreguntasSeccion = new Application_Model_DbTable_PreguntasSeccion;
		$this->tablaPreguntasGrupo = new Application_Model_DbTable_PreguntasGrupo;
	}
	
	public function obtenerPreguntaId($idPregunta) {
		$tabla = $this->tablaPregunta;
		
		$select = $tabla->select()->from($tabla)->where("idPregunta = ?", $idPregunta);
		$pregunta = $tabla->fetchRow($select);
		$preguntaM = new Zazil_Model_Pregunta($pregunta->toArray());
		
		return $preguntaM;
	}
	
	public function crearPregunta($idPadre, $tipoPadre, Zazil_Model_Pregunta $pregunta) {
		$tablaSeccion = $this->tablaSeccion;
		$tablaGrupo = $this->tablaGrupo;
		
		$tabla = null;
		$tablaPregunta = $this->tablaPregunta;
		
		$registro = array();
		$registro["idPregunta"] = $pregunta->getIdPregunta();
		$numeroPreguntas = null;
		switch ($tipoPadre) {
			case 'seccion':	//Aqui se crean las preguntas de la seccion
				$tabla = $this->tablaPreguntasSeccion;
				$registro["idSeccion"] = $idPadre;
				
				$select = $tablaSeccion->select()->from($tablaSeccion)->where("idSeccion = ?", $idPadre);
				$seccion = $tablaSeccion->fetchRow($select);
				$numeroPreguntas = $seccion->elementos;
				$seccion->elementos++;
				$seccion->save();
				//$numeroPreguntas = count($this->obtenerPreguntas($idPadre, "seccion"));
				break;
			case 'grupo': //aqui se crean las preguntas del grupo
				$tabla = $this->tablaPreguntasGrupo;
				$registro["idGrupo"] = $idPadre;
				
				$select = $tablaGrupo->select()->from($tablaGrupo)->where("idGrupo = ?", $idPadre);
				$grupo = $tablaGrupo->fetchRow($select);
				$numeroPreguntas = $grupo->elementos;
				$grupo->elementos++;
				$grupo->save();
				//$numeroPreguntas = count($this->obtenerPreguntas($idPadre, "grupo"));
				break;
		}
		$pregunta->setOrden($numeroPreguntas);
		//print_r($registro);
		//print_r($numeroPreguntas);
		//print_r("<br />");
		//print_r($pregunta->toArray());
		$tablaPregunta->insert($pregunta->toArray());
		$tabla->insert($registro);
		//$tabla->insert($registro);
		//$tablaPregunta->insert($pregunta->toArray());
	}
	
	public function editarPregunta($idPadre, $tipoPadre, Zazil_Model_Pregunta $pregunta) {
		$tabla = $this->tablaPregunta;
		
		$select = $tabla->select()->from($tabla)->where("idPregunta = ?", $pregunta->getIdPregunta());
		//$pregunta = $tabla->fetchRow($select);
		//$preguntaM = new Zazil_Model_Pregunta($pregunta->toArray());
		$tabla->update($pregunta, $select);
		//return $preguntaM;
	}
	
	public function eliminarPregunta($idPadre, $tipoPadre, $idPregunta) {
		$tabla = null;
		$tablaPregunta = $this->tablaPregunta;
		//$registro = array();
		//$registro["idPregunta"] = $idPregunta;
		switch ($tipoPadre) {
			case 'seccion':
				$tabla = $this->tablaPreguntasSeccion;
				//$registro["idSeccion"] = $idPadre;
				break;
			case 'grupo':
				$tabla = $this->tablaPreguntasGrupo;
				//$registro["idGrupo"] = $idPadre;
				break;
		}
		$where = $tabla->select()->from($tabla)->where("idPregunta = ?", $idPregunta);
		$whereP = $tablaPregunta->select()->from($tablaPregunta)->where("idPregunta = ?", $tablaPregunta);
		$tabla->delete($where);
		$tablaPregunta->delete($whereP);
		//$tabla->insert($registro);
		//$tablaPregunta->insert($pregunta->toArray());
	}
	
	public function obtenerPreguntas($idPadre, $tipoPadre) {
		$tablaPregunta = $this->tablaPregunta;
		$tabla = null;
		$condicion = "pregunta.idPregunta = t.idPregunta";
		switch ($tipoPadre) {
			case 'seccion':
				$tabla = "preguntasseccion";
				break;
			case 'grupo':
				$tabla = "preguntasgrupo";
				break;
		}
		
		$select = $tablaPregunta->select()
			->setIntegritycheck(FALSE)
			->from($tablaPregunta, array("idPregunta", "nombre", "orden", "tipo"))
			->join(array('t' => $tabla), $condicion, array())
			->where("id".ucfirst($tipoPadre)." = ?", $idPadre)
			->order("orden");
		//print_r($select->__toString());
		
		$preguntas = $tablaPregunta->fetchAll($select);
		
		$preguntasM = array();
		foreach ($preguntas as $pregunta) {
			$preguntaM = new Zazil_Model_Pregunta($pregunta->toArray());
			$preguntasM[] = $preguntaM;
		}
		
		return $preguntasM;
	}
}