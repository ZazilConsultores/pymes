<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Encuesta_Interfaces_IRegistro{
	// =====================================================================================>>>   Buscar
	public function obtenerRegistro($idRegistro);
	public function obtenerRegistros();
	// =====================================================================================>>>   Insertar
	public function crearRegistro(Encuesta_Model_Registro $registro);
	// =====================================================================================>>>   Actualizar
	public function editarRegistro($idRegistro, array $registro);
	// =====================================================================================>>>   Eliminar
	public function eliminarRegistro($idRegistro);
	
}
