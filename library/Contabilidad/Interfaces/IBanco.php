<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Contabilidad_Interfaces_IBanco{
		
	public function obtenerBancos();
	public function obtenerBanco($idBanco);
	public function crearBanco(array $datos);
	public function altaBancoEmpresa(array $datos);
	public function editarBanco($idBanco,array $banco);
	public function eliminarBanco($idBanco);
	public function obtenerBancosEmpresa($idEmpresa);
	
	public function obtenerBancosEmpresasFondeo(Contabilidad_Model_Banco $banco);
	
}
