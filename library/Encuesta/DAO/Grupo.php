<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Grupo implements Encuesta_Interfaces_IGrupo {
	
	private $tablaSeccion;
	private $tablaGrupo;
	private $tablaPreguntas;
		
	function __construct() {
		$this->tablaSeccion = new Encuesta_Model_DbTable_Seccion;
		$this->tablaGrupo = new Encuesta_Model_DbTable_Grupo;
		$this->tablaPregunta = new Encuesta_Model_DbTable_Pregunta;
		
	}
	
	public function obtenerGrupoId($idGrupo) {
		$tablaGrupo = $this->tablaGrupo;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("idGrupo = ?", $idGrupo);
		$grupo = $tablaGrupo->fetchRow($select);
		$grupoM = new Zazil_Model_Grupo($grupo->toArray());
		return $grupoM;
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
	
	public function editarGrupo($idGrupo, Zazil_Model_Grupo $grupo) {
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
	
	public function obtenerGrupos($idSeccion) {
		$tablaGrupo = $this->tablaGrupo;
		$select = $tablaGrupo->select()->from($tablaGrupo)->where("idSeccion = ?", $idSeccion);
		$grupos = $tablaGrupo->fetchAll($select);
		$gruposM = array();
		foreach ($grupos as $grupo) {
			$grupoM = new Zazil_Model_Grupo($grupo->toArray());
			//print_r($grupo->toArray());
			//print_r($grupoM);
			$gruposM[] = $grupoM;
		} 
		return $gruposM;
	}
}
