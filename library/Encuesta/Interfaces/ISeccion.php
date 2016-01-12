<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Encuesta_Interfaces_ISeccion{
	// =====================================================================================>>>   Buscar
	public function obtenerSeccionId($idSeccion);
	public function obtenerSecciones($idEncuesta);
	public function obtenerElementos($idEncuesta);
	// =====================================================================================>>>   Crear
	public function crearSeccion(Encuesta_Model_Seccion $seccion);
	// =====================================================================================>>>   Editar
	public function editarSeccion($idSeccion, Encuesta_Model_Seccion $seccion);
	// =====================================================================================>>>   Eliminar
	public function eliminarSeccion($idSeccion);
	
}
