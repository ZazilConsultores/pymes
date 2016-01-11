<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Encuesta implements Zazil_Interfaces_IEncuesta {
	
	private $tablaEncuesta;
	
	function __construct() {
		$this->tablaEncuesta = new Encuesta_Model_DbTable_Encuesta;
	}
	
	//          =========================================================================   >>>   Buscar
	/**
	 * @method obtenerEncuestaId Obtiene una encuesta en base a un id proporcionado.
	 * @param int $idEncuesta
	 * @return Zazil_Model_Encuesta $encuestaM
	 */
	public function obtenerEncuestaId($idEncuesta) {
		$tabla = $this->tablaEncuesta;
		$select = $tabla->select()->from($tabla)->where("idEncuesta = ?", $idEncuesta);
		$encuesta = $tabla->fetchRow($select);
		
		$encuestaM = New Zazil_Model_Encuesta($encuesta->toArray());
		return $encuestaM;
	}
	
	/**
	 * @method obtenerEncuestas Obtiene todas las encuestas existentes.
	 * @return array Zazil_Model_Encuesta
	 */
	public function obtenerEncuestas() {
		$tabla = $this->tablaEncuesta;
		$encuestas = $tabla->fetchAll();
		$encuestasArray = array();
		foreach ($encuestas as $encuesta) {
			$encuestaModel = new Zazil_Model_Encuesta($encuesta->toArray());
			$encuestasArray[] = $encuestaModel;
		}
		
		return $encuestasArray;
	}
	//          =========================================================================   >>>   Insertar
	
	/**
	 * @method crearEncuesta Crea una encuesta pasandole un model.
	 * @param Zazil_Model_Encuesta $encuesta
	 */
	public function crearEncuesta(Zazil_Model_Encuesta $encuesta) {
		$tabla = $this->tablaEncuesta;
		$tabla->insert($encuesta->toArray());
	}
	//          =========================================================================   >>>   Actualizar
	public function editarEncuesta($idEncuesta, Zazil_Model_Encuesta $encuesta) {
		$tabla = $this->tablaEncuesta;
		$select = $tabla->select()->from($tabla)->where("idEncuesta = ?", $idEncuesta);
		$tabla->update($encuesta->toArray(), $select);
	}
	//          =========================================================================   >>>   Eliminar
	public function eliminarEncuesta($idEncuesta) {
		$tabla = $this->tablaEncuesta;
		$select = $tabla->select()->from($tabla)->where("idEncuesta = ?", $idEncuesta);
		$tabla->delete($select);
	}
	
}
