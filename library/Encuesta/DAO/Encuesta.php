<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Encuesta implements Encuesta_Interfaces_IEncuesta {
	
	private $tablaEncuesta;
	
	function __construct() {
		$this->tablaEncuesta = new Encuesta_Model_DbTable_Encuesta;
	}
	
	//          =========================================================================   >>>   Buscar
	/**
	 * @method obtenerEncuestaId Obtiene una encuesta en base a un id proporcionado.
	 * @param int $idEncuesta
	 * @return Encuesta_Model_Encuesta $encuestaM
	 */
	public function obtenerEncuestaId($idEncuesta) {
		$tablaEncuesta = $this->tablaEncuesta;
		$select = $tablaEncuesta->select()->from($tablaEncuesta)->where("idEncuesta = ?", $idEncuesta);
		$encuesta = $tablaEncuesta->fetchRow($select);
		
		$encuestaM = New Encuesta_Model_Encuesta($encuesta->toArray());
		$encuestaM->setIdEncuesta($encuesta->idEncuesta);
		
		return $encuestaM;
	}
	
	/**
	 * @method obtenerEncuestas Obtiene todas las encuestas existentes.
	 * @return array Encuesta_Model_Encuesta
	 */
	public function obtenerEncuestas() {
		$tablaEncuesta = $this->tablaEncuesta;
		$encuestas = $tablaEncuesta->fetchAll();
		$encuestasArray = array();
		foreach ($encuestas as $encuesta) {
			$encuestaModel = new Encuesta_Model_Encuesta($encuesta->toArray());
			$encuestaModel->setIdEncuesta($$encuesta->idEncuesta);
			
			$encuestasArray[] = $encuestaModel;
		}
		
		return $encuestasArray;
	}
	//          =========================================================================   >>>   Insertar
	
	/**
	 * @method crearEncuesta Crea una encuesta pasandole un model.
	 * @param Encuesta_Model_Encuesta $encuesta
	 */
	public function crearEncuesta(Encuesta_Model_Encuesta $encuesta) {
		$tablaEncuesta = $this->tablaEncuesta;
		$tablaEncuesta->insert($encuesta->toArray());
	}
	//          =========================================================================   >>>   Actualizar
	public function editarEncuesta($idEncuesta, Encuesta_Model_Encuesta $encuesta) {
		$tablaEncuesta = $this->tablaEncuesta;
		$select = $tablaEncuesta->select()->from($tablaEncuesta)->where("idEncuesta = ?", $idEncuesta);
		$tablaEncuesta->update($encuesta->toArray(), $select);
	}
	//          =========================================================================   >>>   Eliminar
	public function eliminarEncuesta($idEncuesta) {
		$tablaEncuesta = $this->tablaEncuesta;
		$select = $tablaEncuesta->select()->from($tablaEncuesta)->where("idEncuesta = ?", $idEncuesta);
		$tablaEncuesta->delete($select);
	}
	
}
