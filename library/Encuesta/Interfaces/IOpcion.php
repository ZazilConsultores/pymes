<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Encuesta_Interfaces_IOpcion{
	// =====================================================================================>>>   Buscar
	public function obtenerOpcion($idOpcion);
	public function obtenerOpcionHash($hash);
	public function obtenerOpcionesCategoria($idCategoria);
	// =========================================== Pregunta y Grupo
	public function obtenerOpcionesPregunta($idPregunta);
	public function obtenerOpcionesGrupo($idGrupo);
	// =====================================================================================>>>   Insertar
	public function crearOpcion($idCategoria, Encuesta_Model_Opcion $opcion);
	// =====================================================================================>>>   Actualizar
	public function editarOpcion($idCategoria, array $opcion);
	// =====================================================================================>>>   Eliminar
	public function eliminarOpcion($idOpcion);
	// =====================================================================================>>>   Asociar con Pregunta y Grupo
	public function asociarOpcionesPregunta($idPregunta, array $opciones);
	public function asociarOpcionesGrupo($idGrupo, array $opciones);
}
