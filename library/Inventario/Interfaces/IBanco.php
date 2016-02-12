<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Inventario_Interfaces_IBanco{
		
	public function obtenerBancos();
	public function crearBanco(Contabilidad_Model_Banco $idBanco);
	public function editarBanco($idBanco);
	public function eliminarBanco($idBanco);
	
}
