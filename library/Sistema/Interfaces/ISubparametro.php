<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Sistema_Interfaces_ISubparametro {
	public function obtenerSubparametros($idParametro);
	public function obtenerSubparametro($idParametro);
	public function crearSubparametro(Sistema_Model_Subparametro $subparametro);
	public function editarSubparametro(Sistema_Model_Subparametro $idSubParametro);
	
}
