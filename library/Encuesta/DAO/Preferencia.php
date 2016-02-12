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
	
	// =====================================================================================>>>   Insertar
	public function agregarPreferenciaPregunta($idPregunta, $idOpcion){
		$tablaPS = $this->tablaPreferenciaSimple;
		$select = $tablaPS->select()->from($tablaPS)->where("idPreferencia = ?", $idPregunta)->where("idOpcion = ?", $idOpcion);
		$rowPreferencia = $tablaPS->fetchRow($select);
		
		if(is_null($rowPreferencia)){
			$objPreferencia = array();
			$objPreferencia["idPregunta"] = $idPregunta;
			$objPreferencia["idOpcion"] = $idOpcion;
			$objPreferencia["preferencia"] = 1;
			
			$tablaPS->insert($objPreferencia);
		}else{
			$rowPreferencia->preferencia++;
			$rowPreferencia->save();
		}
		
		
		
	}
	// =====================================================================================>>>   Actualizar
	
	// =====================================================================================>>>   Eliminar
	
}
