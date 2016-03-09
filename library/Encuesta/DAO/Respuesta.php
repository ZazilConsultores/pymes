<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Respuesta implements Encuesta_Interfaces_IRespuesta {
	
	private $tablaCategoria;
	private $tablaOpcion;
	private $tablaRespuesta;
	
	function __construct() {
		$this->tablaCategoria = new Encuesta_Model_DbTable_Categoria;
		$this->tablaOpcion = new Encuesta_Model_DbTable_Opcion;
		$this->tablaRespuesta = new Encuesta_Model_DbTable_Respuesta;
	}
	
	// =====================================================================================>>>   Buscar
	/** Obtiene las respuestas de todos los usuarios en la encuesta **/
	public function obtenerRespuestasEncuesta($idEncuesta){
		$tablaRespuesta = $this->tablaRespuesta;
		$select = $tablaRespuesta->select()->from($tablaRespuesta)->where("idEncuesta = ?", $idEncuesta);
		$rowsRespuestas = $tablaRespuesta->fetchAll($select);
		
		$modelRespuestas = array();
		if(!is_null($rowsRespuestas)) {
			foreach ($rowsRespuestas as $row) {
				$modelRespuesta = new Encuesta_Model_Respuesta($row->toArray());
				
				$modelRespuestas[] = $modelRespuesta;
			}
		}
		//si no hay respuestas para la encuesta seleccionada retorno array vacio
		return $rowsRespuestas;
	}
	public function obtenerIdPreguntasEncuesta($idEncuesta){
		$tablaRespuesta = $this->tablaRespuesta;
		$select = $tablaRespuesta->select()->distinct()->from($tablaRespuesta, "idPregunta")->where("idEncuesta = ?", $idEncuesta);
		$ids = $tablaRespuesta->fetchAll($select);
		
		return $ids->toArray();
	}
	
	public function obtenerIdRegistroEncuesta($idEncuesta){
		$tablaRespuesta = $this->tablaRespuesta;
		$select = $tablaRespuesta->select()->distinct()->from($tablaRespuesta, "idRegistro")->where("idEncuesta = ?", $idEncuesta);
		$ids = $tablaRespuesta->fetchAll($select);
		
		return $ids->toArray();
	}
	/** Obtiene las respuestas de un usuario en la encuesta **/
	public function obtenerRespuestasEncuestaUsuario($idEncuesta, $idRegistro){
		$tablaRespuesta = $this->tablaRespuesta;
		$select = $tablaRespuesta->select()->from($tablaRespuesta)->where("idEncuesta = ?", $idEncuesta)->where("idRegistro = ?", $idRegistro);
		$rowsRespuestas = $tablaRespuesta->fetchAll($select);
		
		$modelRespuestas = array();
		if(!is_null($rowsRespuestas)){
			foreach ($rowsRespuestas as $row) {
				$modelRespuesta = new Encuesta_Model_Respuesta($row->toArray());
				
				$modelRespuestas[] = $modelRespuesta;
			}
		}
		
		return $modelRespuestas;
	}
	// =====================================================================================>>>   Insertar
	public function crearRespuesta($idEncuesta, Encuesta_Model_Respuesta $respuesta){
		$tablaRespuesta = $this->tablaRespuesta;
		$respuesta->setHash($respuesta->getHash());
		$respuesta->setFecha(date("Y-m-d H:i:s", time()));
		
		$tablaRespuesta->insert($respuesta->toArray());
		
		$select = $tablaRespuesta->select()->from($tablaRespuesta)->where("hash=?",$respuesta->getHash());
		$rowRes = $tablaRespuesta->fetchRow($select);
		$modelRespuesta = new Encuesta_Model_Respuesta($rowRes);
		return $modelRespuesta;
	}
	// =====================================================================================>>>   Actualizar
	public function editarRespuesta($idEncuesta, $idRegistro, array $respuesta){
		
	}
	// =====================================================================================>>>   Eliminar
	public function eliminarRespuesta($idRespuesta){
		
	}
}
