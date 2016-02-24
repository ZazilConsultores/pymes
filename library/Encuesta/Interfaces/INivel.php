<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Encuesta_Interfaces_INivel{
	// =====================================================================================>>>   Buscar
	public function obtenerNiveles();
	public function crearNivel(Encuesta_Model_Nivel $nivel);
	public function editarNivel($idNivel, array $datos);
	public function eliminarNivel($idNivel);
}
