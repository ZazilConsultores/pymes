<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Preferencia implements Encuesta_Interfaces_IPreferencia {
	
	private $tablaGrupo;
	private $tablaPregunta;
	private $tablaOpcion;
	
	private $tablaPreferenciaSimple;
	
	function __construct() {
		$this->tablaGrupo = new Encuesta_Model_DbTable_Grupo;
		$this->tablaPregunta = new Encuesta_Model_DbTable_Pregunta;
		$this->tablaOpcion = new Encuesta_Model_DbTable_Opcion;
		
		$this->tablaPreferenciaSimple = new Encuesta_Model_DbTable_PreferenciaSimple;
	}
	
	// =====================================================================================>>>   Buscar
	public function obtenerPreferenciasPregunta($idEncuesta,$idGrupo){
		$tablaPregunta = $this->tablaPregunta;
		$select = $tablaPregunta->select()->from($tablaPregunta)->where("idEncuesta=?",$idEncuesta);
		$rowPreguntas = $tablaPregunta->fetchAll($select);
		
		$tablaPreferenciaSimple = $this->tablaPreferenciaSimple;
		
		$arrayPreguntas = array();
		foreach ($rowPreguntas as $row) {
			$obj = array();
			$obj["idPregunta"] = $row->idPregunta;
			if($row->tipo == "SS"){
				$opts = explode(",", $row->opciones);
				
				$preferencias = array();
				//Iteramos en las preferencias
				foreach ($rowsPreferencias as $row) {
					$preferencia = array();
					
					$preferencia["value"] = $row->preferencia;
					$preferencia["color"] = sprintf('#%06X', mt_rand(0, 0xFFFFFF)); //sprintf('#%06X', mt_rand(0, 0xFFFFFF)) //substr(md5(time()), 0, 6)
					$preferencia["highlight"] = sprintf('#%06X', mt_rand(0, 0xFFFFFF)); //sprintf('#%06X', mt_rand(0, 0xFFFFFF))
					$preferencia["label"] = $opcionDAO->obtenerOpcion($row->idOpcion)->getOpcion();
					
					//$preferencias[$row->idOpcion] = json_encode($preferencias);
					$preferencias[] = $preferencia;
				}
				
				
				foreach ($opts as $opt) {
					
				}
				
			}
		}
		
	}

	/**
	 * Obtiene un array sin procesar de las preferencias del conjunto de preguntas especificado por $idGrupo
	 */
	public function obtenerPreferenciaCategoria($idAsignacion, $idGrupo){
		$grupoDAO = new Encuesta_DAO_Grupo;
		$preguntasGrupo = $grupoDAO->obtenerPreguntas($idGrupo);
		
		
		
		
	}
	
	/**
	 * Obtiene las preferencias de una asignacion (idGrupo,idMateria,idProfesor)
	 */
	public function obtenerPreferenciaAsignacion($idAsignacion){
		$tablaPreferencia = $this->tablaPreferenciaSimple;
		$select = $tablaPreferencia->select()->from($tablaPreferencia)->where("idAsignacion=?",$idAsignacion)->order(array("idPregunta ASC"));
		$rowPreferencias = $tablaPreferencia->fetchAll($select);
		
		$objPreferencias = array();
		foreach ($rowPreferencias as $row) {
			$objPreferencias[] = $row->toArray();
		}
		
		return $objPreferencias;
	}
	
	/**
	 * Obtiene un array de las preferencias de la pregunta.
	 */
	public function obtenerPreferenciaPregunta($idPregunta,$idAsignacion){
		$tablaPreferencia = $this->tablaPreferenciaSimple;
		$select = $tablaPreferencia->select()->from($tablaPreferencia)->where("idPregunta=?",$idPregunta)->where("idAsignacion=?",$idAsignacion);
		$rowsPreferencia = $tablaPreferencia->fetchAll($select);
		$objPreferencia = array();
		
		foreach ($rowsPreferencia as $row) {
			$objPreferencia[] = $row->toArray();
		}
		
		return $objPreferencia;
	}
	
	/**
	 * Obtiene el valor total de preferencia de una categoria 
	 */
	public function obtenerTotalCategoria($idEncuesta, $idGrupo, $idConjunto){
		$tablaPreferenciaS = $this->tablaPreferenciaSimple;
		$grupoDAO = new Encuesta_DAO_Grupo;
		$preguntasConjunto = $grupoDAO->obtenerPreguntas($idConjunto);
		$total = 0;
		foreach ($preguntasConjunto as $pregunta) {
			$preferencias = $this->obtenerPreferenciaPregunta($pregunta->getIdPregunta(), $idGrupo);
			foreach ($preferencias as $preferencia) {
				$total += $preferencia["total"];
			}
		}
		
		print_r($total);
	}
	
	/**
	 * Obtenemos las 
	 */
	public function obtenerTotalPreferenciaGrupo($idGrupo, $idAsignacion){
		$tablaPregunta = $this->tablaPregunta;
		$tablaPreferenciaS = $this->tablaPreferenciaSimple;
		
		$totalCategoria = 0;
		
		$select = $tablaPregunta->select()->from($tablaPregunta)->where("origen=?","G")->where("idOrigen=?",$idGrupo);
		$preguntasGrupo = $tablaPregunta->fetchAll($select);
		foreach ($preguntasGrupo as $pregunta) {
			$select = $tablaPreferenciaS->select()->from($tablaPreferenciaS)->where("idPregunta=?",$pregunta["idPregunta"])->where("idAsignacion=?",$idAsignacion);
			$preferencias = $tablaPreferenciaS->fetchAll($select);
			foreach ($preferencias as $preferencia) {
				$totalCategoria += $preferencia["total"];
			}
		}
		
		return $totalCategoria;
	}
	// =====================================================================================>>>   Insertar
	public function agregarPreferenciaPregunta($idPregunta,$idOpcion,$idGrupo){
		$tablaPS = $this->tablaPreferenciaSimple;
		$select = $tablaPS->select()->from($tablaPS)->where("idPregunta = ?", $idPregunta)->where("idOpcion = ?", $idOpcion)->where("idGrupo=?",$idGrupo);
		$rowPreferencia = $tablaPS->fetchRow($select);
		
		if(is_null($rowPreferencia)){
			$objPreferencia = array();
			$objPreferencia["idPregunta"] = $idPregunta;
			$objPreferencia["idOpcion"] = $idOpcion;
			$objPreferencia["idGrupo"] = $idGrupo;
			$objPreferencia["preferencia"] = 1;
			
			$tablaPS->insert($objPreferencia);
		}else{
			$rowPreferencia->preferencia++;
			$rowPreferencia->save();
		}
		
		
		
	}
	
	/**
	 * 
	 */
	public function agregarPreferenciaPreguntaAsignacion($idAsignacion,$idPregunta,$idOpcion){
		$tablaPS = $this->tablaPreferenciaSimple;
		$select = $tablaPS->select()->from($tablaPS)->where("idPregunta = ?", $idPregunta)->where("idOpcion = ?", $idOpcion)->where("idAsignacion=?",$idAsignacion);
		$rowPreferencia = $tablaPS->fetchRow($select);
		//Si no existe registro previo iniciamos uno nuevo
		if(is_null($rowPreferencia)){
			$datos = array();
			$datos["idAsignacion"] = $idAsignacion;
			$datos["idPregunta"] = $idPregunta;
			$datos["idOpcion"] = $idOpcion;
			$datos["preferencia"] = 1;
			
			$opcionDAO = new Encuesta_DAO_Opcion;
			$modelOpcion = $opcionDAO->obtenerOpcion($idOpcion);
			
			$datos["total"] = $modelOpcion->getVreal();
			
			try{
				$tablaPS->insert($datos);
			}catch(Exception $ex){
				throw new Util_Exception_BussinessException("Error: ".$ex->getMessage());
			}
			
		}else{ // Ya existe registro, agregamos 1+ y recalculamos el total
			$rowPreferencia->preferencia++;
			$valor = $rowPreferencia->total / $rowPreferencia->preferencia;
			$rowPreferencia->total + $valor;
			$rowPreferencia->save();
		}
	}
	// =====================================================================================>>>   Actualizar
	
	// =====================================================================================>>>   Eliminar
	
}
