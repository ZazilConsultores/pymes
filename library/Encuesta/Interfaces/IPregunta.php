<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Encuesta_Interfaces_IPregunta{
	// =====================================================================================>>>   Buscar
	public function obtenerPregunta($idPregunta);
	public function obtenerPreguntaHash($hash);
	public function obtenerPreguntas($idPadre, $tipoPadre);
	// =====================================================================================>>>   Crear
	public function crearPregunta($idPadre, $tipoPadre, Encuesta_Model_Pregunta $pregunta);
	//public function crearPreguntaGrupo($idGrupo, Encuesta_Model_Pregunta $pregunta);
	//public function crearPreguntaSeccion($idSeccion, Encuesta_Model_Pregunta $pregunta);
	// =====================================================================================>>>   Editar
	public function editarPregunta($idPregunta, Encuesta_Model_Pregunta $pregunta);
	//public function editarPreguntaSeccion($idPadre, $tipoPadre, Encuesta_Model_Pregunta $pregunta);
	// =====================================================================================>>>   Eliminar
	public function eliminarPregunta($idPregunta);
	//public function eliminarPreguntaSeccion($idSeccion, $idPregunta);
}
