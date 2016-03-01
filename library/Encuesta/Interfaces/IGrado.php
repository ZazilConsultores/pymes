<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Encuesta_Interfaces_IGrado{
	// =====================================================================================>>>   Buscar
	public function obtenerGrados($idNivel);
	public function crearGrado(Encuesta_Model_Grado $grado);
	public function editarGrado($idGrado, array $datos);
	public function eliminarGrado($idGrado);
}
