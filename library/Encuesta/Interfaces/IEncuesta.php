<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Encuesta_Interfaces_IEncuesta{
	// =====================================================================================>>>   Buscar
	// ============================================================= Simple elemento
	public function obtenerEncuesta($idEncuesta);
	public function obtenerEncuestaHash($hash);
	// ============================================================= Conjunto de elementos
	public function obtenerEncuestas();
	public function obtenerEncuestasGrupo($idGrupo);
	public function obtenerSecciones($idEncuesta);
	public function obtenerPreguntas($idEncuesta);
	public function obtenerNumeroEncuestasRealizadas($idEncuesta, $idAsignacion);
	public function obtenerEncuestaRealizadaPorAsignacion($idAsignacion);
	public function obtenerEncuestasRealizadasPorAsignacion($idAsignacion);
	public function obtenerEncuestasVigentesRealizadas();
	//public function obtenerEncuestasRealizadasPorProfesor($idAsignacion);
	public function obtenerGruposEncuesta($idEncuesta);
	// =====================================================================================>>>   Insertar
	public function crearEncuesta(Encuesta_Model_Encuesta $encuesta);
	public function agregarEncuestaGrupo(array $registro);
	public function agregarEncuestaRealizada(array $registro);
	// =====================================================================================>>>   Actualizar
	public function editarEncuesta($idEncuesta, array $encuesta);
	// =====================================================================================>>>   Eliminar
	public function eliminarEncuesta($idEncuesta);
	// =====================================================================================>>>   Normalizar Preferencia
	public function normalizarPreferenciaAsignacion($idEncuesta, $idAsignacion);
	
}
