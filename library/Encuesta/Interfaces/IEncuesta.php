<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Encuesta_Interfaces_IEncuesta{
	// =====================================================================================>>>   Buscar
	public function obtenerEncuesta($idEncuesta);
	public function obtenerEncuestas();
	// =====================================================================================>>>   Insertar
	public function crearEncuesta(Encuesta_Model_Encuesta $encuesta);
	// =====================================================================================>>>   Actualizar
	public function editarEncuesta($idEncuesta, Encuesta_Model_Encuesta $encuesta);
	// =====================================================================================>>>   Eliminar
	public function eliminarEncuesta($idEncuesta);
	
}
