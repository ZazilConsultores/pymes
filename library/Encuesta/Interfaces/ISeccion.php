<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Encuesta_Interfaces_ISeccion{
	// =====================================================================================>>>   Buscar
	public function obtenerSeccion($idSeccion);
	public function obtenerSeccionHash($hash);
	
	//public function obtenerSecciones($idEncuesta);
	//public function obtenerElementos($idEncuesta);
	
	public function obtenerPreguntas($idSeccion);
	public function obtenerGrupos($idSeccion);
	// =====================================================================================>>>   Crear
	public function crearSeccion(Encuesta_Model_Seccion $seccion);
	// =====================================================================================>>>   Editar
	public function editarSeccion($idSeccion, array $seccion);
	// =====================================================================================>>>   Eliminar
	public function eliminarSeccion($idSeccion);
	
	public function eliminarPreguntas($idSeccion);
	public function eliminarGrupos($idSeccion);
	
}
