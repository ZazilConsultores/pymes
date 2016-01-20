<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Preferencia implements Encuesta_Interfaces_IPreferencia {
	
	private $tablaPregunta;
	private $tablaOpcion;
	
	private $tablaPreferenciaSimple;
	
	function __construct() {
		$this->tablaPregunta = new Encuesta_Model_DbTable_Pregunta;
		$this->tablaOpcion = new Encuesta_Model_DbTable_Opcion;
		
		$this->tablaPreferenciaSimple = new Encuesta_Model_DbTable_PreferenciaSimple;
	}
	
	// =====================================================================================>>>   Buscar
	public function obtenerPreferenciasPregunta($idPregunta){
		$tablaPreferenciaSimple = $this->tablaPreferenciaSimple;
		$select = $tablaPreferenciaSimple->select()->from($tablaPreferenciaSimple)->where("idPregunta = ?", $idPregunta);
		$rowsPreferencias = $tablaPreferenciaSimple->fetchRow($select);
		
		foreach ($rowsPreferencias as $row) {
			
		}
	}
	
	// =====================================================================================>>>   Insertar
	
	// =====================================================================================>>>   Actualizar
	
	// =====================================================================================>>>   Eliminar
	
}
