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
	public function obtenerOpciones();
	// =====================================================================================>>>   Insertar
	public function crearOpcion(Encuesta_Model_Opcion $opcion);
	// =====================================================================================>>>   Actualizar
	public function editarOpcion($idCategoria, Encuesta_Model_Opcion $opcion);
	// =====================================================================================>>>   Eliminar
	public function eliminarOpcion($idOpcion);
}
