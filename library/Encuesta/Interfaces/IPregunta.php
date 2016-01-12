<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Encuesta_Interfaces_IPregunta{
	// =====================================================================================>>>   Buscar
	public function obtenerPreguntaId($idPregunta);
	public function obtenerPreguntas($idPadre, $tipoPadre);
	// =====================================================================================>>>   Crear
	public function crearPregunta($idPadre, $tipoPadre, Encuesta_Model_Pregunta $pregunta);
	// =====================================================================================>>>   Editar
	public function editarPregunta($idPadre, $tipoPadre, Encuesta_Model_Pregunta $pregunta);
	// =====================================================================================>>>   Eliminar
	public function eliminarPregunta($idPadre, $tipoPadre, $idPregunta);
}
