<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Encuesta_Interfaces_IGrupo{
	// =====================================================================================>>>   Buscar
	public function obtenerGrupoId($idGrupo);
	public function obtenerGrupos($idSeccion);
	// =====================================================================================>>>   Crear
	public function crearGrupo(Zazil_Model_Grupo $grupo);
	// =====================================================================================>>>   Editar
	public function editarGrupo($idGrupo, Zazil_Model_Grupo $grupo);
	// =====================================================================================>>>   Eliminar
	public function eliminarGrupo($idGrupo);
}
