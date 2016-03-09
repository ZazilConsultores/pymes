<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Encuesta_Interfaces_IGrupos {
	
	public function obtenerGrupos($idGrado,$idCiclo);
	public function obtenerGrupo($idGrupo);
	public function crearGrupo($idGrado,$idCiclo,Encuesta_Model_Grupoe $grupo);
	public function obtenerDocentes($idGrupo);
	public function agregarDocenteGrupo(array $registro);
}
