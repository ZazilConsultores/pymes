<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Encuesta_Interfaces_IPreferencia {
	// =====================================================================================>>>   Buscar
	public function obtenerPreferenciasPregunta($idPregunta);
	
	
	// =====================================================================================>>>   Insertar
	public function crearPreferenciaPregunta($idPregunta, Encuesta_Model_PreferenciaSimple $preferencia);
	// =====================================================================================>>>   Actualizar
	
	// =====================================================================================>>>   Eliminar
	
	
}
